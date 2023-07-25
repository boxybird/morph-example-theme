<?php

$query = new WP_Query([
    'post_type'      => 'message',
    'posts_per_page' => 30,
    'fields'         => 'ids',
    'order'          => 'DESC',
    'orderby'        => 'date',
]);

$messages = array_map(function ($post_id) {
    return [
        'id'    => $post_id,
        'title' => trim(esc_html(get_the_title($post_id))),
        'ago'   => human_time_diff(get_the_date('U', $post_id), current_time('timestamp')) . ' ago',
    ];
}, $query->posts);

$refresh_rate = get_field('refresh_rate') ?: 5000;
?>

<div 
    x-data="{
        init() {
            setInterval(function () {
                $wpMorph()
            }, parseInt(<?= $refresh_rate; ?>))
        }
    }"
    x-on:message-created.window="$wpMorph">
    <div class="gap-9 grid grid-cols-1 mb-5 mt-4">
        <?php foreach ($messages as $messages): ?>
            <div 
                class="flex justify-between relative select-none" 
                key="<?= $messages['id']; ?>"
                wp-morph-transition>
                <img
                    class="h-20 mr-4 w-20" 
                    src="https://api.dicebear.com/5.x/bottts-neutral/svg?seed=<?= $messages['id']; ?>" 
                    alt="avatar">
                <p class="bg-zinc-200 border-b border-zinc-400 duration-300 inset-0 p-4 w-full">
                    <span class="mr-8"><?= $messages['title']; ?></span>
                </p>
                <span class="absolute bg-zinc-300 -bottom-5 px-2 py-0.5 right-0 text-xs"><?= $messages['ago']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>