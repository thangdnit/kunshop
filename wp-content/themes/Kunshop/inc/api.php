<?php
add_action('init', function() {
    header('Access-Control-Allow-Origin: ' . get_home_url());
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: X-WP-Nonce, Content-Type');
});

// Load Cars
function load_cars(WP_REST_Request $request) {
    $params = $request->get_params();

    $idtab = sanitize_text_field( $params['idtab'] ?? '' );
    $posts_per_page = intval($params['posts_per_page' . $idtab] ?? -1);
    $post__not_in = intval($params['post__not_in' . $idtab] ?? 0);
    $page_loaded = intval($params['page_loaded' . $idtab] ?? 1) + 1;

    $data = [
        'posts_per_page' => $posts_per_page,
        'paged' => $page_loaded,
    ];

    if ($idtab != '') {
        $data['tax_query'] = [
            'relation' => 'AND',
            [
                'taxonomy' => 'tag-xe',
                'field' => 'term_id',
                'terms' => intval($params['tag_id' . $idtab]),
            ],
        ];
    }else{
        $hang_xe_id = explode(',', $params['hang_xe_id']);
        $tag_id = explode(',', $params['tag_id']);

        $hang_xe_id = array_map('intval', $hang_xe_id);
        $tag_id = array_map('intval', $tag_id);
        
        $data['post__not_in'] = [$post__not_in];
        $data['tax_query'] = [
            'relation' => 'OR',
            [
                'taxonomy' => 'hang-xe',
                'field'    => 'term_id',
                'terms'    => $hang_xe_id,
                'operator' => 'IN',
            ],
            [
                'taxonomy' => 'loai-xe',
                'field'    => 'term_id',
                'terms'    => intval($params['loai_xe_id']),
            ],
            [
                'taxonomy' => 'loai-hop-so',
                'field'    => 'term_id',
                'terms'    => intval($params['loai_hop_so_id']),
            ],
            [
                'taxonomy' => 'mau-xe',
                'field'    => 'term_id',
                'terms'    => intval($params['mau_xe_id']),
            ],
            [
                'taxonomy' => 'tinh-trang',
                'field'    => 'term_id',
                'terms'    => intval($params['tinh_trang_id']),
            ],
            [
                'taxonomy' => 'tag-xe',
                'field'    => 'term_id',
                'terms'    => $tag_id,
                'operator' => 'IN',
            ],
        ];
    }
    $cars = ToanCar\Car::get_cars($data);

    $data_cars = [];
    if ($cars->have_posts()) {
        while ($cars->have_posts()) {
            $cars->the_post();
            $car = new ToanCar\Car(
                [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                ]
            );
            ob_start();
            include locate_template("template-parts/components/boxs/car-box.php");
            $data_car['html'] = ob_get_clean();

            $data_cars[] = $data_car;
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($data_cars);
}

add_action('rest_api_init', function () {
    register_rest_route('toancar83xcc3/v1', '/cars', [
        'methods' => 'GET',
        'callback' => 'load_cars',
        'permission_callback' => '__return_true',
    ]);
});

// Load Model Cars
function load_model_cars(WP_REST_Request $request) {
    $brand = intval($request->get_param('model')) ?? 0;

    $args = [
        'taxonomy' => 'hang-xe',
        'hide_empty' => false,
    ];

    if ($brand != 0) {
        $args['parent'] = $brand;
    }

    $terms = get_terms($args);

    if ($brand == 0) {
        $terms = array_filter($terms, function ($term) {
            return $term->parent != 0;
        });
    }

    $data = [];
    foreach ($terms as $term) {
        $data[] = [
            'id' => $term->term_id,
            'name' => $term->name,
        ];
    }

    return rest_ensure_response($data);
}

add_action('rest_api_init', function () {
    register_rest_route('toancar83xcc3/v1', '/model-cars', [
        'methods' => 'GET',
        'callback' => 'load_model_cars',
        'permission_callback' => '__return_true',
    ]);
});

// Load Brand Cars
function load_brand_cars(WP_REST_Request $request) {
    $model = intval($request->get_param('model')) ?? 0;
    $term = get_term($model, 'hang-xe');

    return rest_ensure_response(['parent_id' => $term->parent]);
}

add_action('rest_api_init', function () {
    register_rest_route('toancar83xcc3/v1', '/brand-cars', [
        'methods' => 'GET',
        'callback' => 'load_brand_cars',
        'permission_callback' => '__return_true',
    ]);
});

// Load Cars Filter Main
function load_cars_filter(WP_REST_Request $request) { 
    $params = $request->get_params();

    $widthValue = intval(get_option('widthValue'));
    $posts_per_page = $widthValue < 801 ? 4 : get_field('cars_per_page', 'option');
    
    $data = [
        'posts_per_page' => $posts_per_page,
        'paged' => intval($params['paged'] ?? 1), 
    ];

    foreach ($params as $key => $value) {
        if ($key === 'price_min' || $key === 'price_max') {
            $data['meta_query'][] = [
                [
                    'key' => 'general_price',
                    'value' => [intval($params['price_min']), intval($params['price_max'])],
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC',
                ],
            ];
            continue;
        }
        if (strpos($key, 'car-filter__') !== false && $value != 0) {
            if ($key === 'car-filter__keyword') {
                $keyword = sanitize_text_field($value);

                $data['keyword_search'] = $keyword;
                
                continue;
            }
            if ($key === 'car-filter__dong-xe') {
                continue;
            }
            if ($key == 'car-filter__hang-xe') {
                $id_term = intval($value);
                if (intval($params['car-filter__dong-xe']) != 0) {
                    $id_term = intval($params['car-filter__dong-xe']);
                }

                $data['tax_query'][] = [
                    'taxonomy' => 'hang-xe',
                    'field' => 'term_id',
                    'terms' => $id_term,
                ];
                continue;
            }

            $taxonomy = str_replace('car-filter__', '', $key);
            $data['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => intval($value),
            ];

        }
    }

    $cars = ToanCar\Car::get_cars($data);

    $data_cars = [];
    if ($cars->have_posts()) {
        while ($cars->have_posts()) {
            $cars->the_post();
            $car = new ToanCar\Car(
                [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                ]
            );
            ob_start();
            include locate_template("template-parts/components/boxs/car-box.php");
            $data_car['html'] = ob_get_clean();

            $data_cars[] = $data_car;
        }

        ob_start();
        $total_pages = $cars->max_num_pages;
        $current_page = intval($params['paged'] ?? 1);
        include locate_template("template-parts/components/paginations/pagination-ajax-filter.php");
        $pagination['pagination'] = ob_get_clean();

        $data_cars[] = $pagination;
        wp_reset_postdata();
    }

    return rest_ensure_response($data_cars);
}

add_action('rest_api_init', function () {
    register_rest_route('toancar83xcc3/v1', '/search-cars', [
        'methods' => 'GET',
        'callback' => 'load_cars_filter',
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
                OR {$wpdb->posts}.post_excerpt LIKE %s 
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
                      AND meta_key IN ('advanced_he_dan_dong', 'advanced_so_cho_ngoi', 
                      'advanced_nam_san_xuat', 'advanced_gam_xe', 'advanced_phien_ban',
                      'advanced_dung_tich_dong_co', 'advanced_nhien_lieu', 'advanced_so_km_da_di', 'advanced_vong_tua')
                )
            )",
            "%{$search_keyword}%",
            "%{$search_keyword}%",
            "%{$search_keyword}%",
            "%{$search_keyword}%"
        );
    }

    return $where;
}
add_filter('posts_where', 'custom_keyword_search', 10, 2);

// Load Width User
function load_width_user(WP_REST_Request $request) {
    $width = intval($request->get_param('width'));
    update_option('widthValue', $width);
    
    return rest_ensure_response(array(
        'status' => 'success',
        'widthValue' => $width,
    ));
}

add_action('rest_api_init', function () {
    register_rest_route('toancar83xcc3/v1', '/width-user', [
        'methods' => 'GET',
        'callback' => 'load_width_user',
        'permission_callback' => '__return_true',
    ]);
});



