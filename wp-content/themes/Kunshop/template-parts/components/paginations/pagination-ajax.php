<div class="custom-pagination">
    <div class="loading-spinner"></div>
    <div class="swiper-button-prev-custom bgrsize100"></div>
    <div class="swiper-button-next-custom bgrsize100"></div>
</div>
<?php if ($idtab != 'promotion'): ?>
    <form id="pagination-form<?php echo $idtab ?>" style="display: none;">
        <input type="hidden" id="page_loaded<?php echo $idtab ?>" name="page_loaded<?php echo $idtab ?>" value="1">
        <input type="hidden" id="posts_per_page<?php echo $idtab ?>" name="posts_per_page<?php echo $idtab ?>" value="<?php echo $posts_per_page; ?>">
        <input type="hidden" id="total_pages<?php echo $idtab ?>" name="total_pages<?php echo $idtab ?>" value="<?php echo $total_pages; ?>">
        <input type="hidden" id="category_id<?php echo $idtab ?>" name="category_id<?php echo $idtab ?>" value="<?php echo $category_id; ?>">
    </form>
<?php endif; ?>