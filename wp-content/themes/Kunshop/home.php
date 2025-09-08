<?php get_header(); ?>

<?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = get_option('posts_per_page');
    $sort_by = get_field('sort_for_posts', 'option');

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,      
        'paged'          => $paged,
    );

    if ($sort_by == 'date') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC' ;
        $args['suppress_filters'] = true;
        $args['ignore_custom_sort'] = true;
    }

    $query = new WP_Query($args);
?>

<section id="post-page" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <?php if ($query->have_posts()) : ?>
            <h1 style="display: none;">Tin tức</h1>
            <div class="post-list">
                <?php while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    include locate_template('template-parts/components/boxs/post-box.php'); 
                } ?>
            </div>
            <?php
                $total_pages = $query->max_num_pages;
                $current_page = max(1, get_query_var('paged'));
            ?>
            <?php if ($total_pages > 1) : ?>
                <?php include locate_template('template-parts/components/paginations/pagination-post.php')?>
            <?php endif; ?>
        <?php else : ?>
            <h1 class="title-not-found">Không có tin tức nào được tìm thấy !!!</h1>
        <?php endif; ?>
    </div>
</section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>