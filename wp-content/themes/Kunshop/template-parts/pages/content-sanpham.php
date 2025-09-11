<section id="buying-page" class="page-layout">
    <div class="wrapper">
        <div class="product-filter-column-div">
            <?php include locate_template("template-parts/components/filters/filter-product-column.php"); ?>
        </div>
        <div class="product-list-column-div">
            <h1 class="title-page mobile color-primary text-ultra position-relative"><?php the_title(); ?><div class="keyword-ajax"></div><div class="loading-spinner"></div></h1>
            <div class="product-list-section">
                <div>
                    <div class="product-list-wrapper" id="product-list-ajax">

                    </div>
                    <div id="pagination-ajax">
                        <?php include locate_template("template-parts/components/paginations/pagination-ajax-filter.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>