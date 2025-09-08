<?php
// Format Date
function formatDate($date) {
    $formatter = new IntlDateFormatter(
        'vi_VN', 
        IntlDateFormatter::LONG, 
        IntlDateFormatter::NONE
    );

    $formatter->setPattern('d MMMM, yyyy');

    return $formatter->format(new DateTime($date));
}

// Change star rating to percentage
function star_rating_to_percentage( $rating ) {
    return 100 - ($rating * 20);
}

// Calculate slides
function calculateSlides($totalItems, $itemsPerSlide) {
    return ceil($totalItems / $itemsPerSlide);
}

// Get Size Image and URL
function get_image ($id, $size = 'medium') {
    return wp_get_attachment_image($id, $size);
}

function get_image_url ($id, $size = 'medium') {
    return wp_get_attachment_image_url($id, $size);
}

