<?php
/*
 Template Name: One Column
*/
get_header('one-col');
?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="content one-col">
		<h1><?=the_title() ?></h1>
		<div class="text"><?=the_content();?></div>
	</div>
	<?php endwhile; ?>
<?php else: ?>
	can't load page
<?php endif; ?>	
		
</div>
<div class="right">
	<div class="jacob-william">
		<?php if(has_post_thumbnail()):?>
			<?php the_post_thumbnail('full') ?>
		<?php else: ?>
			
		<?php endif;?>
		</div>
</div>
<?php get_footer('one-col')?>