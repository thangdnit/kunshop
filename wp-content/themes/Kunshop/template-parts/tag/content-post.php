
<section id="post-page" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <?php if (have_posts()) : ?>
            <h1 class="title-page">Tag: <?php single_tag_title(); ?></h1>
            <div class="post-list">
                <?php while (have_posts()) {
                    the_post();
                    $post_id = get_the_ID();
                    include locate_template('template-parts/components/boxs/post-box.php');
                } ?>
            </div>
            <?php
                global $wp_query;
                $total_pages = $wp_query->max_num_pages;
                $current_page = max(1, get_query_var('paged')); 
            ?>
            <?php if ($total_pages >= 1) : ?>
                <?php include locate_template('template-parts/components/paginations/pagination-post.php')?>
            <?php endif; ?>
        <?php else : ?>
            <h1 class="title-not-found">Không có tin tức nào được tìm thấy !!!</h1>
        <?php endif; ?>
    </div>
</section>

