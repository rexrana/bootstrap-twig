<?php

if ( ! function_exists( 'bootstrap_twig_register_sidebars' ) ) {

  add_action( 'widgets_init', 'bootstrap_twig_register_sidebars' );

  // Register Sidebars
  function bootstrap_twig_register_sidebars() {

    $my_sidebars = array(
        array(
          'id'            => 'blog-widgets',
          'name'          => __( 'Blog', 'bootstrap-twig' ),
          'description'   => __( 'Widgets shown on blog archive pages', 'bootstrap-twig' ),
        ),
        array(
          'id'            => 'footer-widgets',
          'name'          => 'Footer',
          'description'   => 'Widgets shown in the footer',
        ),
      );

      $defaults = array(
        'class'         => 'card my-4',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
        'before_title'  => '<h5>',
    		'after_title'   => '</h5>',
      );

      foreach( $my_sidebars as $sidebar ) {
        $args = wp_parse_args( $sidebar, $defaults );
        register_sidebar( $args );
      }

  }

}
