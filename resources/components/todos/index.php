<?php

// Delete a todo
if ((int) $delete_todo_id = $_POST['deleteTodoId'] ?? false) {
    if (get_post_type($delete_todo_id) === 'todo') {
        wp_delete_post($delete_todo_id, true);
    }
}

// Get the the total number of todos
$query = new WP_Query([
    'post_type'      => 'todo',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);

$total_todos = count($query->posts);

// Delete all todos
if ($_POST['deleteAllTodos'] ?? false || $total_todos > 24) {
    $query = new WP_Query([
        'post_type'      => 'todo',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);

    foreach ($query->posts as $post_id) {
        wp_delete_post($post_id, true);
    }
}

// Get all todos
$query = new WP_Query([
    'post_type'      => 'todo',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'order'          => 'DESC',
    'orderby'        => 'ID',
]);

$todos = array_map(function ($post_id) {
    $dot_colors = [
        'bg-blue-400',
        'bg-yellow-400',
        'bg-red-400',
        'bg-purple-400',
        'bg-pink-400',
        'bg-indigo-400',
        'bg-green-400',
    ];

    return [
        'id'        => $post_id,
        'title'     => esc_html(get_the_title($post_id)),
        'dot_color' => $dot_colors[$post_id % count($dot_colors)],

    ];
}, $query->posts);
?>

<style>
    .wp-morph-transition {
        opacity: 0;
        transform: translateY(-0.1rem);
        transition: all 170ms ease-in-out;
    }

    .wp-morph-transition-in {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div 
    x-data 
    x-on:todo-created.window="$wpMorph"
    x-on:todo-delete-all.window="$wpMorph('deleteAllTodos')">
    <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <?php foreach ($todos as $todo): ?>
            <div 
                class="flex group items-center justify-between overflow-hidden relative select-none" 
                key="<?= $todo['id']; ?>"
                wp-morph-transition>
                <p class="absolute bg-zinc-200 border-b border-zinc-400 duration-300 flex inset-0 items-center justify-between p-4 w-full group-hover:-translate-x-14">
                    <span class="mr-8 truncate"><?= $todo['title']; ?></span>
                    <span class="grid h-6 place-content-center rounded-full shrink-0 text-sm w-6 <?= $todo['dot_color']; ?>"></span>
                </p>
                <button 
                    class="bg-red-400 flex h-full justify-end p-4 text-red-100 w-full"
                    x-on:click="$wpMorph({ deleteTodoId: <?= $todo['id']; ?> })">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>