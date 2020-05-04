<?php

function bootstrap_twig_set_product( $post ) {
    global $product;

    if ( is_woocommerce() ) {
        $product = wc_get_product( $post->ID );
    }
}

function bootstrap_twig_url_without_protocol($url) {
    return parse_url($url, PHP_URL_HOST);
}

/**
 * add bootstrap classes to comment_reply_link
 *
 * @param string $html
 * @param array $args Override default options.
 * @param int|WP_Comment $comment (Optional) Comment being replied to. Default current comment.
 * @param int|WP_Post $post (Optional) Post ID or WP_Post object the comment is going to be displayed on. Default current post.
 * @return string
 */
function bootstrap_twig_filter_comment_reply_link( $html, $args = array(), $comment = null, $post = null ) {

    return preg_replace_callback('/class=\'([a-z- ]+)\'/', function($m) {

        $pattern = "/\bcomment-reply-link\b/" ;
        $replacement = "btn btn-sm btn-secondary";

        if(strpos($m[1], "comment-reply-link") !== false) {
            $m[0] = preg_replace($pattern, $replacement,$m[0],1);
        }

        return $m[0];

       }, $html);

}
add_filter( 'comment_reply_link', 'bootstrap_twig_filter_comment_reply_link', 10, 4 );
