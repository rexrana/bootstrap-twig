<?php
namespace RexRana\BootstrapTwig;

use Timber\Timber;
use Twig\TwigFilter;
use Timber\Site;
use Timber\Menu;

class BootstrapTwigSite extends Site {

	function __construct() {

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'align-wide' );
		
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );

		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'bootstrap-twig' ),
		) );

		add_filter('timber/loader/loader', function($loader){

			//  register twig namespaces for atomic deign patterns
			$loader->addPath( get_template_directory() . "/templates/macros", 'macros' );
			$loader->addPath( get_template_directory() . "/templates/components/00-protons", 'protons');
			$loader->addPath( get_template_directory() . "/templates/components/01-atoms", 'atoms' );
			$loader->addPath( get_template_directory() . "/templates/components/02-molecules", 'molecules' );
			$loader->addPath( get_template_directory() . "/templates/components/03-organisms", 'organisms' );
			$loader->addPath( get_template_directory() . "/templates/components/04-templates", 'templates');
			// $loader->addPath( get_template_directory() . "/templates/components/05-pages", 'pages');

			return $loader;
		});

		parent::__construct();
	}

	function add_to_context( $context ) {
		$context['menu'] = Timber::get_menu('primary');
		
		$context['body_classes'] = get_body_class();

		$context['search_form'] = get_search_form( false );

		// get sidebars
		$context['sidebars'] = array(
			'blog'=> Timber::get_widgets( 'blog-widgets' ),
			'footer'=> Timber::get_widgets( 'footer-widgets' ),
		);

		$context['site'] = $this;
		return $context;
	}

	/* this is where you can add your own functions to twig */
	function add_to_twig( $twig ) {
		
		// add filter functions to Twig.
		$twig->addFilter(new TwigFilter('unique', 'array_unique'));
		$twig->addFilter(new TwigFilter('clean_phone', 'bootstrap_twig_clean_phone'));
		$twig->addFilter(new TwigFilter('format_phone', 'bootstrap_twig_format_phone'));
		$twig->addFilter(new TwigFilter('url_domain', 'bootstrap_twig_url_without_protocol'));

		return $twig;
	}

}

