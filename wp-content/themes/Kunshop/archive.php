<?php
/**
 * @package xx
 * @subpackage xx
 * @since xx
 * 
 */
 get_header();

 $post_type = $wp_query->query;

 switch ($post_type['post_type']) {
    case 'product': 
        get_template_part('template-parts/archive/content', 'sanpham');
        break;
    default:
        get_template_part('template-parts/pages/content', '404');
        break;
 }
 get_footer();
?>