<?php


// Register Style
function bootstrap_twig_enqueue_styles() {

	wp_register_style( 'bootstrap-twig-style', get_template_directory_uri() . '/dist/css/style.css', false, '4.0.0' );
	wp_enqueue_style( 'bootstrap-twig-style' );

}
add_action( 'wp_enqueue_scripts', 'bootstrap_twig_enqueue_styles' );


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
		]
	];

	wp_register_script( 'popper_js', $scripts['popper']['uri'], [], $scripts['popper']['version'], true );
	wp_register_script( 'bootstrap_js', $scripts['bootstrap']['uri'], ['jquery','popper_js'], $scripts['bootstrap']['version'], true );
	wp_register_script( 'theme_js', $scripts['theme']['uri'], ['jquery'], $scripts['theme']['version'], true );

	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'popper_js');
	wp_enqueue_script( 'bootstrap_js');
	wp_enqueue_script( 'theme_js');

}

add_action( 'wp_enqueue_scripts', 'bootstrap_twig_enqueue_scripts');
