<?php

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


class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'bootstrap-twig' ),
		) );


		add_filter('timber/loader/loader', function($loader){

			//  register twig namespaces for atomic deign patterns
			$loader->addPath( get_template_directory() . "/templates/macros", 'macros' );
			$loader->addPath( get_template_directory() . "/templates/components/01-atoms", 'atoms' );
			$loader->addPath( get_template_directory() . "/templates/components/02-molecules", 'molecules' );
			$loader->addPath( get_template_directory() . "/templates/components/03-organisms", 'organisms' );
			// $loader->addPath( get_template_directory() . "/templates/components/04-templates", 'templates');
			// $loader->addPath( get_template_directory() . "/templates/components/05-pages", 'pages');

			return $loader;
		});

		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu( 'primary');

		$context['site'] = $this;
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */

		$twig->addFilter('unique', new Twig_Filter_Function('array_unique', array($this, SORT_STRING) ));

		return $twig;
	}

}

new StarterSite();

require_once ( get_template_directory() . '/inc/enqueue.php' );
