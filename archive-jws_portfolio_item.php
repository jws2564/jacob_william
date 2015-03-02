<?php get_header(); ?>
<div class="content portfolio-archive">
	<h1>Portfolio</h1>	
	<?php if(false): ?>
	<div class="view">
		<label><input type="radio" name="view" value="list" checked="true"><div class="list"></div></label>
		<label><input type="radio" name="view" value="grid"><div class="grid"></div></label>
	</div>
	<?php endif;?>
	
	<div class="filters">
		<div class="title">Filters</div>
		<?php $exclude = get_term_by('slug', 'templates', 'jws_portfolio'); $exclude = $exclude->term_id; ?>
		<?php $filters = get_terms(array('jws_portfolio')); ?>
		<?php foreach($filters as $filter):?>
			<div class="filter" data-term-id="<?=$filter->term_id?>" data-term-name="<?=$filter->name?>"><?=$filter->name?></div>
		<?php endforeach;?>
	</div>
	<div class="loading"><img src="<?= get_stylesheet_directory_uri() ?>/images/loading.GIF" alt="Loading you content, please wait."/></div>
	<div class="items">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php jws_print_portfolio_print_post(get_the_ID()); ?>
		<?php endwhile; else : ?>
			<div class="sorry">Oops, looks like I don't have any content matching your filters.</div>
		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>