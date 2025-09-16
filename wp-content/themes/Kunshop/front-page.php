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

        <div class="home-tab-section">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link shinehover active" id="nav-buy-tab" 
                    data-bs-toggle="tab" data-bs-target="#nav-buy-product" type="button" 
                    role="tab" aria-controls="nav-buy-product" aria-selected="true">Khuyến mãi</button>

                    <button class="nav-link shinehover" id="nav-sell-tab"
                    data-bs-toggle="tab" data-bs-target="#nav-sell-product" type="button" 
                    role="tab" aria-controls="nav-sell-product" aria-selected="false">Liên hệ</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-buy-product"
                role="tabpanel" aria-labelledby="nav-buy-tab">
                    <div>
                        <?php include locate_template("template-parts/components/product-promotion.php"); ?>
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
            $categories_hl = get_terms([
                'taxonomy' => 'product_category',
                'hide_empty' => true,
                'parent' => 0,
                'number' => 5
            ]);
        ?>
        <?php if (count($categories_hl) > 0): ?>
            <div class="product-highligh-tab-section">
                <h2 class="text-ultra color-primary highlight-title">Sản Phẩm Nổi Bật</h2>
                <div class="product-tab-highlight highligh-tabs">
                    <nav>
                        <div class="nav nav-tabs justify-content-center <?php if (count($categories_hl) > 2) echo 'overflow-auto'; ?>" id="nav-tab" role="tablist">
                            <?php foreach ($categories_hl as $index => $category): ?>
                                <button 
                                class="nav-link shinehover <?php echo $index == 0 ? 'active' : ''; ?>" id="product-highlights-tab-<?php echo $category->term_id; ?>" 
                                data-bs-toggle="tab" data-bs-target="#product-highlights-<?php echo $category->term_id; ?>" 
                                type="button" role="tab" aria-controls="product-highlights-<?php echo $category->term_id; ?>" 
                                aria-selected="<?php echo $index == 0 ? 'true' : 'false'; ?>"><?php echo $category->name; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <a class="absoblute d-inline-flex align-items-center shinehover text-semibold color-black" href="<?php echo get_page_link(11); ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <?php foreach ($categories_hl as $index => $category): ?>
                            <div class="tab-pane fade <?php echo $index == 0 ? 'show active' : ''; ?>" 
                            id="product-highlights-<?php echo $category->term_id; ?>" 
                            role="tabpanel" aria-labelledby="product-highlights-tab-<?php echo $category->term_id; ?>">
                            <?php
                                $posts_per_page = 4;

                                $data = [
                                    'posts_per_page' => $posts_per_page,
                                    'paged' => 1,
                                    'post_type' => 'product',
                                    'tax_query' => [
                                        [
                                            'taxonomy' => 'product_category',
                                            'field'    => 'term_id',
                                            'terms'    => $category->term_id,
                                        ],
                                    ]
                                ];
                                
                                $products = new WP_Query($data);
                                $number_products = $category->count;
                                $total_pages = ceil($number_products / $posts_per_page);
                                $idtab = 'product-highlights-' . $category->term_id;
                                $category_id = $category->term_id; 
                            ?>     
                                <div class="slider-product-highlight swiper-tab slider-ajax <?php echo $idtab; ?>">
                                    <?php include locate_template("template-parts/components/paginations/pagination-ajax.php")?>
                                    <div class="swiper-wrapper">
                                        <?php if($products->have_posts()): ?>
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
                        $countShow = 0;
                        foreach ($highlights as $highlight) {
                            if ($highlight['show_on_page'] == true && $highlight['name'] != '') {
                                $countShow++;
                            }
                        }
                    ?>
                    <div class="nav nav-tabs justify-content-center <?php if ($countShow > 2) echo 'overflow-auto'; ?>" id="nav-tab" role="tablist">
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
<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>