<?php
    $price_filter_advanced = get_field('price_filter_advanced', 'option');
?>

<div class="car-filter-advanced" id="car-filter-advanced">
    <?php foreach ($taxonomys as $taxonomy): ?>
        <?php
            if ($taxonomy['class'] == 'tag-xe' || $taxonomy['class'] == 'loai-xe' || $taxonomy['class'] == 'hang-xe') {
                continue;
            }
        ?>
        <div class="car-filter__<?php echo $taxonomy['class']; ?> car-filter">
            <select name="car-filter__<?php echo $taxonomy['class']; ?>" id="car-filter__<?php echo $taxonomy['class']; ?>" onchange="updateLocalStorageSelect('car-filter__<?php echo $taxonomy['class']; ?>')">
                <option value="0"><?php echo $taxonomy['label'] ?></option>
                <?php foreach($taxonomy['terms'] as $term): ?>
                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endforeach; ?>
    <div class="car-filter__price-range car-filter">
        <div id="car-filter__price-range" data-min="<?php echo $price_filter_advanced['min'] ?>" data-max="<?php echo $price_filter_advanced['max'] ?>"></div>
        <div class="clear-filter-btn">
            <button onclick="clearAllfilter()" class="shinehover custom-button">
                <div class="padding-text">Clear Filter</div>
            </button>
        </div>
    </div>
</div>