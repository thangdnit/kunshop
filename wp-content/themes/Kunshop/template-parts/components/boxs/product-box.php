<div class="product-box">
    <div class="product-box__image">
        <a class="shinehover" href="<?php echo $link; ?>"><?php echo get_image($image, 'medium_large'); ?></a>
    </div>
    
    <div class="product-box__content">
        <div class="product-box__name">
            <h3 class="text-bold color-primary"><a class="shinehover" href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
            <div class="product-box__description"><?php echo $description; ?></div>
        </div>
        <div class="product_box__price <?php echo $promotion ? 'flash-sale' : ''; ?>">
            <div class="new-price">
                <?php echo format_price($price); ?>
                <?php if ($promotion): ?>
                    <div class="old-price"><?php echo format_price($old_price); ?></div>
                <?php endif; ?>
            </div>
            <div class="text-semibold color-black"><a class="go-product-page shinehover text-semibold" href="<?php echo $link; ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a></div>
        </div>
    </div>
</div>