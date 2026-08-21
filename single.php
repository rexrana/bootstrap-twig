<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package BootstrapTwig
 * @since   0.1.0
 */
use Timber\Timber;
use Timber\Menu;

$context = Timber::context();
$post = Timber::get_post();
$context['post'] = $post;

// see if there is a comment id in the url
if( isset( $_GET['replytocom'] ) ) {
	$context['reply_to_comment'] = intval($_GET['replytocom']);
}

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
