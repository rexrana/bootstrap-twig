<?php

/**
 * Enqueuing of CSS and JavaScript
 *
 * @return void
 */
function bootstrap_twig_enqueue_scripts() {

	// Remove the `wp-block-library.css` file from `wp_head()`.
	// wp_dequeue_style( 'wp-block-library' );

	wp_register_style( 'bootstrap-twig-style', get_template_directory_uri() . '/dist/css/styles.css', false, BSTWIG_THEME_VERSION );
	wp_enqueue_style( 'bootstrap-twig-style' );


	// wp_register_script( 'bootstrap-twig-js', get_template_directory_uri() . '/dist/js/bootstrap.esm.min.js', [], BSTWIG_THEME_VERSION, true );

	wp_enqueue_script( 'bootstrap-twig-js', get_template_directory_uri() . '/dist/js/bootstrap.bundle.min.js', array(), BSTWIG_THEME_VERSION, array('in_footer', true) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'form_validation' );
	}

}

add_action( 'wp_enqueue_scripts', 'bootstrap_twig_enqueue_scripts');
