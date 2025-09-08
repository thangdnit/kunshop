<div class="highlightboxs">    
    <?php foreach ($boxs as $box): ?>
        <div class="highlightbox">
            <div class="highlightbox__icon">
                <?php echo get_image($box['icon'], 'large') ?>
            </div>
            <div class="highlightbox__content color-white">
                <div class="highlightbox__title text-bold"><?php echo $box['title']; ?></div>
                <div class="highlightbox__description"><?php echo $box['description']; ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
