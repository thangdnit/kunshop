<?php
    if (have_posts()):
        the_post();
?>
<section id="post-single" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <h1 class="title-page post-single-title"><?php the_title(); ?></h1>
         
        <div class="post-single-time">
            <?php echo formatDate(get_the_date('Y-m-d')); ?>
        </div>

        <div class="post-single-thumbnail">
            <?php 
            if (has_post_thumbnail()) {
                the_post_thumbnail('full');
            } else {
                echo "<img src='" . theme_url . "/assets/images/no-image.jpg" . "' alt='No Image Thumbnail'>";
            }
            ?>
        </div>

        <div class="post-single-content">
            <?php the_content(); ?>
        </div>

        <div class="post-single-share">
            <div class="share-list d-inline-flex">
                <div class="post-single-share-title text-semibold">Chia sẻ bài viết này</div>
                <div class="post-single-share-social d-inline-flex">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="shinehover">
                        <div class="fbshare-icon bgrsize100"></div>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="shinehover">
                        <div class="twitter-icon bgrsize100"></div>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" class="shinehover">
                        <div class="linkedin-icon bgrsize100"></div>
                    </a>
                </div>
            </div>
            <div class="tag-list">
                <?php the_tags('', ''); ?>
            </div>
        </div>

        <div class="related-post">
            <div class="related-post-title text-ultra">Bài viết liên quan</div>
            <div class="post-list">
                <?php
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post__not_in'   => array(get_the_ID()),       
                    );
                
                    $query = new WP_Query($args);
                ?>

                <?php while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    include locate_template('template-parts/components/boxs/post-box.php'); 
                } ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>