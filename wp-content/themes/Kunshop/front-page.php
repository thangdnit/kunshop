<?php get_header(); ?>
<?php
if (have_posts()):
    the_post();
    $gallery = get_field('gallery');
    $highlights_heading = get_field('highlights_heading');
    $highlights = [];
    for ($i = 1; $i <= 2; $i++) {
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
            <h1 class="text-ultra color-primary">KUNKUN SHOP</h1>
        </div>

        <div class="home-tab-section">
            <?php include locate_template("template-parts/components/product-promotion.php"); ?>
        </div>

        <?php
            $category_name = 'product_category';
            $color_title = 'color-primary'; 
            $title_tab = 'Sản phẩm nổi bật';
            $categories_hl = get_terms([
                'taxonomy' => $category_name,
                'hide_empty' => true,
                'parent' => 0,
                'number' => 5
            ]);
        ?>
        <?php if (count($categories_hl) > 0): ?>
            <?php include locate_template("template-parts/components/product-category-tab.php"); ?>
        <?php endif; ?>

        <?php 
            $category_name = 'product_brand';
            $title_tab = 'Thương hiệu nổi bật'; 
            $color_title = 'color-logo';
            $categories_hl = get_terms([
                'taxonomy' => $category_name,
                'hide_empty' => true,
                'parent' => 0,
                'number' => 5
            ]);
        ?>
        <?php if (count($categories_hl) > 0): ?>
            <?php include locate_template("template-parts/components/product-category-tab.php"); ?>
        <?php endif; ?>


        <div class="highligh-tab-section">
            <div class="product-highlight-title">
                <h2 class="text-ultra color-primary highlight-title"><?php echo $highlights_heading; ?></h2>
            </div>
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
<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>