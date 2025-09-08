<?php

function theme_enqueue_scripts() {
    $url = get_template_directory_uri();
    // Add CSS
    wp_enqueue_style('bootstrap-style', $url . '/assets/css/bootstrap.min.css', [], '5.3.3');
    wp_enqueue_style('airdate-style', $url . '/assets/css/air-datepicker.css', [], '3.5.3');
    wp_enqueue_style('nouislider-style', $url . '/assets/css/nouislider.min.css', [], '15.8.1');
    wp_enqueue_style('icon-style', $url . '/assets/css/icon.css', [], '1.0.0');
    wp_enqueue_style('swiper-style', $url . '/assets/css/swiper-bundle.min.css', [], '11.1.15');
    wp_enqueue_style('swiper-material', $url . '/assets/css/effect-material.min.css', [], '11.1.15');
    wp_enqueue_style('root-style', $url . '/assets/css/root.css', [], '1.0.0');
    wp_enqueue_style('custom-style', $url . '/assets/css/custom.css', [], '1.0.0');
    wp_enqueue_style('component-style', $url . '/assets/css/component.css', [], '1.0.0');
    wp_enqueue_style('icon-style', $url . '/assets/css/icon.css', [], '1.0.0');
    
    // Add JS
    wp_enqueue_script('swup-js', 'https://unpkg.com/swup@4' , [], '4.8.1', true);
    wp_enqueue_script('bootstrap-js', $url . '/assets/js/bootstrap.bundle.min.js', [], '5.3.3', true);
    wp_enqueue_script('anime-js', $url . '/assets/js/anime.min.js', [], '3.2.2', true);
    wp_enqueue_script('nouislider-js', $url . '/assets/js/nouislider.min.js', [], '15.8.1', true);
    wp_enqueue_script('airdate-js', $url . '/assets/js/air-datepicker.js', [], '3.5.3', true);
    wp_enqueue_script('swiper-js', $url . '/assets/js/swiper-bundle.min.js', [], '11.1.15', true);
    wp_enqueue_script('swiper-material-js', $url . '/assets/js/effect-material.min.js', [], '11.1.15', true);
    wp_enqueue_script('custom-js', $url . '/assets/js/custom.js', [], '1.0.0', true);
    wp_enqueue_script('submit-form-js', $url . '/assets/js/submit-form.js', [], '1.0.0', true);

    wp_localize_script('custom-js', 'protected_data', [
        'products' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/products')
        ],
        'categories' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/categories')
        ],
        'brands' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/brand-products')
        ],
        'searchProducts' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/search-products')
        ],
        'signupEmail' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/signup-email'),
            'nonce' => wp_create_nonce('signup_email_nonce')
        ],
        'advise' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/advise-request'),
            'nonce' => wp_create_nonce('advise_nonce')
        ],
        'contact' => [
            'api_url' => home_url('/wp-json/kunshop83xcc3/v1/contact-form'),
            'nonce' => wp_create_nonce('contact_nonce')
        ],
    ]);
    
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');