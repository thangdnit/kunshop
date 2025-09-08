<?php
    if (have_posts()):
        the_post();
        $highlight = get_field('highlight', 'option');
        $phone = get_field('phone', 'option');
        $zalo = get_field('zalo', 'option');
        
        $data_product = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'excerpt' => get_the_excerpt(),
        ];
        
        $product = new Toanproduct\product($data_product);
        $title = $product->get_title();
        $excerpt = $product->get_excerpt();
        $price = $product->get_price();
        $advanced = $product->get_advanced();
        $advanced_label = $product->get_advanced_label();
        $youtube = $product->get_youtube();
        $gallery = $product->get_gallery();

        $hang_xe = $product->get_term_product('hang-xe');
        $loai_xe = $product->get_term_product('loai-xe');
        $loai_hop_so = $product->get_term_product('loai-hop-so');
        $mau_xe = $product->get_term_product('mau-xe');
        $tinh_trang = $product->get_term_product('tinh-trang');
        $tag_xe = $product->get_term_product('tag-xe');
        $extend = $product->get_extend();

        set_query_var('product_title_single', $title);
        set_query_var('product_link', get_the_permalink());
?>
<section id="product-single" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <h1 class="title-page product-single-title"><?php echo $title; ?></h1>
        <h2 class="product-excerpt"><?php echo $excerpt; ?></h2>
        <div class="product-advanced text-semibold color-primary">
            <div>
                <div class="dateBlue-icon bgrsize100"></div>
                <?php echo $advanced['nam_san_xuat'] ?>
            </div>
            <div>
                <div class="odo-icon bgrsize100"></div>
                <?php echo $advanced['so_km_da_di'] . ' km' ?>
            </div>
            <div>
                <div class="transmission-icon bgrsize100"></div>
                <?php echo $loai_hop_so->name ?>
            </div>
            <div>
                <div class="fuel-icon bgrsize100"></div>
                <?php echo $advanced['nhien_lieu'] ?>
            </div>
        </div>

        <div class="product-single-header">
            <div class="product-single-gallery">
                <?php for($i = 2; $i > 0; $i--): ?>
                    <div class="swiper-thumbnail-<?php echo $i; ?> slider-product-single-<?php echo $i; ?>">
                        <div class="swiper-wrapper">
                            <?php if ($youtube): ?>
                                <div class="swiper-slide">
                                    <?php if ($i == 1): ?>
                                        <img src="https://img.youtube.com/vi/<?php echo $youtube; ?>/hqdefault.jpg" alt="Video Thumbnail">
                                    <?php else: ?>
                                    <div class="youtube-container">
                                        <iframe src="https://www.youtube-nocookie.com/embed/<?php echo $youtube; ?>?si=olu7twuBY-biIYeu&amp;start=1" 
                                            title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                        </iframe>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?> 

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
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="tel:<?php echo $phone?>">Hotline <?php echo $phone; ?></a>
                    <a target="_blank" class="shinehover image-hover-effect text-bold color-primary" href="https://zalo.me/<?php echo $zalo; ?>"><div class="zalo-icon bgrsize100"></div></a>
                </div>
            </div>
        </div>

        <div class="product-single-content">
            <div class="product-single-info">
                <div class="product-single-info__title title-page">Tổng quan về xe</div>
                <div class="product-single-info__content">
                    <?php foreach ($advanced_label['sub_fields'] as $index => $field): ?>
                        <?php
                            $field_name  = $field['name'];
                            $field_label = $field['label'];
                            $field_value = $advanced[$field_name] ?? '(empty)';
                        ?>
                        <?php if ($index == 0): ?>
                            <div>
                                <div class="color-primary text-bold">Hãng xe</div>
                                <?php
                                    $name_hangxe = '';
                                    foreach ($hang_xe as $index => $item){
                                        $name_hangxe .= $item->name;
                                        if($index < count($hang_xe) - 1){
                                            $name_hangxe .= ' - ';
                                        }
                                    }
                                ?>
                                <div><?php echo $name_hangxe; ?></div>
                            </div>
                            
                            <div>
                                <div class="color-primary text-bold">Loại xe</div>
                                <div><?php echo $loai_xe->name; ?></div>
                            </div>

                            <div>
                                <div class="color-primary text-bold">Loại hộp số</div>
                                <div><?php echo $loai_hop_so->name; ?></div>
                            </div>
                            <?php continue; ?>
                        <?php endif;?>
                            <?php if ($index == 8): ?>
                            <div>
                                <div class="color-primary text-bold">Màu xe</div>
                                <div><?php echo $mau_xe->name ?></div>
                            </div>
                            <?php continue; ?>
                        <?php endif;?>

                        <div>
                            <div class="color-primary text-bold"><?php echo $field_label; ?></div>
                            <div><?php echo $field_value; ?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php if($extend): ?>
                        <?php foreach($extend as $item): ?>
                        <div>
                            <div class="color-primary text-bold"><?php echo $item['key']; ?></div>
                            <div><?php echo $item['value']; ?></div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
            $widthValue = intval(get_option('widthValue'));

            $number_products = get_field('product_related', 'option');
            $posts_per_page = $widthValue < 801 ? 1 : 4;
            $post__not_in = $product->get_id();
            $total_pages = ceil($number_products / $posts_per_page);
            $idtab = '';

            $tag_id = [];
            foreach ($tag_xe as $tag) {
                $tag_id[] = $tag->term_id;
            }

            $hang_xe_id = [];
            foreach ($hang_xe as $hang) {
                $hang_xe_id[] = $hang->term_id;
            }

            $loai_xe_id = $loai_xe->term_id;
            $loai_hop_so_id = $loai_hop_so->term_id;
            $mau_xe_id = $mau_xe->term_id;
            $tinh_trang_id = $tinh_trang->term_id;

            $data = [
                'posts_per_page' => $posts_per_page,
                'paged' => 1,
                'post__not_in' => [$post__not_in],
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'hang-xe',
                        'field'    => 'term_id',
                        'terms'    => $hang_xe_id,
                        'operator' => 'IN',
                    ],
                    [
                        'taxonomy' => 'loai-xe',
                        'field'    => 'term_id',
                        'terms'    => $loai_xe_id,
                    ],
                    [
                        'taxonomy' => 'loai-hop-so',
                        'field'    => 'term_id',
                        'terms'    => $loai_hop_so_id,
                    ],
                    [
                        'taxonomy' => 'mau-xe',
                        'field'    => 'term_id',
                        'terms'    => $mau_xe_id,
                    ],
                    [
                        'taxonomy' => 'tinh-trang',
                        'field'    => 'term_id',
                        'terms'    => $tinh_trang_id,
                    ],
                    [
                        'taxonomy' => 'tag-xe',
                        'field'    => 'term_id',
                        'terms'    => $tag_id,
                        'operator' => 'IN',
                    ],
                ]
            ];
            
            $products = Toanproduct\product::get_products($data);
        ?>

        <div class="related-post product-single-related">
            <div class="related-post-title text-ultra">Có thể bạn quan tâm</div>
            <div class="swiper-multi slider-product-related slider-ajax">
                <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <?php 
                                while($products->have_posts()): $products->the_post();
                                    $product = new Toanproduct\product([
                                        'id' => get_the_ID(),
                                        'title' => get_the_title(),
                                    ]);
                                    ?>
                                <div class="product-box-item">
                                    <?php include locate_template('template-parts/components/boxs/product-box.php'); ?>
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                </div>
                <?php include locate_template("template-parts/components/paginations/pagination-ajax.php")?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>