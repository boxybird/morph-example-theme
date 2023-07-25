<?php

if ($todo = $_POST['todo'] ?? false) {
    $post_id = wp_insert_post([
        'post_title'   => $todo,
        'post_type'    => 'todo',
        'post_status'  => 'publish',
    ]);
}
?>

<div 
    x-data="{
        todo: '',
    }">
    <div class="flex items-center justify-between w-full">
        <input 
            class="px-3 py-1 focus:outline-none focus:ring-4 focus:ring-zinc-600" 
            type="text"
            placeholder="New todo..."
            x-model="todo"
            x-on:keyup.enter="$wpMorph({ todo }, {
                onSuccess() {
                    todo = '';
                    $dispatch('todo-created')
                },
            })">
        <button 
            class="flex group items-center space-x-2 text-zinc-500"
            x-on:click="$dispatch('todo-delete-all')">
            <span class="duration-300 group-hover:text-zinc-700">Delete All</span>
            <svg class="duration-300 h-6 w-6 group-hover:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>
</div>