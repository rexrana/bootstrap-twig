<?php

function bootstrap_twig_enqueue_styles() {

	
	// Remove the `wp-block-library.css` file from `wp_head()`.
	// wp_dequeue_style( 'wp-block-library' );

	wp_register_style( 'bootstrap-twig-style', get_template_directory_uri() . '/dist/css/style.css', false, '4.0.0' );
	wp_enqueue_style( 'bootstrap-twig-style' );

}
add_action( 'wp_enqueue_scripts', 'bootstrap_twig_enqueue_styles' );

/**
 * Enqueuing of JavaScript
 *
 * @return void
 */
function bootstrap_twig_enqueue_scripts() {

	$scripts = [
		'bootstrap' => [
			'uri' => get_template_directory_uri() . '/dist/js/bootstrap.min.js',
			'version' => '4.0.0'
		],
		'popper' => [
			'uri' => get_template_directory_uri() . '/dist/js/popper.min.js',
			'version' => '1.12.9'
		],
		'theme' => [
			'uri' => get_template_directory_uri() . '/dist/js/theme.js',
			'version' => '1.0.0'
		],
		'form_validation' => [
			'uri' => get_template_directory_uri() . '/dist/js/form-validation.js',
			'version' => '4.0.0'
		]
	];

	wp_register_script( 'popper_js', $scripts['popper']['uri'], [], $scripts['popper']['version'], true );
	wp_register_script( 'bootstrap_js', $scripts['bootstrap']['uri'], ['jquery','popper_js'], $scripts['bootstrap']['version'], true );
	wp_register_script( 'theme_js', $scripts['theme']['uri'], ['jquery'], $scripts['theme']['version'], true );

	wp_register_script( 'form_validation', $scripts['form_validation']['uri'], [], $scripts['form_validation']['version'], true );

	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'popper_js');
	wp_enqueue_script( 'bootstrap_js');
	wp_enqueue_script( 'theme_js');


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'form_validation' );
	}

}

add_action( 'wp_enqueue_scripts', 'bootstrap_twig_enqueue_scripts');
