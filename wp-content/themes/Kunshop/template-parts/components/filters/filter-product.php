<?php $price_filter = get_field('price_filter', 'option'); ?>
<div class="product-filter">
    <div class="select-dropdown">
        <button onclick="toggleExpend('#filter-category-expend', 'show-expend')" class="custom-button shinehover">Chọn danh mục</button>
        <div id="filter-category-expend" class="select-dropdown-list">
            <?php render_category_checkboxes(0, 'product_category'); ?>
        </div>
    </div>
    <div class="select-dropdown">
        <button onclick="toggleExpend('#filter-brand-expend', 'show-expend')" class="custom-button shinehover">Chọn thương hiệu</button>
        <div id="filter-brand-expend" class="select-dropdown-list">
            <?php render_category_checkboxes(0, 'product_brand'); ?>
        </div>
    </div>
    <div class="range-custom">
        <div id="product-filter__price-range" class="slider-styled"
        data-min="<?php echo $price_filter['min'] ?>" 
        data-max="<?php echo $price_filter['max'] ?>"></div>
    </div>
    <div class="options-div">
        <div class="select-custom">
            <label for="sort-by" class="color-primary text-bold">Sắp xếp</label>
            <select id="sort-by" class="form-select" name="sort-by">
                <option value="0" selected>Mặc định</option>
                <option value="price-asc">Giá thấp đến cao</option>
                <option value="price-desc">Giá cao đến thấp</option>
            </select>
        </div>
        <div class="select-custom">
            <label for="products-per-page" class="color-primary text-bold">Hiển thị</label>
            <select id="products-per-page" class="form-select" name="products-per-page" >
                <option value="8" selected>8</option>
                <option value="12">12</option>
                <option value="24">24</option>
                <option value="48">48</option>
            </select>
        </div>
    </div>
    <button onclick="loadproductFilterMain()" class="custom-button filter-apply shinehover image-hover-effect">Áp dụng</button>
    <button onclick="clearAllfilter()" class="custom-button filter-reset shinehover image-hover-effect">Đặt lại</button>
</div>