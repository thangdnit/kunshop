<?php
/* Support Function */
function email_ok($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

/* Send Email Thank */
function sendEmailThank($email) {
    $email_thank = get_field('email_thank', 'option');
    $to = $email;
    $subject = sanitize_text_field($email_thank['title']);
    $message = sanitize_textarea_field($email_thank['message']);

    wp_mail($to, $subject, $message, $headers);
}

function sendAdviseToAdmin($data) {
    $to = get_option('admin_email');
    $subject = 'Yêu cầu tư vấn mới';
    $headers = [
        'From: Kun Shop',
        'Content-Type: text/html; charset=UTF-8',
    ];

    $message = '<html><body>';
    $message .= '<h2 style="color: #333;">Thông tin yêu cầu tư vấn</h2>';
    $message .= '<table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">';
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Tên người yêu cầu</td><td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($data['contact_name']) . '</td></tr>';
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Số điện thoại</td><td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($data['contact_phone']) . '</td></tr>';
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Tên sản phẩm cần tư vấn</td><td style="padding: 8px; border: 1px solid #ddd;"><a href="' . esc_url($data['product_link']) . '" target="_blank">' . esc_html($data['product_name']) . '</a></td></tr>';
    $message .= '</table>';
    $message .= '</body></html>';

    wp_mail($to, $subject, $message, $headers);
}

function sendContactToAdmin($data) {
    $to = get_option('admin_email');
    $subject = 'Yêu cầu liên hệ mới';
    $headers = [
        'From: Kun Shop',
        'Content-Type: text/html; charset=UTF-8',
    ];

    $message = '<html><body>';
    $message .= '<h2 style="color: #333;">Thông tin yêu cầu liên hệ</h2>';
    $message .= '<table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">';
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Tên người liên hệ</td><td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($data['contact_name']) . '</td></tr>';  
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Email</td><td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($data['contact_email']) . '</td></tr>';
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Chủ đề</td><td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($data['subject']) . '</td></tr>';
    $message .= '<tr><td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Nội dung</td><td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($data['message']) . '</td></tr>';
    $message .= '</table>';
    $message .= '</body></html>';

    wp_mail($to, $subject, $message, $headers);
}

/* Signup Request */
function check_email($email) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kunshop_newsletter';

    $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE email = %s", $email);
    $result = $wpdb->get_var($sql);

    if ($result > 0) {
        return false;
    }
    return true;
}

function save_email_to_database($email) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kunshop_newsletter';

    $data = [
        'email' => $email,
    ];

    $format = [
        '%s',
    ];

    $wpdb->insert($table_name, $data, $format);
}

function signup_email() {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = sanitize_email($data['email']);
    
    $result = [
        'success' => false,
        'message' => '',
    ];

    if (!email_ok($email)) {
        $result['message'] = 'Email chưa chính xác';
        return rest_ensure_response($result);
    }
    if (!check_email($email)) {
        $result['message'] = 'Email đã tồn tại';
        return rest_ensure_response($result);
    }
   
    save_email_to_database($email);

    $result['success'] = true;
    $result['message'] = 'Đăng ký thành công';

    return rest_ensure_response($result);
}

add_action ('rest_api_init', function () {
    register_rest_route('kunshop83xcc3/v1', '/signup-email', [
        'methods' => 'POST',
        'callback' => 'signup_email',
        'permission_callback' => (function () {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['nonce']) || !wp_verify_nonce($data['nonce'], 'signup_email_nonce')) {
                return [
                    'success' => false,
                    'message' => 'Nonce không hợp lệ',
                ];
            }
            return true;
        }),
    ]);
});

/* Advise Request */
function check_phone_advise($phone) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'advise_requests';

    $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE contact_phone = %s", $phone);
    $result = $wpdb->get_var($sql);

    if ($result > 10) {
        return false;
    }
    return true;
}

function save_advise_to_database($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'advise_requests';

    $data = [
        'contact_name' => $data['contact_name'],
        'contact_phone' => $data['contact_phone'],
        'product_name' => $data['product_name'],
        'product_link' => $data['product_link'],
    ];

    $format = [
        '%s',
        '%s',
        '%s',
        '%s',
    ];

    $wpdb->insert($table_name, $data, $format);
}

function advise_request() {
    $data = json_decode(file_get_contents('php://input'), true);

    $contact_name = sanitize_text_field($data['contact_name']);
    $contact_phone = sanitize_text_field($data['contact_phone']);
    $product_name = sanitize_text_field($data['product_name']);
    $product_link = sanitize_text_field($data['product_link']);

    $result = [
        'success' => false,
        'message' => '',
    ];

    if (!check_phone_advise($contact_phone)) {
        $result['message'] = 'Số điện thoại đã đăng ký tư vấn quá nhiều lần, vui lòng liên hệ trực tiếp với chúng tôi';
        return rest_ensure_response($result);
    }

    $infomation = [
        'contact_name' => $contact_name,
        'contact_phone' => $contact_phone,
        'product_name' => $product_name,
        'product_link' => $product_link,
    ];

    save_advise_to_database($infomation);
    sendAdviseToAdmin($infomation);

    $result['success'] = true;
    $result['message'] = 'Cám ơn bạn đã yêu cầu tư vấn, chúng tôi sẽ liên hệ với bạn sớm nhất có thể';

    return rest_ensure_response($result);
}

add_action('rest_api_init', function () {
    register_rest_route('product83xcc3/v1', '/advise-request', [
        'methods' => 'POST',
        'callback' => 'advise_request',
        'permission_callback' => (function () {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['nonce']) || !wp_verify_nonce($data['nonce'], 'advise_request_nonce')) {
                return [
                    'success' => false,
                    'message' => 'Nonce không hợp lệ',
                ];
            }
            return true;
        }),
    ]);
});

/* Contact Request */
function save_contact_to_database($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_requests';

    $data = [
        'contact_name' => $data['contact_name'],
        'contact_email' => $data['contact_email'],
        'subject' => $data['subject'],
        'message' => $data['message'],
    ];

    $format = [
        '%s',
        '%s',
        '%s',
        '%s',
    ];

    $wpdb->insert($table_name, $data, $format);
}

function contact_request() {
    $data = json_decode(file_get_contents('php://input'), true);

    $contact_name = sanitize_text_field($data['contact_name']);
    $contact_email = sanitize_email($data['contact_email']);
    $subject = sanitize_text_field($data['subject']);
    $message = sanitize_textarea_field($data['message']);

    $result = [
        'success' => false,
        'message' => '',
    ];

    if (!email_ok($contact_email)) {
        $result['message'] = 'Email chưa chính xác';
        return rest_ensure_response($result);
    }

    $infomation = [
        'contact_name' => $contact_name,
        'contact_email' => $contact_email,
        'subject' => $subject,
        'message' => $message,
    ];

    save_contact_to_database($infomation);
    sendContactToAdmin($infomation);
    sendEmailThank($contact_email);

    $result['success'] = true;
    $result['message'] = 'Cám ơn bạn đã liên hệ, chúng tôi sẽ phản hồi bạn sớm nhất có thể';

    return rest_ensure_response($result);
}