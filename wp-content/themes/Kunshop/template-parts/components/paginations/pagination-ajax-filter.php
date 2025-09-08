
<div class="custom-pagination">
    <!-- "Previous" -->
    <?php if ($current_page > 1): ?>
        <a onclick="loadCarFilterMain(<?php echo $current_page - 1 ?>)" class="prev-icon bgrsize100 shinehover"></a>
    <?php else: ?>
        <span class="prev-icon bgrsize100 disabled-custom shinehover"></span>
    <?php endif; ?>

    <?php
        if ($current_page == 1) {
            $start = 1;
            $end = min(3, $total_pages);
        } elseif ($current_page == $total_pages) {
            $start = max(1, $total_pages - 2);
            $end = $total_pages;
        } else {
            $start = max(1, $current_page - 1);
            $end = min($total_pages, $current_page + 1);
        }
    ?>
    
    <?php for ($i = $start; $i <= $end; $i++) : ?>
        <?php if ($i == $current_page): ?>
            <span class="current"><?php echo $i; ?></span>
        <?php else: ?>
            <a class="page-number shinehover" onclick="loadCarFilterMain(<?php echo $i; ?>)"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- Nút "Next" -->
    <?php if ($current_page < $total_pages): ?>
        <a onclick="loadCarFilterMain(<?php echo $current_page + 1; ?>)" class="next-icon bgrsize100 shinehover"></a>
    <?php else: ?>
        <span class="next-icon bgrsize100 disabled-custom shinehover"></span>
    <?php endif; ?>
</div>