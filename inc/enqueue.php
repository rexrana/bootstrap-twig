<?php

// Register Style
function bootstrap_twig_underscores__enqueue_bootstrap_css() {

	wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, '4.0.0' );
	wp_enqueue_style( 'bootstrap' );

}
add_action( 'wp_enqueue_scripts', 'bootstrap_twig_underscores__enqueue_bootstrap_css' );


function bootstrap_twig_underscores__enqueue_bootstrap_js() {

	global $wp_scripts;

	$versions = [
		'popper' => '1.12.9',
		'bootstrap' => '4.0.0'
	];

	wp_register_script( 'popper_js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/' .$versions['popper'] . '/umd/popper.min.js', [], $versions['popper'], true );
	wp_register_script( 'bootstrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/' .$versions['bootstrap'] . '/js/bootstrap.min.js', ['jquery','popper_js'], $versions['bootstrap'], true );

	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'popper_js');
	wp_enqueue_script( 'bootstrap_js');

}

add_action( 'wp_enqueue_scripts', 'bootstrap_twig_underscores__enqueue_bootstrap_js');
