<?php
    $price_filter = get_field('price_filter', 'option');
?>
<div class="product-filter-column">
    <h2 class="title-page">Bộ lọc</h2>
    <div class="product-filter-column-content">
        <div class="clear-filter-btn">
            <button onclick="clearAllfilter()" class="shinehover custom-button">
                <div>Xoá tìm kiếm</div>
            </button>
        </div>
        <div class="product-taxonomy-title">Danh mục</div>
        <?php
            render_category_checkboxes(0, 'product_category', []);
        ?>
        <div class="line-separate"></div>
        <div class="product-taxonomy-title">Sản phẩm</div>
        <?php
            render_category_checkboxes(0, 'product_tag', []);
        ?>
        <div class="line-separate"></div>
        <div class="product-taxonomy-title">Nhãn hiệu</div>
        <?php
            render_category_checkboxes(0, 'product_brand', []);
        ?>
        <div class="product-filter__price-range product-filter">
            <div id="product-filter__price-range" data-min="<?php echo $price_filter['min'] ?>" data-max="<?php echo $price_filter['max'] ?>"></div>
        </div>
        <div class="product-filter-btn">
            <button onclick="loadproductFilterMain()" class="shinehover custom-button">
                <div class="search-icon bgrsize100"></div>
                <div>Tìm kiếm</div>
            </button>
        </div>
    </div>
</div>