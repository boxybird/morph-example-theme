<?php get_header(); ?>

    <div class="grid h-full">
        <section class="p-4">
            <div class="bg-zinc-200 border-b border-zinc-400 p-4">
                <?php morph_component('todos.create'); ?>
            </div>
            <div class="mt-4">
                <?php morph_component('todos.index'); ?>
            </div>
        </section>
    </div>

<?php get_footer(); ?>
