<?php 
    $page = new WP_Query([ 'post_type' => 'page', 'page_id' => 11]);
    if($page->have_posts()): while($page->have_posts()): $page->the_post();
?>
<section id="buying-page" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <div class="product-list-header">
            <h1 class="title-page mobile color-primary text-ultra position-relative"><?php the_title(); ?>
                <div class="loading-spinner"></div>
            </h1>
            <?php 
                $name_category = 'product_brand';
                $limit = 3;
                include locate_template('template-parts/components/filters/category-highlight.php'); 
            ?>
        </div>
        <div class="category-highlight-div">
            <?php 
                $name_category = 'product_category';
                $limit = 7;
                include locate_template('template-parts/components/filters/category-highlight.php'); 
            ?>
        </div>
        <?php include locate_template('template-parts/components/filters/filter-bar.php'); ?>
        <div class="product-list-column-div">
            <div class="product-list-section">
                <div>
                    <div class="product-list-wrapper" id="product-list-ajax">

                    </div>
                    <div id="pagination-ajax">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include locate_template('template-parts/components/filters/filter-product-advanced.php'); ?>
<?php 
    endwhile; wp_reset_postdata(); endif;
?>