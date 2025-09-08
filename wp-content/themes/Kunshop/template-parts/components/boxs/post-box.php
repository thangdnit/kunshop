<div class="postbox">
    <a class="shinehover" href="<?php the_permalink(); ?>">
        <div class="postbox-thumbnail">
            <?php 
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, 'medium_large');
            } else {
                echo "<img src='" . theme_url . "/assets/images/no-image.jpg" . "' alt='No Image Thumbnail'>";
            }
            ?>
        </div>
    </a>
    <div class="postbox-time">
        <?php echo formatDate(get_the_date('Y-m-d', $post_id)); ?>
    </div>
    <div class="postbox-title text-semibold">
        <a class="shinehover" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </div>
</div>
<?php
