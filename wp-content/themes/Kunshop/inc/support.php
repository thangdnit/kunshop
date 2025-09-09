<?php
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

// Render Category Checkboxes
function render_category_checkboxes($parent_id = 0, $taxonomy = 'product_category', $selected = []) {
    $args = [
        'taxonomy'   => $taxonomy,
        'parent'     => $parent_id,
        'hide_empty' => false,
    ];

    $categories = get_terms($args);

    if (!empty($categories) && !is_wp_error($categories)) {
        echo '<ul class="category-list">';
        foreach ($categories as $category) {
            $checked = in_array($category->term_id, $selected) ? 'checked' : '';

            $children = get_terms([
                'taxonomy'   => $taxonomy,
                'parent'     => $category->term_id,
                'hide_empty' => false,
            ]);

            echo '<li>';

            echo '<label>';
            echo '<input type="checkbox" name="categories[]" value="' . esc_attr($category->term_id) . '" ' . $checked . '> ';
            echo esc_html($category->name);
            echo '</label>';

            if (!empty($children)) {
                echo '<span class="toggle-btn"></span> ';
            } else {
                echo '<span class="no-toggle"></span> ';
            }

            if (!empty($children)) {
                echo '<div class="children">';
                render_category_checkboxes($category->term_id, $taxonomy, $selected);
                echo '</div>';
            }

            echo '</li>';
        }
        echo '</ul>';
    }
}

// Price Formatting
function format_price($price) {
    $formatted_price = "Liên hệ";
    if ($price < 1000){
        $formatted_price = $price . '.000 đ';
    } elseif ($price >= 1000) {
        $formatted_price = number_format($price, 0, ',', '.') . '.000 đ';
    }
    return $formatted_price;
}

// Hide Category Product in Breadcrumb NavXT
add_filter('bcn_after_fill', function($trail){
    if (is_singular('product')) {
        foreach ($trail->breadcrumbs as $key => $crumb) {
            if (isset($crumb->type) && in_array('taxonomy', $crumb->type)) {
                unset($trail->breadcrumbs[$key]);
            }
        }
        $trail->breadcrumbs = array_values($trail->breadcrumbs);
    }
    return $trail;
});


