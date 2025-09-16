<?php $price_filter = get_field('price_filter', 'option'); ?>
<div class="product-filter">
    <div class="select-custom">
        <select id="product-filter__category" class="form-select" name="product_category">
            <option value="0" selected>Chọn danh mục</option>
            <option value="category-1">Danh mục 1</option>
            <option value="category-2">Danh mục 2</option>
            <option value="category-3">Danh mục 3</option>
            <option value="category-4">Danh mục 4</option>
            <option value="category-5">Danh mục 5</option>
            <option value="category-6">Danh mục 6</option>
        </select>
    </div>
    <div class="select-custom">
        <select id="product-filter__brand" class="form-select" name="product-filter__brand">
            <option value="0" selected>Chọn thương hiệu</option>
            <option value="brand-1">Thương hiệu 1</option>
            <option value="brand-2">Thương hiệu 2</option>
            <option value="brand-3">Thương hiệu 3</option>
            <option value="brand-4">Thương hiệu 4</option>
            <option value="brand-5">Thương hiệu 5</option>
            <option value="brand-6">Thương hiệu 6</option>
        </select>
    </div>
    <div class="range-custom">
        <div id="product-filter__price-range" class="slider-styled"
        data-min="<?php echo $price_filter['min'] ?>" 
        data-max="<?php echo $price_filter['max'] ?>"></div>
    </div>
    <div class="filter-choosen">
        <div class="filter-choosen-list">
            <span class="color-primary text-bold">Chăm sóc da</span>
            <span class="color-primary text-bold">Trang điểm</span>
            <span class="color-primary text-bold">Nước hoa</span>
            <span class="color-primary text-bold">Dưỡng thể</span>
            <span class="color-primary text-bold">Dưỡng ẩm</span>
        </div>
    </div>
    <button class="custom-button">Áp dụng</button>
    <button class="custom-button">Đặt lại</button>
</div>