<?php
// Define slugs to EXCLUDE
add_filter( 'woo_portfolio_gallery_exclude', 'woo_custom_portfolio_gallery_slugs', 10 );

function woo_custom_portfolio_gallery_slugs ( $slugs ) {
    if ( is_page( 'gallery-sillysleeves' ) ) {
        $slugs = 'users-gallery';
    }

    if ( is_page( 'gallery-user-submitted' ) ) {
        $slugs = 'kids, markets, products, ';
    }

    return $slugs;
} // End woo_custom_portfolio_gallery_slugs()

add_action( 'wp_enqueue_scripts', 'mysite_enqueue' );

function mysite_enqueue() {
  $ss_url = get_stylesheet_directory_uri();
  wp_enqueue_script( 'mysite-scripts', "{$ss_url}/js/sillysleeves.js" );
}

?>