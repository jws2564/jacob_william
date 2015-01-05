<?php get_header(); ?>
<div class="content portfolio single">
<?php if ( have_posts() ): the_post(); ?>
<h1><?=the_title();?></h1>
<?=the_content(); ?>
<?php endif; ?>
</div>
<?php get_footer(); ?>