<?php get_header(); ?>

   <h1>Counters</h1>

   <hr>

   <div class="grid">
      <section>
         <?php morph_component('counter-class'); ?>
      </section>
      
      <section>
         <?php morph_component('counter-procedural'); ?>
      </section>
   </div>

<?php get_footer(); ?>