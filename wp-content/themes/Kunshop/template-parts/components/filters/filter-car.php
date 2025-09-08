<div>
    <?php
        $array = [
            ['slug' => 'loai-xe', 'limit' => 5, 'class' => 'type'], 
            ['slug' => 'hang-xe', 'limit' => 9, 'class' => 'brand'] ];

        $taxonomy_all = [];
        foreach ($array as $item) {
            $term = [
                'taxonomy' => $item['slug'],
                'number' => $item['limit'],
                'hide_empty' => false,
            ];

            if ($item['slug'] === 'hang-xe') {
                $term['parent'] = 0;
            }
            
            $taxonomy_all[] = [
                'terms' => get_terms($term),
                'class' => $item['class'],
                'name' => get_taxonomy($item['slug'])->name
            ];
        }
        $price_filter_advanced = get_field('price_filter_advanced', 'option');
    ?>
    
    <?php foreach ($taxonomy_all as $taxonomy): ?>
        <?php $class =  $taxonomy['class'];?>
        <div class="car-<?php echo $class; ?>-section">
            <div class="car-taxonomy-section <?php if($taxonomy['class'] == 'type') echo 'swiper-wrapper' ?>" >
                <?php foreach($taxonomy['terms'] as $term): ?>
                    <?php $image = get_field('image', 'term_' . $term->term_id); ?>
                    <div class="swiper-slide">
                        <a class="<?php echo $class != 'type' ? 'image-hover-effect': '' ?> shinehover" 
                        onclick="searchCarbyTaxonomy('<?php echo get_page_link(14); ?>', '<?php echo $taxonomy['name']; ?>' , '<?php echo $term->term_id; ?>')">
                            <?php echo get_image($image, 'large'); ?>
                            <div class="car-<?php echo $class; ?>-name"><?php echo $term->name; ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if ($taxonomy) ?>
    <?php endforeach; ?>

    <?php
        $price_list_filter = get_field('price_list_filter', 'option');
    ?>
    <div class="price-filter-section">
        <?php foreach ($price_list_filter as $price): ?>
            <a id="price-filter__<?php echo $price['min'] . '-' . $price['max_price'] ?>" 
            onclick="searchCarbyPrice('<?php echo get_page_link(14); ?>', '<?php echo $price['min']; ?>' , '<?php echo $price['max_price']; ?>')" 
            class="shinehover price-filter text-semibold" price-min="<?php echo $price['min']; ?>" price-max="<?php echo $price['max_price']; ?>">
                <?php echo $price['label']; ?>
            </a>
        <?php endforeach; ?>
        <a id="price-filter__<?php echo $price_filter_advanced['min'] . '-' . $price_filter_advanced['max']; ?>" 
        onclick="searchCarbyPrice('<?php echo get_page_link(14); ?>', '<?php echo $price_filter_advanced['min']; ?>' , '<?php echo $price_filter_advanced['max']; ?>')" 
        class="shinehover price-filter text-semibold">Xem tất cả</a>
    </div>
</div>