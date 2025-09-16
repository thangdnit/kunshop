<section id="buying-page" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <div class="product-list-header">
            <h1 class="title-page mobile color-primary text-ultra position-relative"><?php the_title(); ?><div class="loading-spinner"></div></h1>
            <?php include locate_template('template-parts/components/filters/option-product.php'); ?>
        </div>
        <?php include locate_template('template-parts/components/filters/filter-product.php'); ?>
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