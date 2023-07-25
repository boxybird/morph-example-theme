<?php

$show_woo_message = is_cart() || is_checkout() || is_account_page();
?>

<?php get_header(); ?>

    <div class="grid grid-cols-1 h-full lg:grid-cols-[250px_1fr]">
        <section class="bg-zinc-300 border-r border-zinc-400 hidden p-4 lg:flex">
            <?php morph_component('woocommerce.cart-mini', ['class' => 'w-full']); ?>
        </section>
        
        <section class="p-4">
            <?php if ($show_woo_message): ?>
                <div class="bg-blue-300 flex items-center justify-center mb-4 px-3 py-1 space-x-2">
                    <svg class="h-5 shrink-0 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <p>Mini cart & header cart icon are Morph components.</p>
                </div>
            <?php endif; ?>
            <?php the_content(); ?>
        </section>
    </div>

<?php get_footer(); ?>
