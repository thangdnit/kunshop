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
        echo '<ul class="category-list '. $taxonomy . '-list">';
        foreach ($categories as $category) {
            $children = get_terms([
                'taxonomy'   => $taxonomy,
                'parent'     => $category->term_id,
                'hide_empty' => false,
            ]);

            echo '<li>';

            echo '<label>';
            echo '<input type="checkbox"' . 'name="'. esc_attr($category->slug) .'" value="' . esc_attr($category->term_id) . '" class="product-filter__' . esc_attr($taxonomy) . '" > ';
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

function get_term_ids($field){
    $ids = [];
    if (empty($field)) {
        return $ids;
    }

    // Nếu là object đơn
    if (is_object($field) && isset($field->term_id)) {
        return [$field->term_id];
    }

    // Nếu là số nguyên (ID)
    if (is_int($field)) {
        return [$field];
    }

    // Nếu là array
    if (is_array($field)) {
        foreach ($field as $item) {
            if (is_object($item) && isset($item->term_id)) {
                $ids[] = $item->term_id;
            } elseif (is_int($item)) {
                $ids[] = $item;
            }
        }
    }

    return $ids;
}

