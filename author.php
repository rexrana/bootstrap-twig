<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package BootstrapTwig
 * @since   0.1.0
 */

use Timber\Timber;
use Timber\User;

global $wp_query;

$context = Timber::context();

require_once ( get_template_directory() . '/inc/archive-posts-pagination.php' );

if ( isset( $wp_query->query_vars['author'] ) ) {
	$author            = Timber::get_user( $wp_query->query_vars['author']);
	$context['author'] = $author;
	$context['title']  = 'Author Archives: ' . $author->name();
}
Timber::render( array( 'author.twig', 'archive.twig' ), $context );
