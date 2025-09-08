<?php
if (have_posts()):
    the_post();
    $heading_1 = get_field('heading_1');
    $heading_2 = get_field('heading_2');
    $gallery = get_field('gallery');
    $highlights_heading = get_field('highlights_heading');
    $reviews = get_field('reviews');
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
                <div class="title-banner">
                    <div class="text-bold"><?php echo $heading_1; ?></div>
                    <h1 class="text-ultra"><?php echo $heading_2; ?></h1>
                </div>
            </div>
        </div>

        <div class="car-tab-section">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link shinehover active" id="nav-buy-tab" 
                    data-bs-toggle="tab" data-bs-target="#nav-buy-car" type="button" 
                    role="tab" aria-controls="nav-buy-car" aria-selected="true">Mua xe</button>

                    <button class="nav-link shinehover" id="nav-sell-tab"
                    data-bs-toggle="tab" data-bs-target="#nav-sell-car" type="button" 
                    role="tab" aria-controls="nav-sell-car" aria-selected="false">Bán xe</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-buy-car"
                role="tabpanel" aria-labelledby="nav-buy-tab">
                    <div>
                        <?php include locate_template("template-parts/components/search-bar.php"); ?>
                    </div>
                    <div>
                        <div class="car-tab-title">
                            <div class="text-bold color-primary buy-tab_title">Kiểu Dáng / Hãng Xe phổ biến</div>
                            <a class="d-inline-flex align-items-center shinehover text-semibold" href="<?php echo get_page_link(14); ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a>
                        </div>
                        <?php include locate_template("template-parts/components/filters/filter-car.php"); ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-sell-car"
                role="tabpanel" aria-labelledby="nav-sell-tab">
                    <div>
                        <?php include locate_template("template-parts/components/forms/form-sellcar.php"); ?>
                    </div>
                </div>
            </div>
            
        </div>

        <?php
            $tags = ToanCar\Car::get_term_taxonomy('tag-xe', 3);
        ?>
        
        <?php if (count($tags) > 0): ?>
            <div class="car-highligh-tab-section">
                <h2 class="text-ultra color-primary highlight-title">Khám Phá Xe Nổi Bật</h2>
                <div class="car-tab-highlight highligh-tabs">
                    <nav>
                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                            <?php foreach ($tags as $index => $tag): ?>
                                <button 
                                class="nav-link shinehover <?php echo $index == 0 ? 'active' : ''; ?>" id="car-highlights-tab-<?php echo $tag->term_id; ?>" 
                                data-bs-toggle="tab" data-bs-target="#car-highlights-<?php echo $tag->term_id; ?>" 
                                type="button" role="tab" aria-controls="car-highlights-<?php echo $tag->term_id; ?>" 
                                aria-selected="<?php echo $index == 0 ? 'true' : 'false'; ?>"><?php echo $tag->name; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <a class="absoblute d-inline-flex align-items-center shinehover text-semibold" href="<?php echo get_page_link(14); ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <?php foreach ($tags as $index => $tag): ?>
                            <div class="tab-pane fade <?php echo $index == 0 ? 'show active' : ''; ?>" 
                            id="car-highlights-<?php echo $tag->term_id; ?>" 
                            role="tabpanel" aria-labelledby="car-highlights-tab-<?php echo $tag->term_id; ?>">
                            <?php
                                $widthValue = intval(get_option('widthValue'));
                                $posts_per_page = $widthValue < 801 ? 2 : get_field('cars_per_page_home', 'option');
                                
                                $data = [
                                    'posts_per_page' => $posts_per_page,
                                    'paged' => 1,
                                    'tax_query' => [
                                        [
                                            'taxonomy' => 'tag-xe',
                                            'field'    => 'term_id',
                                            'terms'    => $tag->term_id,
                                        ],
                                    ]
                                ];
                                
                                $cars = ToanCar\Car::get_cars($data);
                                $number_cars = $tag->count;
                                $total_pages = ceil($number_cars / $posts_per_page);
                                $idtab = 'car-highlights-' . $tag->term_id;
                                $tag_id = $tag->term_id; 
                            ?>     
                                <div class="slider-car-highlight swiper-tab slider-ajax">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <?php while($cars->have_posts()): $cars->the_post(); ?>
                                                <?php
                                                    $car = new ToanCar\Car([
                                                        'id' => get_the_ID(),
                                                        'title' => get_the_title(),
                                                    ]);
                                                ?>
                                                <div class="car-box-item">
                                                    <?php include locate_template('template-parts/components/boxs/car-box.php'); ?>
                                                </div>
                                            <?php endwhile; ?>
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

        <?php if ($reviews['show_on_page'] == true): ?>
            <div class="review-section">
                <div class="<?php echo count($reviews['review']) > 1 ? 'swiper-normal' : ''; ?> slider-review">
                    <div class="<?php echo count($reviews['review']) > 1 ? 'swiper-wrapper' : ''; ?>">
                        <?php foreach ($reviews['review'] as $review): ?>
                            <div class="<?php echo count($reviews['review']) > 1 ? 'swiper-slide' : ''; ?> review-slide">
                                <div class="review-item">
                                    <div class="reviewer-image">
                                        <?php echo get_image($review['image'], 'large'); ?>
                                    </div>
                                    <div class="reviewer-content">
                                        <div class="rating-star">
                                                <?php set_query_var('star', $review['star']); ?>
                                                <?php get_template_part("template-parts/components/star"); ?>
                                        </div>
                                        <div class="reviewer-name"><?php echo $review['reviewer_name']; ?></div>
                                        <div class="review"><?php echo $review['review']; ?></div>
                                        <div><?php echo $review['address']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="swiper-button-prev-custom bgrsize100"></div>
                    <div class="swiper-button-next-custom bgrsize100"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php endif; ?>