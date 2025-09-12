<?php

require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue-scripts.php';
require get_template_directory() . '/inc/support.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/api.php';
require get_template_directory() . '/inc/data-form.php';

// Place Holder Text
function register_global_texts() {
    global $placeholder_texts;
    $placeholder_texts = [
        'form_holder_name' => 'Nguyễn Văn A',
        'form_holder_title' => 'Cần tư vấn sản phẩm ABC ...',
        'form_holder_content' => 'Tôi muốn tư vấn về sản phẩm ...',
        'form_holder_phone' => '090',
        'form_holder_email' => 'abc@abc.com',
        'form_holder_search' => 'Nhập từ khoá...',
    ];
}
add_action('init', 'register_global_texts');