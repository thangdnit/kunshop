<?php
    $price_filter_advanced = get_field('price_filter_advanced', 'option');
?>

<div class="product-filter-advanced" id="product-filter-advanced">
    <?php foreach ($taxonomys as $taxonomy): ?>
        <?php
            if ($taxonomy['class'] == 'tag-xe' || $taxonomy['class'] == 'loai-xe' || $taxonomy['class'] == 'hang-xe') {
                continue;
            }
        ?>
        <div class="product-filter__<?php echo $taxonomy['class']; ?> product-filter">
            <select name="product-filter__<?php echo $taxonomy['class']; ?>" id="product-filter__<?php echo $taxonomy['class']; ?>" onchange="updateLocalStorageSelect('product-filter__<?php echo $taxonomy['class']; ?>')">
                <option value="0"><?php echo $taxonomy['label'] ?></option>
                <?php foreach($taxonomy['terms'] as $term): ?>
                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endforeach; ?>
    <div class="product-filter__price-range product-filter">
        <div id="product-filter__price-range" data-min="<?php echo $price_filter_advanced['min'] ?>" data-max="<?php echo $price_filter_advanced['max'] ?>"></div>
        <div class="clear-filter-btn">
            <button onclick="clearAllfilter()" class="shinehover custom-button">
                <div>Clear Filter</div>
            </button>
        </div>
    </div>
</div>