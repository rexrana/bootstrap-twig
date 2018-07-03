<?php

if ( ! function_exists( 'bootstrap_twig_register_sidebars' ) ) {

  add_action( 'widgets_init', 'bootstrap_twig_register_sidebars' );

  // Register Sidebars
  function bootstrap_twig_register_sidebars() {

    $my_sidebars = array(
        array(
          'id'            => 'blog-widgets',
          'name'          => __( 'Blog', 'bootstrap-twig' ),
          'description'   => __( 'Widgets shown on the blog feed pages', 'bootstrap-twig' ),
        ),
        array(
          'id'            => 'footer-widgets',
          'name'          => 'Footer',
          'description'   => 'Widgets shown in the footer',
        ),
      );

      $defaults = array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar',
        'description'   => 'The Sidebar contains widgets',
        'class'         => 'card my-4',
        'before_widget' => '<div id="%1$s" class="card mb-4 %2$s">',
    		'after_widget'  => '</div>',
        'before_title'  => '<h5 class="card-header">',
    		'after_title'   => '</h5>',
      );

      foreach( $my_sidebars as $sidebar ) {
        $args = wp_parse_args( $sidebar, $defaults );
        register_sidebar( $args );
      }

  }

}
