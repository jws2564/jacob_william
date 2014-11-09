<?php

add_theme_support( 'post-thumbnails' );

add_action( 'init', 'jws_register_nav' );
function jws_register_nav(){
	register_nav_menu('main-nav', 'Main navigation menu.');
}

add_action( 'wp_enqueue_scripts', 'jws_enqueue_style' );
function jws_enqueue_style() {
	wp_enqueue_style( 'core', 'style.css', false );
}

add_action( 'wp_enqueue_scripts', 'jws_enqueue_script' );
function jws_enqueue_script() {
	global $post;
	wp_enqueue_script('jquery');
	if($post->post_type == 'jws_portfolio_item' && is_archive()){
		wp_enqueue_script( 'Portfolio', get_template_directory_uri().'/scripts/portfolio.js', array('jquery'), true);
		wp_localize_script( 'Portfolio', 'jws_ajax',array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	}
}

add_filter( 'wp_title', 'jws_hack_wp_title_for_home' );
function jws_hack_wp_title_for_home( $title )
{
	if( empty( $title ) && ( is_home() || is_front_page() ) ) {
		return __( 'Home', 'theme_domain' );
	}
	return $title;
}

add_action( 'init', 'jws_custom_taxonomy_init' );
function jws_custom_taxonomy_init() {
	// create a project taxonomy to keep all project pages, articles, status updates grouped together
	register_taxonomy(
		'jws_portfolio',
		array('jws_portfolio_item'),
		array(
		'labels' => array('name'=>'Categories', 'singular_name'=>'Category', 'menu_name'=>'Categories'),
		'show_ui' => true,
		'query_var'=>true,
		'public' =>true, 
		'hierarchical' => true
		)
	);
}

add_action( 'init', 'jws_create_post_types' );
function jws_create_post_types() {
	register_post_type( 'jws_portfolio_item',
		array(
		'labels' => array(
			'name' => 'Portfolio Items',
			'singular_name' => 'Item', 
			'menu_name' => 'Portfolio'
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array('title', 'editor', 'excerpt'), 
		'has_archive' => true, 
		'taxonomies' => array('cateogry'),
		'rewrite' => array('slug'=>'portfolio')
		)
	);
}



add_action('add_meta_boxes', 'jws_add_meta_boxes');
function jws_add_meta_boxes(){
	global $post;
	if($post->post_type == 'jws_portfolio_item'){
		add_meta_box(
		'template_image',
		'Images',
		'jws_show_template_image_upload',
		'jws_portfolio_item',
		'side',
		'low');
	}
}

//load file upload js for wordpress media uploader
add_action( 'admin_enqueue_scripts', 'jws_load_project_file_js' );
function jws_load_project_file_js() {
	global $post;
	if( $post->post_type == 'jws_portfolio_item' ) {	 
		if(function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
			wp_enqueue_script( 'project_file_js', get_template_directory_uri() . '/scripts/file_uploader.js', array('jquery', 'media-upload', 'thickbox', 'media-models'));
		}
	}
}

function jws_show_template_image_upload(){
		global $post;
		$file_list = "";
		$files = get_attached_media("", $post->ID);
		foreach($files as $file){
			$file_list .= "<li><img src='{$file->guid}' style= 'width:100px;' /><a href='{$file->guid}' target='_BLANK'>{$file->post_name}</a></li>";
		}
		echo '<div id="post-attachment" class="uploader" data-parent_post="'.$post->ID.'"><a class="button" name="_unique_name_button" id="upload_image_button">Add Image</a>';
		if(!empty($files)){
			echo "<ul>$file_list</ul>";
		}else{
			echo "<p>No images attached.</p>";
		}
		echo '</div>';	
}

add_action( 'wp_ajax_jws_get_posts', 'jws_get_posts' );
add_action( 'wp_ajax_nopriv_jws_get_posts', 'jws_get_posts' );
function jws_get_posts(){
	$args = array('post_type' => "jws_portfolio_item");
	if(!empty($_POST['filters'])){
		$args ['tax_query'] = array(array('taxonomy' => 'portfolio', 'field'=>'slug', 'terms' => $_POST['filters']));
	}
	$posts = get_posts($args);
	
	foreach($posts as $post){
		jws_print_portfolio_print_post($post->ID, $post->post_excerpt);
	}
	exit;
}

function jws_print_portfolio_print_post($id, $need_excerpt=false){
	$images = get_attached_media('image', $id);
	
	if($_POST['view'] == 'list' || !$_POST['view']){
		if(has_term("square", 'portfolio', $id)) : ?>
			<div class="item square">	
				<div class="images">
				<?php $image = array_shift($images); ?>
				<div class="image-wrapper">
				<img src="<?=$image->guid?>" alt="<?=$image->post_title?>"/> 
				<?php if(count($images) >= 1): ?>
					<div class="thumbs">
						<img class="current" src="<?=$image->guid?>" alt="<?=$image->post_title?>"/> 
						<?php foreach($images as $image): ?>
							<img src="<?=$image->guid?>" alt="<?=$image->post_title?>"/>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				</div>
			</div>
			<div class="excerpt">
				<h2><a href="<?=get_permalink($id)?>"><?=get_the_title($id)?></a></h2>
		<?php else: ?>
			<div class="item rectangle">
			<h2><a href="<?=get_permalink($id)?>"><?=get_the_title($id)?></a></h2>
			<div class="images">
				<?php if(!empty($images)):?>
					<?php $image = array_shift($images); ?>
					<a href="<?=get_permalink($id)?>"><img src="<?=$image->guid?>" alt="<?=$image->post_title?>"/></a>
				<?php endif;?>		
			</div>
			<div class="excerpt">
		<?php endif; ?>
			<?php if($need_excerpt) : ?>
				<p><?=$need_excerpt?></p>
			<?php else: ?>
				<p><?=the_excerpt(); ?></p>
			<?php endif;?>
		</div>
		<a href="<?=get_the_permalink($id)?>" class="portfolio-more">more</a>
		</div>
		<?php 
	}else{
		if(!has_term("square", 'portfolio', $id)){
			//skip first image
			array_shift($images);	
		}
		foreach($images as $image): ?>
			<a class="grid" href="<?=get_permalink($id)?>"><img src="<?=$image->guid?>" alt="<?=$image->post_title?>"/></a>
		<?php endforeach;
	}
}


