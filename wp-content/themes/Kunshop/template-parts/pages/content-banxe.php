<?php
if (have_posts()):
    the_post();
    $highlights_1 = get_field('highlights_1');
    $highlights_2 = get_field('highlights_2');
    $gallery = get_field('gallery');
?>

<section id="selling-page" class="page-layout">
    <div class="wrapper">

        <?php if ($highlights_1['show_on_page'] == true):?>
            <div class="section-1">
                <div class="text-ultra color-primary highlight-title"><?php echo $highlights_1['title']; ?></div>
                <div>
                    <?php 
                        $boxs = $highlights_1['highlight'];
                        include locate_template("template-parts/components/boxs/highlight-box.php"); 
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($highlights_2['show_on_page'] == true):?>
        <div class="section-2">
            <div class="text-ultra color-primary highlight-title"><?php echo $highlights_2['title']; ?></div>
            <div>
                <?php 
                    $boxs = $highlights_2['highlight'];
                    include locate_template("template-parts/components/boxs/highlight-box.php"); 
                ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($gallery['show_on_page'] == true):?>
        <div class="section-3">
            <div class="sec3-metrics">
                <?php foreach($gallery['metrics'] as $metric): ?>
                    <div>
                        <div class="metric-value text-ultra color-primary"><?php echo $metric['value']; ?></div>
                        <div class="metric-key"><?php echo $metric['key']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="sec3-gallery">
                <div class="swiper-material slider-sell">
                    <div class="swiper-wrapper">
                        <?php foreach ($gallery['gallery'] as $image): ?>
                            <div class="swiper-slide">
                                <div class="swiper-material-wrapper">
                                    <div class="swiper-material-content">
                                        <?php echo get_image($image['id'], 'large'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="swiper-button-prev-custom bgrsize100"></div>
                    <div class="swiper-button-next-custom bgrsize100"></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>