<!DOCTYPE html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '&raquo;', true, 'right' ); ?></title>
<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo bloginfo('template_directory'); ?>/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo bloginfo('template_directory'); ?>/js/jQueryAnimations.js"></script>
</head>

<body>

<div id="slider">
   <div id="prevSlide">
      <img src="previous.jpg" />
   </div>

   <div id="slider-window">
      <ul id="slides">
         <?php query_posts('posts_per_page=5&meta_key=thumb&meta_compare=!=&meta_value= ');
         while ( have_posts() ) : the_post(); ?>
            <li class="slide">
               <img src="<?php echo get_post_meta($post->ID, 'thumb', true) ?>" />
               <div class="slide-content">
                  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                  <?php the_excerpt(); ?>
               </div>
            </li>
         <?php endwhile;
         wp_reset_query();?>
      </ul>
   </div><!-- #slider-window -->

   <div id="nextSlide">
      <img src="next.jpg" />
   </div>
</div><!-- #slider -->

</body>
</html>