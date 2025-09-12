<?php
    if (have_posts()):
        the_post();
        $highlight = get_field('highlight', 'option');
        $hotline = get_field('hotline', 'option');
        $zalo_id = get_field('zalo_id', 'option');
        $messenger = get_field('messenger', 'option');
        $highlight = get_field('highlight', 'option');
        $shopee = get_field('shopee', 'option');
        $lazada = get_field('lazada', 'option');
        $tiktok = get_field('tiktok', 'option');
        $product_note_title = get_field('product_note_title', 'option');
        $product_note = get_field('product_note', 'option');


        $title = get_the_title();
        $infomation = get_field('infomation');
        $code = get_field('code');
        $description = get_field('description');
        $gallery = get_field('gallery');

        $price_setting = get_field('price_setting');
        $price = $price_setting['final_price'];
        $old_price = $price_setting['regular_price'];
        $promotion = false;
        $discount = 0;
        $end_date = '';


        if ($price_setting['promotion'] == true) {
            $promotion = true;
            $promotion = get_field('promotion');
            if ($promotion['promotion_type'] == true) {
                $choose_promotion = $promotion['choose_promotion'];
                $discount = $choose_promotion->discount;
                $end_date = $choose_promotion->end_date;
            } else {
                $discount = $promotion['discount'];
                $end_date = $promotion['end_date'];
            }
        }

        $product_brand = get_field('product_brand');
        $product_category = get_field('product_category');

        set_query_var('product_title_single', $title);
        set_query_var('product_link', get_the_permalink());
?>
<section id="product-single" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <h1 class="title-page product-single-title"><?php echo $title; ?></h1>
        <div class="product-single-header">
            <div class="product-single-gallery">
                <?php for($i = 2; $i > 0; $i--): ?>
                    <div class="swiper-thumbnail-<?php echo $i; ?> slider-product-single-<?php echo $i; ?>">
                        <div class="swiper-wrapper">
                            <?php foreach ($gallery as $image): ?>
                                <div class="swiper-slide">
                                    <?php if ($i == 1): ?>
                                        <?php echo get_image($image['id']); ?>
                                    <?php else: ?>
                                        <?php echo get_image($image['id'], 'large'); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($i == 1): ?>
                            <div class="swiper-button-next-custom swiper-thumbnail-next bgrsize100"></div>
                            <div class="swiper-button-prev-custom swiper-thumbnail-prev bgrsize100"></div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="product-single-quote">
                <div class="product-single-price <?php echo $promotion ? 'flash-sale' : ''; ?>">
                    <?php if ($promotion): ?>
                        <div class="flashsale-icon bgrsize100 scale-infinite"></div>
                    <?php else: ?>
                        <div class="money-icon bgrsize100"></div>
                    <?php endif; ?>
                    <div class="new-price">
                        <?php echo format_price($price) ?>
                        <?php if ($promotion): ?>
                            <div class="old-price"><?php echo format_price($old_price); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if ($promotion): ?>
                        <div class="time-flashsale"><?php echo "Khuyến mãi đến hết ngày " . $end_date; ?></div>
                    <?php endif; ?>
                </div>
                <div class="product-excerpt"><?php echo $description; ?></div>
                
                <div class="product-single-form">
                    <a class="shinehover image-hover-effect" href="<?php echo $shopee; ?>" target="_blank">Shopee Shop<div class="shopeeColor-icon bgrsize100"></div></a>
                    <a class="shinehover image-hover-effect" href="<?php echo $lazada; ?>" target="_blank">Lazada Shop<div class="lazadaColor-icon bgrsize100"></div></a>
                    <a class="shinehover image-hover-effect" href="<?php echo $tiktok; ?>" target="_blank">TikTok Shop<div class="tiktokColor-icon bgrsize100"></div></a>
                </div>

                <div class="product-single-hotline">
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="tel:<?php echo $hotline; ?>">Hotline <?php echo $hotline; ?></a>
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="https://zalo.me/<?php echo $zalo_id; ?>"><div class="zalo-icon bgrsize100"></div></a>
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="<?php echo $messenger; ?>"><div class="mess-icon bgrsize100"></div></a>
                </div>

                <div class="product-single-note">
                    <div class="product-single-note__title text-bold color-primary"><?php echo $product_note_title; ?></div>
                    <?php foreach ($product_note as $note): ?>
                        <div class="product-single-note__item">
                            <?php echo get_image($note['icon']); ?>
                            <div><?php echo $note['title']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="product-single-content">
            <div class="product-single-info">
                <div class="product-single-info__title title-page">Thông tin sản phẩm</div>
                <div class="product-single-info__content">
                    <?php echo apply_filters('the_content', $infomation); ?>
                </div>
            </div>
            <div class="product-single-highlight">
                <?php foreach ($highlight as $item): ?>
                    <div>
                        <div class="product-single-highlight__icon">
                            <?php echo get_image($item['icon']); ?>
                        </div>
                        <div class="product-single-highlight__title text-bold color-white"><?php echo $item['title']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
            $posts_per_page = 8;
            $post__not_in = get_the_ID();

            $product_brand_id = $product_brand->term_id ? $product_brand->term_id : '';

            $product_category_ids = [];
            foreach ($product_category as $category) {
                $product_category_ids[] = $category->term_id;
            }

            $data = [
                'posts_per_page' => $posts_per_page,
                'post_type' => 'product',
                'post__not_in' => [$post__not_in],
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'product_brand',
                        'field' => 'term_id',
                        'terms' => $product_brand_id,
                    ],
                    [
                        'taxonomy' => 'product_category',
                        'field' => 'term_id',
                        'terms' => $product_category_ids,
                    ],
                ]
            ];
            
            $products = new WP_Query($data);
        ?>

        <div class="related-post product-single-related">
            <div class="related-post-title text-ultra">Có thể bạn quan tâm</div>
            <div class="swiper-multi slider-product-related slider-ajax">
                <div class="swiper-wrapper">
                    <?php if ($products->have_posts()): ?>
                        <?php while($products->have_posts()): ?>
                            <?php 
                                $products->the_post();

                                $price_setting = get_field('price_setting');
                                $price = $price_setting['final_price'];
                                $old_price = $price_setting['regular_price'];
                                $promotion = false;

                                if ($price_setting['promotion'] == true) {
                                    $promotion = true;
                                }

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
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                <div class="swiper-button-next-custom bgrsize100"></div>
                <div class="swiper-button-prev-custom bgrsize100"></div> 
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>