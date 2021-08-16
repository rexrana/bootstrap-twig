<?php
/**
 * Bootstrap Twig functions file
 *
 * @package BootstrapTwig
 * @version 0.1.0
 */

define( 'BOOTSTRAP_VERSION', '4.4.1' );

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

Timber::$dirname = array('templates/wordpress');

// load includes
require get_template_directory() . '/inc/timber.php';

require_once get_template_directory() .  '/inc/enqueue.php';
require_once get_template_directory() .  '/inc/misc.php';
require_once get_template_directory() .  '/inc/sidebars.php';

new BootstrapTwigSite();

// removes the default image from WooCommerce, so we can add our own manually
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
