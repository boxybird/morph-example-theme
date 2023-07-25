<?php

[$cart_count, $cart_items, $cart_total, $should_hard_refresh] = morph_render(new class {
    public int $cart_count;
    
    public array $cart_items;
    
    public string $cart_total;

    public string $should_hard_refresh = 'false';

    public function __construct()
    {
        $this->cart_total = WC()->cart->get_cart_total();

        $this->cart_count = WC()->cart->get_cart_contents_count();

        $this->should_hard_refresh = is_cart() || is_checkout() ? 'true' : 'false';

        $this->cart_items = waffle_collection(WC()->cart->get_cart())
            ->map(function ($item) {
                $product = wc_get_product($item['data']->get_id());

                return [
                    'id'        => $item['product_id'],
                    'name'      => $product->get_name(),
                    'price'     => $product->get_price(),
                    'quantity'  => $item['quantity'],
                    'image'     => $product->get_image(),
                    'permalink' => $product->get_permalink(),
                ];
            })
            ->sortBy('price')
            ->toArray();
    }

    public function delete($cart_item_id)
    {
        WC()->cart->remove_cart_item($cart_item_id);
    }
});
?>

<style>
    .custom-class {
        opacity: 0;
        transform: translateX(-100%);
        transition: all 300ms ease-in-out;
    }

    .custom-class-in {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<div 
    class="sticky top-4"
    x-data="{
        shouldHardRefresh: '<?= $should_hard_refresh; ?>',
        init() {
            $listen('wc-ajax', () => $wpMorph())
        }
    }">
    <h2 class="font-bold">Mini Cart</h2>

    <div class="flex items-center justify-between mt-2">
        <span><?= $cart_count; ?> items</span>
        <span><?= $cart_total; ?></span>
    </div>

    <div class="gap-4 grid grid-cols-1 mt-4">
        <?php foreach ($cart_items as $cart_item_id => $item): ?>
            <div 
                class="flex items-center justify-between group overflow-hidden relative select-none" 
                key="<?= $item['id']; ?>"
                wp-morph-transition="custom-class"
                wp-morph-transition-in="custom-class-in">
                <div class="absolute bg-zinc-200 duration-300 inset-0 w-full group-hover:-translate-x-14">
                    <div class="border-b border-zinc-400 flex items-center justify-between h-full pr-4">
                        <div class="h-full mr-4 shrink-0 w-16 [&_img]:!h-full [&_img]:object-cover">
                            <?= $item['image'] ?>
                        </div>
                        <span class="truncate"><?= $item['name']; ?></span>
                        <span class="bg-emerald-300 grid h-5 place-content-center ml-4 rounded-full shrink-0 text-sm w-5">
                            <?= $item['quantity']; ?>
                        </span>
                    </div>
                </div>
                <button 
                    class="bg-red-400 flex h-full justify-end p-4 text-red-100 w-full"
                    x-on:click="$wpMorph({ delete: '<?= $cart_item_id; ?>' }, {
                        onSuccess: () => {
                            $dispatch('mini-cart-updated')
                            $wpMorphInvoke('woocommerce.cart-mini')
                        },
                        onFinish: () => {
                            $dispatch('mini-cart-updated')
                            shouldHardRefresh === 'true' ? window.location.reload() : null
                        }
                    })">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>
