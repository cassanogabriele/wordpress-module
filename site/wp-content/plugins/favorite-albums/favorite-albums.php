<?php
/*
Plugin Name: Favorite Albums
Description: Lister les albums préférés.
Version: 1.0.0
Author: Gabriele Cassano
Author URI: https://gabriel-cassano.be/
*/
function customCSS(){
    wp_enqueue_style('customcss', plugins_url('favorite-albums/css/favorite_albums.css'));
}

add_action('wp_enqueue_scripts', 'customcss');

function BoostrapGrid(){
    wp_enqueue_style('cssboostrap', plugins_url('favorite-albums/css/bootstrap-grid.css'));
}

add_action('wp_enqueue_scripts', 'BoostrapGrid');

function post_albums() {
	$labels = array(
		'name'               => _x( 'Favorite Albums', 'post type general name', 'favorite-albums' ),
		'singular_name'      => _x( 'Favorite Albums', 'post type singular name', 'favorite-albums' ),
		'menu_name'          => _x( 'Favorite Albums', 'admin menu', 'favorite-albums' ),
		'name_admin_bar'     => _x( 'Favorite Albums', 'add new on admin bar', 'favorite-albums' ),
		'add_new'            => _x( 'Add New Album', 'album', 'favorite-albums' ),
		'add_new_item'       => __( 'Add New Review', 'favorite-albums' ),
		'new_item'           => __( 'New Favorite Album', 'favorite-albums' ),
		'edit_item'          => __( 'Edit Favorite Albums', 'favorite-albums' ),
		'view_item'          => __( 'View Favorite Albums', 'favorite-albums' ),
		'all_items'          => __( 'All Favorite Albums', 'favorite-albums' ),
		'search_items'       => __( 'Search Favorite Albums', 'favorite-albums' ),
		'parent_item_colon'  => __( 'Parent Favorite Albums :', 'favorite-albums' ),
		'not_found'          => __( 'No reviews found.', 'favorite-albums' ),
		'not_found_in_trash' => __( 'No reviews found in Trash.', 'favorite-albums' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Favorite Albums for your website.', 'favorite-albums' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'favorite-albums' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
		'menu_icon'          => 'dashicons-playlist-audio'
	);

	register_post_type( 'favorite-albums', $args );
}

add_action( 'init', 'post_albums' );

add_action( 'pre_get_posts', function($q) { if( !is_admin() && $q->is_main_query() && $q->is_front_page() ) { $q->set ('post_type', array( 'favorite-albums' ) ); } }); 

function shortcode_favorites(){
	// 1. On définit les arguments pour définir ce que l'on souhaite récupérer	
	$favorites = array(
		'post_type'        => 'favorite-albums',
		'meta_key'         => '_thumbnail_id',
		'meta_value_num'   => 0,
		'meta_compare'     => '!=' 
	);

	// 2. On exécute la WP Query
	$my_query = new WP_Query( $favorites );
	

	// 3. On lance la boucle !
	if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();		
		echo '<div class="wp-block-group alignwide">
				<div class="wp-block-group__inner-container">
					<div class="wp-block-media-text alignwide is-stacked-on-mobile">
						<figure class="wp-block-media-text__media" id="img-favorite">';
						the_post_thumbnail();							
		echo '</figure>';
		echo '<div class="wp-block-media-text__content">';
		echo '<h6>';
		the_title();
		// Champs personnalisés
		$favorite_song = get_post_meta(get_the_ID(), 'favorite-song', true);	
		$score = get_post_meta(get_the_ID(), 'score', true);
		$style = get_post_meta(get_the_ID(), 'style', true);
		$site = get_post_meta(get_the_ID(), 'site', true);		
		echo "<span id='note'>";
		echo $score;
		echo "</span>";
		echo "<span id='style'>";
		echo $style;
		echo "</span>";
		echo '</h6>';
		echo '<p id="style-content">';
		the_content();			
		echo '</p>';
		echo "<hr>";
		echo '<p><span class="custom-p">Morceau préféré :</span> '; echo $favorite_song; echo '</p>';
		$author = get_post_meta(get_the_ID(), 'author', true);
		echo '<p><span class="custom-p">Album préféré de :</span> '; echo $author; echo '</p>';		
		echo '<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v7.0" nonce="4PpxPnWJ"></script>';
		echo '<div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Partager</a></div>';
		echo "<hr>";		
		echo '</div></div>';				
	endwhile;
	endif;
}

add_shortcode('favorites', 'shortcode_favorites');
