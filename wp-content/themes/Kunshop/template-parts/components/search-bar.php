<?php global $placeholder_texts; ?>
<div class="input-search">
    <input class="custom-input" id="car-filter__keyword" type="text" placeholder="<?php echo $placeholder_texts['form_holder_search'] ?>">
    <button id="btn-searchKeyword" class="shinehover custom-button" onclick="searchCarbyKeyword('<?php echo get_page_link(14); ?>', 'car-filter__keyword')">
        <div class="search-icon bgrsize100"></div>
        <div>Tìm kiếm</div>
    </button>
    <div  class="search-icon searchmb bgrsize100 shinehover" onclick="searchCarbyKeyword('<?php echo get_page_link(14); ?>', 'car-filter__keyword')"></div>
</div>