<?php
/*
Plugin Name: Album Reviews
Description: Créer des critques d'albums.
Version: 1.0.0
Author: Gabriele Cassano
Author URI: https://gabriel-cassano.be/
*/
function csspersoCSS(){
    wp_enqueue_style('cssperso', plugins_url('album-reviews/css/album_review.css'));
}

function cssBoostrapGridCSS(){
    wp_enqueue_style('cssboostrap', plugins_url('album-reviews/css/bootstrap-grid.css'));
}

add_action('wp_enqueue_scripts', 'csspersoCSS');

add_action('wp_enqueue_scripts', 'cssBoostrapGridCSS');

function br_post_type() {
	$labels = array(
		'name'               => _x( 'Album Reviews', 'post type general name', 'album-reviews' ),
		'singular_name'      => _x( 'Album Review', 'post type singular name', 'album-reviews' ),
		'menu_name'          => _x( 'Album Reviews', 'admin menu', 'album-reviews' ),
		'name_admin_bar'     => _x( 'Album Review', 'add new on admin bar', 'album-reviews' ),
		'add_new'            => _x( 'Add New Review', 'album', 'album-reviews' ),
		'add_new_item'       => __( 'Add New Review', 'album-reviews' ),
		'new_item'           => __( 'New Album Review', 'album-reviews' ),
		'edit_item'          => __( 'Edit Album Review', 'album-reviews' ),
		'view_item'          => __( 'View Album Review', 'album-reviews' ),
		'all_items'          => __( 'All Albums Reviews', 'album-reviews' ),
		'search_items'       => __( 'Search Albums Reviews', 'album-reviews' ),
		'parent_item_colon'  => __( 'Parent Albums Reviews:', 'album-reviews' ),
		'not_found'          => __( 'No reviews found.', 'album-reviews' ),
		'not_found_in_trash' => __( 'No reviews found in Trash.', 'album-reviews' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Album reviews for our site.', 'album-reviews' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'album_review' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
		'menu_icon'          => 'dashicons-album'
	);

	register_post_type( 'album_review', $args );
}

add_action( 'init', 'br_post_type' );

function prepend_post_type($title,$id){
	if(is_home()){
		$post_type = get_post_type($id);
		$types = array(
			'post' => 'Blog',
			
		);
	
		return '<small class="titles">'.$title.'</small>';
	}	
	
	return $title;
}

add_filter('the_title', 'prepend_post_type', 10, 2);

function prepend_book_data($content){
	if(is_singular('album_review')){
		$author = get_post_meta(get_the_ID(), 'author', true);
		$score = get_post_meta(get_the_ID(), 'score', true);
		$sortie = get_post_meta(get_the_ID(), 'sortie', true);
		$enregistrement = get_post_meta(get_the_ID(), 'enregistrement', true);
		$duree = get_post_meta(get_the_ID(), 'duree', true);
		$label = get_post_meta(get_the_ID(), 'label', true);
		$style = get_post_meta(get_the_ID(), 'style', true);
		
		$infos = '	
				<p class="bold"><strong class="labels">Enregistré à : </strong>'. $enregistrement.'</p>
				<p><strong class="labels">Sortie : </strong>Le '. $sortie.'</p>
				<p class="bold"><strong class="labels">Duréé : </strong>'. $duree.'</p>		
				<p><strong class="labels">Label : </strong>'. $label.'</p>				
				<p class="bold"><strong class="labels bold">Note : </strong><span id="cote">'. $score.'</span></p>	
				<p><strong class="labels">Style : </strong>'. $style.'</p>	
			';
			
		$membres = get_post_meta( get_the_ID(), "membres", false );
		
		$infos .= '<hr><strong class="labels"><p class="separation bold">Membres </strong>';
		
		$infos .= '<ul>';
		
		foreach($membres as $membre){
			$infos .= '<li>'.$membre.'</li>';
		}
		
		$infos .= '</ul>';

		$titres = get_post_meta( get_the_ID(), "titres", false );
		
		$infos .= '<hr><strong class="labels"><p class="separation bold">Titres </strong><ol class="titres">';
				
		foreach($titres as $titre){		
			$infos .= '<li>'.$titre.'</li>';
		}
		
		$infos .= '</ul></p><hr>';
		
		$post = '<strong class="labels">Chroniqueur : </strong><span id="chroniqueur">'.$author.'</span><br>';	
		return '<div class="container-fluid" id="reviews">
					<div class="row">
						<div class="col-6 col-md-4">
						'.$infos .'
						</div>
						
						<div class="col-12 col-md-8" class="" >
						'.$content . $post.'
						</div>
					</div>
				</div>';		
	} 
	
	$author_review = get_post_meta(get_the_ID(), 'author', true);
	$html = '<p id="single-post">'. $author_review.'</p>';
		
	return $content . $html;
}

add_filter('the_content', 'prepend_book_data');

add_action( 'pre_get_posts', function($q) { if( !is_admin() && $q->is_main_query() && $q->is_front_page() ) { $q->set ('post_type', array( 'album_review' ) ); } }); 

function shortcode_reviews(){
	query_posts( array(
		'post_type'        => 'album_review',
		'meta_key'         => '_thumbnail_id',
		'meta_value_num'   => 0,
		'meta_compare'     => '!=' 
	));		

	while ( have_posts() ) : the_post(); 

	endwhile; 
}

add_shortcode('reviews', 'shortcode_reviews');
