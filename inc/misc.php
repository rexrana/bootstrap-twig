<?php

function bootstrap_twig_set_product( $post ) {
    global $product;

    if ( is_woocommerce() ) {
        $product = wc_get_product( $post->ID );
    }
}

// clean phone number for use in tel: link
function bootstrap_twig_clean_phone($str) {

    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    try {
        $number = $phoneUtil->parse($str, "CA");
        return $phoneUtil->format($number, \libphonenumber\PhoneNumberFormat::E164);
    } catch (\libphonenumber\NumberParseException $e) {
        log_error($e);
    }

}

function bootstrap_twig_format_phone($str) {

    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    try {
        $number = $phoneUtil->parse($str, "CA");
        return $phoneUtil->format($number, \libphonenumber\PhoneNumberFormat::NATIONAL);
    } catch (\libphonenumber\NumberParseException $e) {
        log_error($e);
    }

}

function bootstrap_twig_url_without_protocol($url) {
    return parse_url($url, PHP_URL_HOST);
}

// add bootstrap classes to comment_reply_link
add_filter( 'comment_reply_link', 'bootstrap_twig_filter_comment_reply_link', 10, 4 );
function bootstrap_twig_filter_comment_reply_link( $html, $args, $comment, $post ) {

    return preg_replace_callback('/class=\'([a-z- ]+)\'/', function($m) {

    $pattern = "/\bcomment-reply-link\b/" ;
    $replacement = "btn btn-sm btn-secondary";

    if(strpos($m[1], "comment-reply-link") !== false) {
        $m[0] = preg_replace($pattern, $replacement,$m[0],1);
    }

    return $m[0];

       }, $html);

}
