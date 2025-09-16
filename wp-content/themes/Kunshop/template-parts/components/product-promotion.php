<div class="product-promotion">
    <div class="form-general_header">
        <span>Sản Phẩm Khuyến Mãi</span>
        <a class="absoblute d-inline-flex align-items-center shinehover text-semibold color-black" href="<?php echo get_page_link(11); ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a>
    </div>
    <div class="slider-product-promotion swiper-promotion">
        <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12,
                'meta_query' => array(
                    array(
                        'key' => 'price_setting_promotion',
                        'value' => true,
                        'compare' => '==',
                        'type' => 'BOOLEAN',
                        'orderby' => 'date',
                        'order' => 'DESC'
                    )
                )
            );
            $promo_query = new WP_Query($args);
            $idtab = 'promotion';
            if ($promo_query->have_posts()): ?>
                <?php include locate_template("template-parts/components/paginations/pagination-ajax.php")?>
                <div class="swiper-wrapper">
                    <?php while ($promo_query->have_posts()): ?>
                        <?php 
                            $promo_query->the_post();
                            
                            $price_setting = get_field('price_setting');
                            $price = $price_setting['final_price'];
                            $old_price = $price_setting['regular_price'];
                            $promotion = true;

                            $image = get_field('image');
                            $description = get_field('description');
                            $link = get_permalink();
                            $title = get_the_title();
                        ?>
                        <div class="swiper-slide">
                            <div class="product-box-item">
                                <?php include locate_template('template-parts/components/boxs/product-box.php'); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="form-general_header">
                    <span>Tạm thời ko có khuyến mãi nào</span>
                </div>
            <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>