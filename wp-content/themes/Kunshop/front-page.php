<?php get_header(); ?>
<?php
if (have_posts()):
    the_post();
    $gallery = get_field('gallery');
    $highlights_heading = get_field('highlights_heading');
    $highlights = [];
    for ($i = 1; $i <= 4; $i++) {
        $highlights[] = get_field('highlights_' . $i);
    }
?>

<section id="home-page" class="page-layout">
    <div class="wrapper">
        <div class="home-banner-section">
            <div class="swiper-material slider-home">
                <div class="swiper-wrapper">
                    <?php foreach ($gallery as $image): ?>
                        <div class="swiper-slide">
                            <div class="swiper-material-wrapper">
                                <div class="swiper-material-content">
                                    <?php echo get_image($image['id'], 'full'); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="swiper-button-prev-custom bgrsize100"></div>
                <div class="swiper-button-next-custom bgrsize100"></div>
            </div>
        </div>

        <div class="product-tab-section">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link shinehover active" id="nav-buy-tab" 
                    data-bs-toggle="tab" data-bs-target="#nav-buy-product" type="button" 
                    role="tab" aria-controls="nav-buy-product" aria-selected="true">Tìm kiếm</button>

                    <button class="nav-link shinehover" id="nav-sell-tab"
                    data-bs-toggle="tab" data-bs-target="#nav-sell-product" type="button" 
                    role="tab" aria-controls="nav-sell-product" aria-selected="false">Liên hệ</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-buy-product"
                role="tabpanel" aria-labelledby="nav-buy-tab">
                    <div>
                        <?php include locate_template("template-parts/components/search-bar.php"); ?>
                        <?php include locate_template("template-parts/components/filters/filter-product-column.php"); ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-sell-product"
                role="tabpanel" aria-labelledby="nav-sell-tab">
                    <div>
                        <?php include locate_template("template-parts/components/forms/form-contact.php"); ?>
                    </div>
                </div>
            </div>
            
        </div>

        <?php 
            $tags = get_terms([
                'taxonomy' => 'product_tag',
                'hide_empty' => true,
            ]);
        ?>
        <?php if (count($tags) > 0): ?>
            <div class="product-highligh-tab-section">
                <h2 class="text-ultra color-primary highlight-title">Khám Phá Sản Phẩm Nổi Bật</h2>
                <div class="product-tab-highlight highligh-tabs">
                    <nav>
                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                            <?php foreach ($tags as $index => $tag): ?>
                                <button 
                                class="nav-link shinehover <?php echo $index == 0 ? 'active' : ''; ?>" id="product-highlights-tab-<?php echo $tag->term_id; ?>" 
                                data-bs-toggle="tab" data-bs-target="#product-highlights-<?php echo $tag->term_id; ?>" 
                                type="button" role="tab" aria-controls="product-highlights-<?php echo $tag->term_id; ?>" 
                                aria-selected="<?php echo $index == 0 ? 'true' : 'false'; ?>"><?php echo $tag->name; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <a class="absoblute d-inline-flex align-items-center shinehover text-semibold color-black" href="<?php echo get_page_link(11); ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <?php foreach ($tags as $index => $tag): ?>
                            <div class="tab-pane fade <?php echo $index == 0 ? 'show active' : ''; ?>" 
                            id="product-highlights-<?php echo $tag->term_id; ?>" 
                            role="tabpanel" aria-labelledby="product-highlights-tab-<?php echo $tag->term_id; ?>">
                            <?php
                                $posts_per_page = 8;

                                $data = [
                                    'posts_per_page' => $posts_per_page,
                                    'paged' => 1,
                                    'post_type' => 'product',
                                    'tax_query' => [
                                        [
                                            'taxonomy' => 'product_tag',
                                            'field'    => 'term_id',
                                            'terms'    => $tag->term_id,
                                        ],
                                    ]
                                ];
                                
                                $products = new WP_Query($data);
                                $number_products = $tag->count;
                                $total_pages = ceil($number_products / $posts_per_page);
                                $idtab = 'product-highlights-' . $tag->term_id;
                                $tag_id = $tag->term_id; 
                            ?>     
                                <div class="slider-product-highlight swiper-tab slider-ajax">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <?php if($products->have_posts()): ?> 
                                                <?php while($products->have_posts()): ?> 
                                                    <?php 
                                                        $products->the_post();
                                                        $code = get_field('code');
                                                        $price = get_field('price');
                                                        $promotional_price = get_field('promotional_price');
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
                                            <?php else: ?>
                                                <div class="title-not-found">Không tìm thấy kết quả nào</div>
                                            <?php endif; ?>
                                        </div> 
                                    </div>
                                    <?php include locate_template("template-parts/components/paginations/pagination-ajax.php")?>
                                    <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="highligh-tab-section">
            <h2 class="text-ultra color-primary highlight-title"><?php echo $highlights_heading; ?></h2>
            <div class="highligh-tabs">
                <nav>
                    <?php
                        $checkActive = false;
                    ?>
                    <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                        <?php foreach ($highlights as $index => $highlight): ?>
                            <?php if ($highlight['show_on_page'] == true): ?>
                                <?php if( $highlight['name'] != '' ): ?>
                                <button 
                                class="nav-link shinehover 
                                <?php 
                                    if ($checkActive == false) {
                                        echo 'active';
                                        $checkActive = true;
                                    }
                                ?>" id="highlights-tab-<?php echo $index; ?>" 
                                data-bs-toggle="tab" data-bs-target="#highlights-<?php echo $index; ?>" 
                                type="button" role="tab" aria-controls="highlights-<?php echo $index; ?>" aria-selected="<?php echo $index == 0 ? 'true' : 'false'; ?>"><?php echo $highlight['name']; ?></button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>   
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <?php
                        $checkActive = false;
                    ?>
                    <?php foreach ($highlights as $index => $highlight): ?>
                        <?php if ($highlight['show_on_page'] == true): ?>
                            <div class="tab-pane fade 
                            <?php
                                if ($checkActive == false) {
                                    echo 'show active';
                                    $checkActive = true;
                                }
                            ?>" 
                            id="highlights-<?php echo $index; ?>" 
                            role="tabpanel" aria-labelledby="highlights-tab-<?php echo $index; ?>">
                                <?php 
                                    $boxs = $highlight['highlight'];
                                    include locate_template("template-parts/components/boxs/highlight-box.php"); 
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>
<?php get_footer(); ?>