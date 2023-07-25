<?php get_header(); ?>

    <section class="grid h-full p-4 place-content-center">
        <div class="pb-16 text-center">
            <span class="font-semibold text-lg"><?php morph_component('time.index'); ?></span>
            
            <img
                class="max-w-lg mt-16 w-full" 
                src="<?= get_template_directory_uri() . '/storage/images/time-screenshot.png' ?>" 
                alt="time-screenshot">
        </div>
    </section>

<?php get_footer(); ?>
