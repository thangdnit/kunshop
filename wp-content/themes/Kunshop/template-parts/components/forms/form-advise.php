<?php global $placeholder_texts; ?>
<?php $car_title_single = get_query_var('car_title_single'); ?>
<?php $car_link = get_query_var('car_link'); ?>
<form action="" method="POST" id="form-advise" class="form-advise">
    <div class="loading-spinner"></div>
    <div class="form-general_header">
        <span>Điền thông tin tư vấn xe</span>
    </div>
    <div class="form-general_content">
        <div>
            <div class="label-input">Họ và Tên</div>
            <input id="form-advise__name" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_name'] ?>" autocomplete="off">
        </div>
        <div>
            <div class="label-input">Số điện thoại</div>
            <input id="form-advise__phone" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_phone'] ?>" autocomplete="off">
        </div>
        <input type="text" name="form-advise__car-name" id="form-advise__car-name" style="display: none;" value="<?php echo $car_title_single; ?>">
        <input type="text" name="form-advise__car-link" id="form-advise__car-link" style="display: none;" value="<?php echo $car_link; ?>">
    </div>
    <div class="form-general_footer">
        <button class="shinehover custom-button" type="submit">Gửi thông tin</button>
    </div>
</form>