<div class="product-filter-section">
    <?php
        $category_1 = get_terms('category', array('hide_empty' => 0, 'parent' => 0));
    ?>
    <div class="product-filter-all">
        <div class="product-filter__category product-filter">
            <select name="product-filter__category_lv1" id="product-filter__category_lv1" onchange="load_category_lv1()">
                <option value="0">Tất cả</option>
                <?php foreach($category_1 as $term): ?>
                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="product-filter__category product-filter">
            <select name="product-filter__category_lv2" id="product-filter__category_lv2" onchange="load_category_lv2()">
                <option value="0"></option>
            </select>
        </div>

        <div class="product-filter__category product-filter">
            <select name="product-filter__category_lv3" id="product-filter__category_lv3" onchange="load_category_lv3()">
                <option value="0"></option>
            </select>
        </div>
        

        <?php include locate_template("template-parts/components/filters/filter-product-advanced.php") ?>
        
        <div>
            <button class="shinehover btn-advanced-filter" onclick="showAdvancedFilter()">
                <div class="filter-icon bgrsize100"></div> 
                <div>Bộ Lọc</div>
            </button>
        </div>
        
        <div class="product-filter-btn">
            <button onclick="loadproductFilterMain()" class="shinehover custom-button">
                <div class="search-icon bgrsize100"></div>
                <div>Tìm kiếm</div>
            </button>
        </div>
    </div>
</div>