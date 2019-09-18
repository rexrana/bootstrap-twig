<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package BootstrapTwig
 * @since   0.1.0
 */

global $wp_query;

$context = Timber::get_context();

require_once ( get_template_directory() . '/inc/archive-posts-pagination.php' );

if ( isset( $wp_query->query_vars['author'] ) ) {
	$author            = new Timber\User( $wp_query->query_vars['author'] );
	$context['author'] = $author;
	$context['title']  = 'Author Archives: ' . $author->name();
}
Timber::render( array( 'author.twig', 'archive.twig' ), $context );
