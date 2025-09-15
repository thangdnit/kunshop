<?php
add_action('init', function() {
    header('Access-Control-Allow-Origin: ' . get_home_url());
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: X-WP-Nonce, Content-Type');
});

// Load products
function load_products(WP_REST_Request $request) {
    $params = $request->get_params();

    $idtab = sanitize_text_field( $params['idtab'] ?? '' );
    $posts_per_page = intval($params['posts_per_page' . $idtab] ?? -1);
    $page_loaded = intval($params['page_loaded' . $idtab] ?? 1) + 1;

    $data = [
        'posts_per_page' => $posts_per_page,
        'paged' => $page_loaded,
        'post_type' => 'product'
    ];

    $data['tax_query'] = [
        [
            'taxonomy' => 'product_category',
            'field' => 'term_id',
            'terms' => intval($params['category_id' . $idtab]),
        ],
    ];
    $products = new WP_Query($data);

    $data_products = [];
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            
            $price_setting = get_field('price_setting');
            $price = $price_setting['final_price'];
            $old_price = $price_setting['regular_price'];
            $promotion = false;

            if ($price_setting['promotion'] == true) {
                $promotion = true;
            }

            $image = get_field('image');
            $description = get_field('description');
            $link = get_permalink();
            $title = get_the_title();

            ob_start();
            include locate_template("template-parts/components/boxs/product-box.php");
            $data_product['html'] = ob_get_clean();

            $data_products[] = $data_product;
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($data_products);
}

add_action('rest_api_init', function () {
    register_rest_route('kunshop83xcc3/v1', '/products', [
        'methods' => 'GET',
        'callback' => 'load_products',
        'permission_callback' => '__return_true',
    ]);
});

// Load products Filter Main
function load_products_filter(WP_REST_Request $request) { 
    $params = $request->get_params();

    $posts_per_page = 8;
    
    $data = [
        'posts_per_page' => $posts_per_page,
        'paged' => intval($params['paged'] ?? 1),
        'post_type' => 'product',
    ];

    foreach ($params as $key => $value) {
        if ($key === 'price_min' || $key === 'price_max') {
            $data['meta_query'][] = [
                'key' => 'price',
                'value' => [intval($params['price_min']), intval($params['price_max'])],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC',
            ];
            continue;
        }
        if (strpos($key, 'product-filter__') !== false && $value != 0) {
            if ($key === 'product-filter__keyword') {
                $keyword = sanitize_text_field($value);

                $data['s'] = $keyword;
                continue;
            }
            $taxonomy = str_replace('product-filter__', '', $key);
            $array_value = array_filter(array_map('intval', explode(',', $value)));
            if (empty($array_value)) {
                continue;
            }
            $data['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $array_value,
            ];
        }
    }

    $products = new WP_Query($data);

    $data_products = [];
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();

            $price_setting = get_field('price_setting');
            $price = $price_setting['final_price'];
            $old_price = $price_setting['regular_price'];
            $promotion = false;
            if ($price_setting['promotion'] == true) {
                $promotion = true;
            }

            $image = get_field('image');
            $description = get_field('description');
            $link = get_permalink();
            $title = get_the_title();
            
            ob_start();
            include locate_template("template-parts/components/boxs/product-box.php");
            $data_product['html'] = ob_get_clean();

            $data_products[] = $data_product;
        }

        ob_start();
        $total_pages = $products->max_num_pages;
        $current_page = intval($params['paged'] ?? 1);
        include locate_template("template-parts/components/paginations/pagination-ajax-filter.php");
        $pagination['pagination'] = ob_get_clean();

        $data_products[] = $pagination;
        wp_reset_postdata();
    }

    return rest_ensure_response($data_products);
}

add_action('rest_api_init', function () {
    register_rest_route('kunshop83xcc3/v1', '/search-products', [
        'methods' => 'GET',
        'callback' => 'load_products_filter',
        'permission_callback' => '__return_true',
    ]);
});

/* Get Promotion Discount */
function get_promotion_discount(WP_REST_Request $request) {
    $term_id = intval($request->get_param('term_id'));
    if (!$term_id) {
        return null;
    }

    $data['discount'] = get_term_meta($term_id, 'discount', true);

    return rest_ensure_response($data);
}

add_action('rest_api_init', function () {
    register_rest_route('kunshop83xcc3/v1', '/get-promotion-discount', [
        'methods' => 'GET',
        'callback' => 'get_promotion_discount',
        'permission_callback' => '__return_true',
    ]);
});
