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
	wp_enqueue_script('jquery');
	//wp_enqueue_script( 'Side Image', get_template_directory_uri().'/scripts/side_image.js', array('jquery'), true);
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
		'portfolio',
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


