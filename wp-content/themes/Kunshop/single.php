<?php

get_header();

$post_type = get_post_type();

if ( ! $post_type ) {
    get_template_part( 'template-parts/pages/content', '404' );
    get_footer();
    exit;
}

switch ( $post_type ) {
    case 'post':
        get_template_part( 'template-parts/singles/content', 'post' );
        break;
    case 'cars':
        get_template_part( 'template-parts/singles/content', 'car' );
        break;
    default:
        get_template_part( 'template-parts/pages/content', '404' );
        break;
}

get_footer();
