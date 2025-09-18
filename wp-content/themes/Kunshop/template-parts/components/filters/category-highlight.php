<div class="category-highlight">
    <?php
        $categories = get_categories(array(
            'taxonomy' => 'product_category',
            'hide_empty' => true,
            'parent' => 0,
            'limit' => 5,
        ));
    ?>
    <?php if (!empty($categories) && !is_wp_error($categories)): ?>
        <div class="category-highlight-list">
            <?php foreach ($categories as $category): ?>
                <button class="custom-button" data-value="<?php echo esc_attr($category->term_id); ?>"><?php echo esc_html($category->name); ?></button>
            <?php endforeach; ?>
            <button class="custom-button" data-value="promotion">Khuyến mãi</button>
        </div>
    <?php endif; ?>
</div>