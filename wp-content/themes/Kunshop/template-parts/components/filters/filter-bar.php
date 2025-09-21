<div class="filter-bar">
    <span onclick="toggleFilter()" class="filter-icon bgrsize100 image-hover-effect"></span>
    <div class="options-div">
        <div class="select-custom">
            <label for="sort-by" class="color-primary text-bold">Sắp xếp</label>
            <select id="sort-by" class="form-select" name="sort-by">
                <option value="date-DESC" selected>Mới nhất</option>
                <option value="date-ASC">Cũ nhất</option>
                <option value="price-ASC">Giá thấp đến cao</option>
                <option value="price-DESC">Giá cao đến thấp</option>
            </select>
        </div>
        <div class="select-custom">
            <label for="products-per-page" class="color-primary text-bold">Hiển thị</label>
            <select id="products-per-page" class="form-select" name="products-per-page">
                <option value="8" selected>8</option>
                <option value="12">12</option>
                <option value="24">24</option>
                <option value="48">48</option>
            </select>
        </div>
    </div>
    <button onclick="clearAllfilter()" class="custom-button filter-reset shinehover image-hover-effect">Xoá tất cả</button>
    <div class="filter-choosen">
        <div class="product-filter__keyword color-primary">Từ khoá tìm kiếm: &nbsp;<span onclick="clearKeyword()" class="color-yellow"></span></div>
        <div id="filter-choosen__product_category">
            <div class="filter-choosen__list">
            </div>
        </div>
        <div id="filter-choosen__product_brand">
            <div class="filter-choosen__list">
            </div>
        </div>
    </div>
</div>