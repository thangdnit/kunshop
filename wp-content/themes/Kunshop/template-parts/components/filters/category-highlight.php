<div class="category-highlight">
    <?php
        $categories = get_categories(array(
            'taxonomy' => $name_category,
            'hide_empty' => true,
            'parent' => 0,
            'limit' => $limit,
        ));
    ?>
    <?php if (!empty($categories) && !is_wp_error($categories)): ?>
        <div class="category-highlight-list category-highlight-list-<?php echo $name_category; ?>">
            <?php foreach ($categories as $category): ?>
                <button class="custom-button" data-value="<?php echo esc_attr($category->term_id); ?>"><?php echo esc_html($category->name); ?></button>
            <?php endforeach; ?>
            <?php if ($name_category === 'product_brand'): ?>
                <button class="custom-button" data-value="promotion">Khuyến mãi</button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>