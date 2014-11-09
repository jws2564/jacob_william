<?php get_header(); ?>
<div class="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article>
				<h2><a href="<?=the_permalink()?>"><?=the_title()?></a></h2>
				<div class="meta">
					<div class="date"><?=the_date()?></div>
					<div class="author">By <?=the_author_meta( 'display_name', $post->post_author); ?></div>
				</div>
				<div class="excerpt">
					<?=the_excerpt();?>
				</div>
			</article>
		<?php endwhile; else : ?>
		
			<div class="panel"><h3><?php _e( 'Sorry, no content matched your criteria.' ); ?></h3></div>
		<?php endif; ?>
</div>
<?php get_footer(); ?>