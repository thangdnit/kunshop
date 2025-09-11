<div class="custom-pagination">
    <div class="loading-spinner"></div>
    <a id="btn-prev<?php echo $idtab ?>" class="prev-icon bgrsize100 shinehover disabled-custom"></a>
    <a id="btn-next<?php echo $idtab ?>" class="next-icon bgrsize100 shinehover <?php echo $total_pages <= 1 ? 'disabled-custom' : '' ?>"></a>    
</div>
<form id="pagination-form<?php echo $idtab ?>" style="display: none;">
    <input type="hidden" id="next_page<?php echo $idtab ?>" name="next_page<?php echo $idtab ?>" value="2">
    <input type="hidden" id="page_loaded<?php echo $idtab ?>" name="page_loaded<?php echo $idtab ?>" value="1">
    <input type="hidden" id="posts_per_page<?php echo $idtab ?>" name="posts_per_page<?php echo $idtab ?>" value="<?php echo $posts_per_page; ?>">
    <input type="hidden" id="total_pages<?php echo $idtab ?>" name="total_pages<?php echo $idtab ?>" value="<?php echo $total_pages; ?>">
    <input type="hidden" id="first_load<?php echo $idtab ?>" name="first_load<?php echo $idtab ?>" value="0">
    <input type="hidden" id="category_id<?php echo $idtab ?>" name="category_id<?php echo $idtab ?>" value="<?php echo $category_id; ?>">
</form>