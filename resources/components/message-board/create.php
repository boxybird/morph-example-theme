<?php

if ($message = $_POST['message'] ?? false) {
    $post_id = wp_insert_post([
        'post_title'   => $message,
        'post_type'    => 'message',
        'post_status'  => 'publish',
    ]);
}

$refresh_rate = get_field('refresh_rate');
?>

<div class="bg-blue-300 flex items-center justify-center px-3 py-1 space-x-2">
    <svg class="h-5 shrink-0 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    <p>An ACF Block component. Open multiple tabs to see live updates every <?= $refresh_rate ?>ms.</p>
</div>

<div 
    x-data="{
        message: '',
    }">
    <div class="bg-zinc-200 border-b border-zinc-400 mt-4 p-4">
        <textarea 
            class="px-3 py-1 w-full focus:outline-none focus:ring-4 focus:ring-zinc-600" 
            type="text"
            rows="3"
            placeholder="New message..."
            x-model="message">
        </textarea>
        <button 
            class="bg-emerald-500 duration-150 mt-2 px-3 py-1 tracking-widest uppercase w-full disabled:opacity-75 disabled:pointer-events-none focus:outline-none focus:ring-4 focus:ring-emerald-600 hover:bg-emerald-600"
            x-on:click="$wpMorph({ message }, {
                onSuccess() {
                    message = '';
                    $dispatch('message-created')
                },
            })">
            Save
        </button>
    </div>
</div>