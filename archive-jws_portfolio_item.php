<?php get_header(); ?>
<div class="content portfolio-archive">
	<h1>Portfolio</h1>
	<div class="filters">
		<div class="title">My Work</div>
		<?php $exclude = get_term_by('slug', 'templates', 'portfolio'); $exclude = $exclude->term_id; ?>
		<?php $filters = get_terms(array('portfolio'), array('exclude_tree'=>array($exclude))); ?>
		<?php foreach($filters as $filter):?>
			<div class="filter" data-term-id="<?=$filter->term_id?>" data-term-name="<?=$filter->name?>"><?=$filter->name?></div>
		<?php endforeach;?>
	</div>
	<div class="view">
		<div class="active">list</div>
		<div>grid</div>
	</div>
	<div class="items">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="item">
				<h2><a href="<?=the_permalink()?>"><?=the_title()?></a></h2>
				<?php $images = get_attached_media('image'); ?>
				<div class="images">
				<?php if(has_term("square", 'portfolio')) : ?>
					<?php foreach($images as $image):?>
						<a href="<?=the_permalink()?>"><img class="square" src="<?=$image->guid?>" alt="<?=$image->post_title?>"/></a>
					<?php endforeach;?>
				<?php else:?>
					<?php foreach($images as $image):?>
						<a href="<?=the_permalink()?>"><img class="rectangle" src="<?=$image->guid?>" alt="<?=$image->post_title?>"/></a>
					<?php endforeach;?>
				<?php endif; ?>
				</div>
				<a href="<?=the_permalink()?>" class="portfolio-more"></a>
				<div class="excerpt">
					<?=the_excerpt();?>
				</div>
			</div>
		<?php endwhile; else : ?>
			<div class="sorry">Oops, looks like I don't have any content matching your filters.</div>
		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>