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
        $price = get_field('price');

        $product_tag = get_field('product_tag');
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
                <div class="product-single-price color-primary text-ultra">
                    <div class="money-icon bgrsize100"></div>
                    <div><?php echo format_price($price) ?><span> - 100.000 đ</span></div>
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

            $product_tag_ids = [];
            foreach ($product_tag as $tag) {
                $product_tag_ids[] = $tag->term_id;
            }

            $product_brand_ids = $product_brand ? [$product_brand->term_id] : [];

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
                        'taxonomy' => 'product_tag',
                        'field' => 'term_id',
                        'terms' => $product_tag_ids,
                    ],
                    [
                        'taxonomy' => 'product_brand',
                        'field' => 'term_id',
                        'terms' => $product_brand_ids,
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
                                $code = get_field('code');
                                $price = get_field('price');
                                $image = get_field('image');
                                $description = get_field('description');
                                $link = get_permalink();
                                $title = get_the_title();
                                $product_tag = get_the_terms(get_the_ID(), 'product_tag');
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