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