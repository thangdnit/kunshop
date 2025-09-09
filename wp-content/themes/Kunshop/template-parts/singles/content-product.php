<?php
    if (have_posts()):
        the_post();
        $highlight = get_field('highlight', 'option');
        $hotline = get_field('hotline', 'option');
        $zalo_id = get_field('zalo_id', 'option');

        $title = get_the_title();
        $content = get_the_content();
        $description = get_field('description');
        $gallery = get_field('gallery');
        $price = get_field('price');

        set_query_var('product_title_single', $title);
        set_query_var('product_link', get_the_permalink());
?>
<section id="product-single" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <h1 class="title-page product-single-title"><?php echo $title; ?></h1>
        <h2 class="product-excerpt"><?php echo $description; ?></h2>

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
                    <div><?php echo $price; ?></div>
                </div>
                <div class="product-single-form">
                    <div class="product-single-form__button">
                        <a class="shinehover" data-bs-toggle="modal" data-bs-target="#quoteModal">Báo giá lăn bánh<div class="money-icon bgrsize100"></div></a>
                        <a class="shinehover" data-bs-toggle="modal" data-bs-target="#registerDriveModal">Đăng ký lái thử<div class="drive-icon bgrsize100"></div></a>
                    </div>
                    <div class="product_single-form__quote">
                        <?php include locate_template("template-parts/components/forms/form-advise.php") ?>
                    </div>
                </div>
                <div class="product-single-hotline">
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="tel:<?php echo $hotline; ?>">Hotline <?php echo $hotline; ?></a>
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="https://zalo.me/<?php echo $zalo_id; ?>"><div class="zalo-icon bgrsize100"></div></a>
                </div>
            </div>
        </div>

        <div class="product-single-content">
            <div class="product-single-info">
                <div class="product-single-info__title title-page">Thông tin sản phẩm</div>
                <div class="product-single-info__content">
                    <?php echo apply_filters('the_content', $content); ?>
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
            $number_products = 8;
            $posts_per_page = 4;
            $post__not_in = get_the_ID();
            $total_pages = ceil($number_products / $posts_per_page);

            $product_tag = get_field('product_tag');
            $product_brand = get_field('product_brand');
            $product_category = get_field('product_category');

            $product_tag_ids = [];
            foreach ($product_tag as $tag) {
                $product_tag_ids[] = $tag->term_id;
            }

            $product_brand_ids = [];
            foreach ($product_brand as $brand) {
                $product_brand_ids[] = $brand->term_id;
            }

            $product_category_ids = [];
            foreach ($product_category as $category) {
                $product_category_ids[] = $category->term_id;
            }

            $data = [
                'posts_per_page' => $posts_per_page,
                'paged' => 1,
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
                        <div class="swiper-slide">
                            <?php if ($products->have_posts()): ?>
                                <?php while($products->have_posts()): ?>
                                    <?php 
                                        $products->the_post();
                                        $code = get_field('code');
                                        $price = get_field('price');
                                        $promotion_price = get_field('promotion_price');
                                        $image = get_field('image');
                                        $description = get_field('description');
                                        $link = get_permalink();
                                        $title = get_the_title();
                                        $product_tag = get_the_terms(get_the_ID(), 'product_tag');
                                    ?>
                                    <div class="product-box-item">
                                        <?php include locate_template('template-parts/components/boxs/product-box.php'); ?>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                </div>
                <?php include locate_template("template-parts/components/paginations/pagination-ajax.php")?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>