<div class="product-highligh-tab-section">
    <div class="product-highlight-title">
        <h2 class="text-ultra highlight-title <?php echo $color_title; ?>"><?php echo $title_tab; ?></h2>
        <a class="go-product-page shinehover text-semibold color-black" href="<?php echo get_page_link(11); ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a>
    </div>
    <div class="product-tab-highlight highligh-tabs">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <?php foreach ($categories_hl as $index => $category): ?>
                    <button 
                    class="nav-link shinehover <?php echo $index == 0 ? 'active' : ''; ?>" id="product-highlights-tab-<?php echo $category->term_id; ?>" 
                    data-bs-toggle="tab" data-bs-target="#product-highlights-<?php echo $category->term_id; ?>" 
                    type="button" role="tab" aria-controls="product-highlights-<?php echo $category->term_id; ?>" 
                    aria-selected="<?php echo $index == 0 ? 'true' : 'false'; ?>"><?php echo $category->name; ?></button>
                <?php endforeach; ?>
            </div>
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
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'ignore_custom_sort' => true,
                        'suppress_filters' => true,
                        'tax_query' => [
                            [
                                'taxonomy' => $category_name,
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