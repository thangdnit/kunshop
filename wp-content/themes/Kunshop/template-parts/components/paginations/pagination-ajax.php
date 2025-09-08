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
    <?php if ($idtab != ''): ?>
        <input type="hidden" id="tag_id<?php echo $idtab ?>" name="tag_id<?php echo $idtab ?>" value="<?php echo $tag_id; ?>">
    <?php else: ?>
        <input type="hidden" id="post__not_in" name="post__not_in" value="<?php echo $post__not_in; ?>">
        <input type="hidden" id="hang_xe_id" name="hang_xe_id" value="<?php foreach($hang_xe_id as $id){ echo $id . ','; } ?>">
        <input type="hidden" id="loai_xe_id" name="loai_xe_id" value="<?php echo $loai_xe_id; ?>">
        <input type="hidden" id="loai_hop_so_id" name="loai_hop_so_id" value="<?php echo $loai_hop_so_id; ?>">
        <input type="hidden" id="mau_xe_id" name="mau_xe_id" value="<?php echo $mau_xe_id; ?>">
        <input type="hidden" id="tinh_trang_id" name="tinh_trang_id" value="<?php echo $tinh_trang_id; ?>">
        <input type="hidden" id="tag_id" name="tag_id" value="<?php foreach($tag_id as $id){ echo $id . ','; } ?>">
    <?php endif; ?>
</form>