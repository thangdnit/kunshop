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
    $post__not_in = intval($params['post__not_in' . $idtab] ?? 0);
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
            $price = get_field('price');
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

                $data['keyword_search'] = $keyword;
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
            $price = get_field('price');
            $image = get_field('image');
            $description = get_field('description');
            $link = get_permalink();
            $title = get_the_title();
            $product_tag = get_the_terms(get_the_ID(), 'product_tag');
            
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

/* Custom Query Search */
function custom_keyword_search($where, $query) {
    global $wpdb;

    $search_keyword = $query->get('keyword_search');

    if (!empty($search_keyword)) {
        $where .= $wpdb->prepare(
            " AND ({$wpdb->posts}.post_title LIKE %s 
                OR {$wpdb->posts}.ID IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS tr
                    INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
                    WHERE t.name LIKE %s
                )
                OR {$wpdb->posts}.ID IN (
                    SELECT post_id
                    FROM {$wpdb->postmeta}
                    WHERE meta_value LIKE %s
                      AND meta_key IN ('description', 'infomation')
                )
            )",
            "%{$search_keyword}%",
            "%{$search_keyword}%",
            "%{$search_keyword}%",
        );
    }

    return $where;
}
add_filter('posts_where', 'custom_keyword_search', 10, 2);