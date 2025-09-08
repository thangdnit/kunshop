<?php

/* Add CPT Products and Taxonomy */
if (!function_exists('my_custom_post_type')) {
    function my_custom_post_type() {
        register_post_type('product', [
            'labels' => [
                'name' => 'Products',
                'singular_name' => 'Product',
                'add_new' => 'Add New Product',
                'add_new_item' => 'Add New Product',
                'edit_item' => 'Edit Product',
                'new_item' => 'New Product',
                'view_item' => 'View Product',
                'search_items' => 'Search Products',
                'not_found' => 'No Products Found',
                'not_found_in_trash' => 'No Products Found in Trash'
            ],
            'public' => true,
            'menu_position' => 4,
            'menu_icon' => 'dashicons-cart',
            'supports' => ['title'],
            'taxonomies' => ['category' , 'post_tag'],
            'show_in_rest' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'san-pham-archive']
        ]);

        $taxonomies = [
            'brand' => 'Brand',
        ];

        foreach ($taxonomies as $taxonomy_slug => $taxonomy_name) {
            register_custom_taxonomy($taxonomy_slug, $taxonomy_name);
        }
    }

    function register_custom_taxonomy($taxonomy_slug, $taxonomy_name) {
        $labels = array(
            'name'                       => __( $taxonomy_name ),
            'singular_name'              => __( $taxonomy_name ),
            'menu_name'                  => __( $taxonomy_name ),
            'all_items'                  => __( 'All ' . $taxonomy_name ),
            'parent_item'                => __( 'Parent ' . $taxonomy_name ),
            'parent_item_colon'          => __( 'Parent ' . $taxonomy_name . ' :' ),
            'new_item_name'              => __( 'New ' . $taxonomy_name . ' Name' ),
            'add_new_item'               => __( 'Add New ' . $taxonomy_name ),
            'edit_item'                  => __( 'Edit ' . $taxonomy_name ),
            'update_item'                => __( 'Update ' . $taxonomy_name ),
            'view_item'                  => __( 'View ' . $taxonomy_name ),
            'separate_items_with_commas' => __( 'Separate ' . $taxonomy_name . ' with commas' ),
            'add_or_remove_items'        => __( 'Add or remove ' . $taxonomy_name ),
            'choose_from_most_used'      => __( 'Choose from the most used ' . $taxonomy_name ),
            'popular_items'              => __( 'Popular ' . $taxonomy_name ),
            'search_items'               => __( 'Search ' . $taxonomy_name ),
            'not_found'                  => __( 'Not Found' ),
            'no_terms'                   => __( 'No ' . $taxonomy_name ),
            'items_list'                 => __( 'List of ' . $taxonomy_name ),
            'items_list_navigation'      => __( 'List Navigation ' . $taxonomy_name ),
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'has_archive'                => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'rewrite'                    => array('slug' => $taxonomy_slug, 'with_front' => true, 'hierarchical' => false )
        );

        register_taxonomy($taxonomy_slug, array('product'), $args);
    }

    add_action('init', 'my_custom_post_type');
}

