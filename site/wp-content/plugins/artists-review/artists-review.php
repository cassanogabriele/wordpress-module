<?php
/*
Plugin Name: Artists Reviews
Description: Créer des critiques d'artistes.
Version: 1.0.0
Author: Gabriele Cassano
Author URI: https://gabriel-cassano.be/
*/
function css(){
    wp_enqueue_style('css', plugins_url('artists-review/css/artist_review.css'));
}

add_action('wp_enqueue_scripts', 'css');

function boostrapcss(){
    wp_enqueue_style('boostrapcss', plugins_url('artists-review/css/bootstrap.css'));
}

add_action('wp_enqueue_scripts', 'boostrapcss');

function ar_post_type() {
	$labels = array(
		'name'               => _x( 'Artists Reviews', 'post type general name', 'artists-reviews' ),
		'singular_name'      => _x( 'Artists Reviews', 'post type singular name', 'artists-reviews' ),
		'menu_name'          => _x( 'Artists Reviews', 'admin menu', 'artists-reviews' ),
		'name_admin_bar'     => _x( 'Artists Reviews', 'add new on admin bar', 'artists-reviews' ),
		'add_new'            => _x( 'Add New Review', 'album', 'artists-reviews' ),
		'add_new_item'       => __( 'Add New Review', 'artists-reviews' ),
		'new_item'           => __( 'New Artist Review', 'artists-reviews' ),
		'edit_item'          => __( 'Edit Artist Review', 'artists-reviews' ),
		'view_item'          => __( 'View Artist Review', 'artists-reviews' ),
		'all_items'          => __( 'All Artists Reviews', 'artists-reviews' ),
		'search_items'       => __( 'Search Artists Reviews', 'artists-reviews' ),
		'parent_item_colon'  => __( 'Parent Artists Reviews:', 'artists-reviews' ),
		'not_found'          => __( 'No reviews found.', 'artists-reviews' ),
		'not_found_in_trash' => __( 'No reviews found in Trash.', 'artists-reviews' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Artists reviews for our site.', 'artists-reviews' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'artists-review' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
		'menu_icon'          => 'dashicons-universal-access-alt'
	);

	register_post_type( 'artists-reviews', $args );
}

add_action( 'init', 'ar_post_type' );

function shortcode_artists_reviews(){
	// 1. On définit les arguments pour définir ce que l'on souhaite récupérer	
	$artists = array(
		'post_type'        => 'artists-reviews',
		'meta_key'         => '_thumbnail_id',
		'meta_value_num'   => 0,
		'meta_compare'     => '!=' 
	);

	// 2. On exécute la WP Query
	$my_query = new WP_Query( $artists);
	
	$count=0;
	
	echo '<table ><tr>';

	// 3. On lance la boucle 
	if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();		
		echo '<tr><div class="container-fluid"><th><p class="thumbnails-review center-block">';
		the_post_thumbnail();
		echo '</p><p class="review-size"><h4 class="titles-review">';
		the_title();
		echo '</h4></p><p>';
		the_content();
		echo '</p><p class="author">Auteur : ';
		the_author_posts_link();		
		echo '</p></div><hr class="hr-style"></th></tr>';			
		
	endwhile;

	echo "</table>";
	
	endif;
}

add_shortcode('artistsreviews', 'shortcode_artists_reviews');
