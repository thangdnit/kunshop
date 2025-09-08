<div class="product-box">
    <div class="product-box__image">
        <a class="shinehover" href="<?php echo $link; ?>"><?php echo get_image($image, 'medium_large'); ?></a>
        <div class="product-box__tag">
            <?php if ($product_tag) : ?>
                <?php foreach ($product_tag as $tag) : ?>
                    <div class="product-box__tag-item"><?php echo esc_html($tag->name); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="product-box__content">
        <div class="product-box__name">
            <h3 class="text-ultra color-primary"><a class="shinehover" href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
            <div class="product-box__description"><?php echo $description; ?></div>
        </div>
        <div class="product_box__price">
            <div class="text-bold color-primary"><?php echo format_price($price); ?></div>
            <div class="text-semibold color-primary"><a class="d-inline-flex align-items-center shinehover text-semibold" href="<?php echo $link; ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a></div>
        </div>
    </div>
</div>