<?php
if (have_posts()):
    the_post();
    $introduction = get_field('introduction');
    $gallery = get_field('gallery');
    $highlights = get_field('highlights');
    $sales_policy = get_field('sales_policy');
?>

<section id="intro-page" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <div class="intro-page__content sec1">
            <h1 class="text-ultra color-primary"><?php echo $introduction['title']; ?></h1>
            <div><?php echo $introduction['description']; ?></div>
        </div>

        <?php if ($gallery['show_on_page'] == true ): ?>
            <div class="intro-page__content sec2">
                <div class="grid-gallery">
                    <div>
                        <div class="bgcolor-primary">
                            <div class="color-white text-ultra"><?php echo $gallery['customer']; ?> </div>
                            <div class="color-white text-semibold">Khách hàng tin tưởng</div>
                        </div>
                        <div><?php echo get_image($gallery['image_1'], 'large'); ?></div>
                    </div>
                    <div>
                        <?php echo get_image($gallery['image_2'], 'large'); ?>
                    </div>
                    <div>
                        <div><?php echo get_image($gallery['image_3'], 'large'); ?></div>
                        <div>
                            <div><?php echo get_image($gallery['image_4'], 'large'); ?></div>
                            <div><?php echo get_image($gallery['image_5'], 'large'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="story">
                    <?php foreach($gallery['story'] as $item): ?>
                        <div> 
                            <div class="text-ultra color-primary"><?php echo $item['title']; ?></div>
                            <div><?php echo $item['description']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($highlights['show_on_page'] == true ): ?>
            <div class="intro-page__content sec3">
                <div class="text-ultra color-primary"><?php echo $highlights['title']; ?></div>
                <div>
                    <?php 
                        $boxs = $highlights['highlight'];
                        include locate_template("template-parts/components/boxs/highlight-box.php"); 
                    ?>
                </div>
                <div class="metrics">
                    <?php foreach($highlights['metrics'] as $metric ): ?>
                        <div class="metric">
                            <div class="metric-value text-ultra color-primary"><?php echo $metric['value'] ?></div>
                            <div class="metric-key"><?php echo $metric['key'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($sales_policy['show_on_page'] == true): ?>
            <div class="intro-page__content sec4">
                <div class="text-ultra color-primary"><?php echo $sales_policy['title']; ?></div>
                <div class="policy">
                    <div class="policy-image">
                        <?php echo get_image($sales_policy['image'], 'full') ;?>
                    </div>
                    <div class="policy-content">
                        <?php foreach ($sales_policy['policy'] as $policy): ?>
                            <div>
                                <div class="color-primary text-bold"><?php echo $policy['title']; ?></div>
                                <div><?php echo $policy['description']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php include locate_template("template-parts/components/boxs/contact-boxs.php"); ?>
    </div>
</section>

<?php endif; ?>