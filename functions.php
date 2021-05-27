<?php
/**
 * Bootstrap Twig functions file
 * 
 * @package BootstrapTwig
 * @version 0.1.0
 */
use Timber\Timber;

define('BOOTSTRAP_VERSION', '4.4.1');

// autoloader
require_once (__DIR__ . '/vendor/autoload.php');

Timber::$dirname = array('templates/wordpress');

// load includes
// require_once (__DIR__ . '/inc/timber.php');
// require_once (__DIR__ . '/inc/enqueue.php');
// require_once (__DIR__ . '/inc/misc.php');
// require_once (__DIR__ . '/inc/sidebars.php');

new RexRana\BootstrapTwig\BootstrapTwigSite();

// removes the default image from WooCommerce, so we can add our own manually
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );