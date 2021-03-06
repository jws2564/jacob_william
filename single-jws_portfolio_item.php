<?php get_header(); ?>
<div class="content portfolio single">
<?php if ( have_posts() ): the_post(); ?>
	<a class="portfolio-link-back" href="/portfolio/">Back to Portfolio</a>
	<h1><?=the_title();?></h1>
	<div class="portfolio-content">
		<?=the_content(); ?>
		<div class="tag-wrapper">
			<h3 class="tags">Tags</h3>
			<?php the_terms(get_the_ID(), 'jws_portfolio', "", "", ""); ?>
		</div>
	</div>
<?php endif; ?>
</div>
<?php get_footer(); ?>