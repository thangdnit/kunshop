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
    if ($price < 1000 && $price > 0) {
        $formatted_price = $price . '.000 đ';
    } elseif ($price >= 1000) {
        $formatted_price = number_format($price, 0, ',', '.') . '.000 đ';
    }
    return $formatted_price;
}

/* Auto Calculate Price */
add_action('acf/input/admin_footer', function() {
    $api_url = home_url('/wp-json/kunshop83xcc3/v1/get-promotion-discount');
    $nonce   = wp_create_nonce('support_acf_nonce');
?>
<script>
    const protected_data = {
    support_acf: {
        api_url: "<?php echo esc_url($api_url); ?>",
        nonce: "<?php echo esc_js($nonce); ?>"
    }};
(function($){
    $(document).ready(function(){
        $("div[data-name='final_price'] input").prop('readonly', true);
        function updateFinalPrice() {
            const price = $("div[data-name='regular_price'] input");
            const finalprice = $("div[data-name='final_price'] input");
            const promotion = $('div[data-name="promotion"] .acf-true-false input[type="checkbox"]');
            let price_value = parseInt(price.val()) || 0;

            if (promotion.prop('checked')) {
                const promotion_type = $("div[data-name='promotion_type'] .acf-true-false input[type='checkbox']");
                if (promotion_type.prop('checked')) {
                    const term_id = $("div[data-name='choose_promotion'] select").val();
                    fetch(`${protected_data.support_acf.api_url}?term_id=${term_id}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            price_value = ((100 - data.discount) / 100) * price_value;
                        }
                        finalprice.val(Math.ceil(price_value));
                    })
                    .catch(error => {
                        console.error('Error fetching promotion data:', error);
                    });
                } else {
                    const discount_value = parseInt($("div[data-name='discount'] input").val()) || 0;
                    price_value = ((100 - discount_value) / 100) * price_value;
                    finalprice.val(Math.ceil(price_value));
                }
            }else {
                price_value = parseInt(price.val()) || 0;
                finalprice.val(price_value);
            }
        }
        $("div[data-name='regular_price'] input").on('input', updateFinalPrice);
        $('div[data-name="promotion"] .acf-true-false input[type="checkbox"]').on('change', updateFinalPrice);
        $("div[data-name='promotion_type'] .acf-true-false input[type='checkbox']").on('change', updateFinalPrice);
        $("div[data-name='choose_promotion'] select").on('change', updateFinalPrice);
        $("div[data-name='discount'] input").on('input', updateFinalPrice);
    });
})(jQuery);
</script>
<?php
});

