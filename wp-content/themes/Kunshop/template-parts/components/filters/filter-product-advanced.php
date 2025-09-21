<?php $price_filter = get_field('price_filter', 'option'); ?>
<?php global $placeholder_texts; ?>
<section class="filter-total-div" id="filter-total-id">
    <div onclick="toggleFilter()" class="filter-overlay"></div>
    <div class="filter-total-wrapper">
        <div class="filter-total-header">
            <h2 class="color-primary text-bold">Bộ lọc</h2>
            <span onclick="toggleFilter()" class="close-icon bgrsize100 image-hover-effect"></span>
        </div>
        <div class="filter-total-content">
            <div class="filter-section_promotion filter-section">
                <div class="filter-section__content">
                    <ul class="category-list product_category-list">
                        <li>
                            <button data-name="Khuyến mãi" name-class="promotion" data-value="promotion" class="custom-button-2 product-filter__promotion"> 
                            Khuyến mãi
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="filter-section__product_category filter-section">
                <h3 class="filter-section__title">Danh mục sản phẩm</h3>
                <div class="filter-section__content">
                    <?php render_category_checkboxes(0, 'product_category'); ?>
                </div>
            </div>
            <div class="filter-section__product_brand filter-section">
                <h3 class="filter-section__title">Thương hiệu</h3>
                <div class="filter-section__content">
                    <?php render_category_checkboxes(0, 'product_brand'); ?>
                </div>
            </div>
            <div class="filter-section__price">
                <h3 class="filter-section__title">Khoảng giá</h3>
                <div id="product-filter__price-range"
                data-min="<?php echo $price_filter['min'] ?>" 
                data-max="<?php echo $price_filter['max'] ?>"></div>
            </div>
        </div>
        <div class="filter-total-footer">
            <button onclick="loadproductFilterMain()" class="custom-button filter-apply shinehover image-hover-effect">Áp dụng</button>
            <button onclick="clearAllfilter()" class="custom-button filter-reset shinehover image-hover-effect">Xoá tất cả</button>
        </div>
    </div>
</section>