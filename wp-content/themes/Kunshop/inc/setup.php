<?php
define ('theme_url' , get_template_directory_uri() . "/");
/* Remove Version Wordpress */
remove_action('wp_head', 'wp_generator');
/* Custom Logo Login CMS */
function custom_login_logo() {
    echo '<style type="text/css">
        #login h1 a {
            background-image: url(' . theme_url . 'logo-login.png) !important;
            background-size: contain !important;
            width: 15rem !important;
            height: 15rem !important;
        }
    </style>';
}
add_action('login_head', 'custom_login_logo');
/* Custom Link Logo CMS */
function loginpage_custom_link(){
    return get_home_url();
}
add_filter('login_headerurl', 'loginpage_custom_link');
/* Remove menu function on CMS */
function remove_menus(){
    remove_menu_page('edit-comments.php'); /*Comments*/
}
add_action('admin_menu', 'remove_menus');
// Add menu function on CMS
add_theme_support( 'menus' );
register_nav_menus(
    [
        'primary' => 'Primary Menu',
        'footer_menu' => 'Footer Menu',
    ]
);
/* Remove emoji from loading on the frontend */
function disable_emoji_feature() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji');
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
    remove_filter( 'embed_head', 'print_emoji_detection_script' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    if (!is_admin()) {
        wp_deregister_script('wp-embed');
        wp_deregister_script('jquery');  
    }
    add_filter( 'option_use_smilies', '__return_false' );
}
function disable_emojis_tinymce( $plugins ) {
    if( is_array($plugins) ) {
        $plugins = array_diff( $plugins, array( 'wpemoji' ) );
    }
    return $plugins;
}
add_action('init', 'disable_emoji_feature');
function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); 
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );
/* Remove editor on CMS Page */
function hide_content_field_for_pages() {
    $policy_page_id = 20;
    if (is_admin() && get_post_type() === 'page') {
        if ($policy_page_id === get_the_ID()) {
            return;
        }
        ?>
        <style type="text/css">
            #postdivrich {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'hide_content_field_for_pages');
/* Theme Support */
add_theme_support('title-tag');
add_theme_support('post-thumbnails', ['post', 'san-pham']);
/* Create Table (Run once when setup themes)*/
function create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kunshop_newsletter';
    $charset_collate = $wpdb->get_charset_collate();

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            unread BOOLEAN DEFAULT 1,
            PRIMARY KEY (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_setup_theme', 'create_newsletter_table');
function create_contact_messages_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_messages';
    $charset_collate = $wpdb->get_charset_collate();

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            unread BOOLEAN DEFAULT 1,
            PRIMARY KEY (id)
        ) $charset_collate;";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_setup_theme', 'create_contact_messages_table');
/* Show Entries */
/* --Newsletter */
function my_newsletter_menu() {
    add_menu_page(
        'Quản lý Newsletter',       
        'Newsletter',                 
        'manage_options',             
        'newsletter_management',
        'display_newsletter_page',
        'dashicons-email',
        20 
    );
}
add_action('admin_menu', 'my_newsletter_menu');
function display_newsletter_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kunshop_newsletter';

    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

    $where = '';
    if (!empty($search)) {
        $where = $wpdb->prepare("WHERE email LIKE %s", '%' . $wpdb->esc_like($search) . '%');
    }

    if (isset($_POST['bulk_delete'])) {
        if (!empty($_POST['delete_ids'])) {
            foreach ($_POST['delete_ids'] as $id) {
                $wpdb->delete($table_name, ['id' => (int)$id]);
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $wpdb->delete($table_name, ['id' => $id]);
    }

    $limit = 100;
    $page = isset($_GET['paged']) ? (int)$_GET['paged'] : 1;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM $table_name $where LIMIT $offset, $limit";
    $results = $wpdb->get_results($sql);

    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $total_pages = ceil($total_items / $limit);
    ?>
    <div class="wrap">
        <h2>Quản lý Newsletter</h2>

        <form method="get" action="" class="search-form" style="margin-bottom: 20px; margin-top: 20px;">
            <input type="hidden" name="page" value="newsletter_management">
            <input type="text" name="search" value="<?php echo esc_attr($search); ?>" placeholder="Tìm kiếm email..." class="regular-text">
            <button type="submit" class="button button-primary">Tìm kiếm</button>
        </form>

        <form method="post" action="" style="margin-bottom: 20px; margin-top: 20px; width: 50%">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all"></th>
                        <th>Email</th>
                        <th>Ngày đăng ký</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results) : ?>
                        <?php foreach ($results as $key => $item) : ?>
                            <tr>
                                <td><input type="checkbox" name="delete_ids[]" value="<?php echo $item->id; ?>"></td>
                                <td><?php echo esc_html($item->email); ?></td>
                                <td><?php echo esc_html($item->created_at); ?></td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=newsletter_management&delete=' . $item->id); ?>" class="button button-secondary" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="4">Chưa có email đăng ký nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (!empty($results)) : ?>
                <input type="submit" name="bulk_delete" value="Xóa đã chọn" class="button button-primary" style="margin-top: 20px;">
            <?php endif; ?>
        </form>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $url = add_query_arg('paged', $i);
                if ($search) {
                    $url = add_query_arg('search', $search, $url);
                }
                echo '<a href="' . $url . '" ' . ($i == $page ? 'class="button button-secondary current"' : 'class="button button-secondary"') . '>' . $i . '</a> ';
            }
            ?>
        </div>
    </div>

    <script>
        document.getElementById('select_all').addEventListener('click', function () {
            let checkboxes = document.querySelectorAll('input[name="delete_ids[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = document.getElementById('select_all').checked;
            });
        });
    </script>
    <style>
        .pagination .button.current {
            background-color: #0073aa;
            color: #fff;
        }
        .pagination .button:hover {
            text-decoration: none;
            background-color: #006799;
        }
    </style>
<?php
}
/* --Contact */
function my_contact_menu() {
    add_menu_page(
        'Tin nhắn liên hệ',       
        'Liên hệ',                 
        'manage_options',             
        'contact_management',
        'display_contact_page',
        'dashicons-email-alt', 23 
    );
}
add_action('admin_menu', 'my_contact_menu');
function display_contact_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_messages';

    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

    $where = '';
    if (!empty($search)) {
        $where = $wpdb->prepare(
            "WHERE name LIKE %s OR email LIKE %s OR subject LIKE %s OR message LIKE %s",
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%'
        );
    }

    if (isset($_POST['bulk_delete'])) {
        if (!empty($_POST['delete_ids'])) {
            foreach ($_POST['delete_ids'] as $id) {
                $wpdb->delete($table_name, ['id' => (int)$id]);
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $wpdb->delete($table_name, ['id' => $id]);
    }

    $limit = 100;
    $page = isset($_GET['paged']) ? (int)$_GET['paged'] : 1;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM $table_name $where ORDER BY created_at DESC LIMIT %d OFFSET %d";
    $results = $wpdb->get_results($wpdb->prepare($sql, $limit, $offset));

    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $total_pages = ceil($total_items / $limit);

    ?>
    <div class="wrap">
        <h2>Danh sách tin nhắn liên hệ</h2>

        <form method="get" action="" style="margin-bottom: 20px; margin-top: 20px;">
            <input type="hidden" name="page" value="contact_management">
            <input type="text" name="search" placeholder="Tìm kiếm tên, email, chủ đề, nội dung..." value="<?php echo esc_attr($search); ?>" />
            <button type="submit" class="button button-primary">Tìm kiếm</button>
        </form>

        <form method="post" action="" style="margin-bottom: 20px; margin-top: 20px; width: 80%">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 5%;"><input type="checkbox" id="select_all"></th>
                        <th>Tên người liên hệ</th>
                        <th>Email</th>
                        <th>Chủ đề</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results) : ?>
                        <?php foreach ($results as $item) : ?>
                            <tr>
                                <td><input type="checkbox" name="delete_ids[]" value="<?php echo esc_attr($item->id); ?>"></td>
                                <td><?php echo esc_html($item->name); ?></td>
                                <td><?php echo esc_html($item->email); ?></td       >
                                <td><?php echo esc_html($item->subject); ?></td>
                                <td><?php echo esc_html($item->message); ?></td>
                                <td><?php echo esc_html($item->created_at); ?></td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=contact_management&delete=' . $item->id); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')" class="button button-secondary">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="7">Chưa có tin nhắn liên hệ nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>    
            <?php if (!empty($results)) : ?>
                <input type="submit" name="bulk_delete" value="Xóa đã chọn" class="button button-primary" style="margin-top: 20px;">
            <?php endif; ?>
        </form>
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $url = add_query_arg('paged', $i);
                if ($search) {
                    $url = add_query_arg('search', $search, $url);
                }
                echo '<a href="' . $url . '" ' . ($i == $page ? 'class="button button-secondary current"' : 'class="button button-secondary"') . '>' . $i . '</a> ';
            }
            ?>
        </div>
    </div>
    <script>
        document.getElementById('select_all').addEventListener('click', function () {
            let checkboxes = document.querySelectorAll('input[name="delete_ids[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = document.getElementById('select_all').checked;
            });
        });
    </script>
    <style>
        .pagination .button.current {
            background-color: #0073aa;
            color: #fff;
        }
        .pagination .button:hover {
            text-decoration: none;
            background-color: #006799;
        }
    </style>
<?php
}