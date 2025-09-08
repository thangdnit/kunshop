<?php global $placeholder_texts; ?>
<?php $product_title_single = get_query_var('product_title_single'); ?>
<?php $product_link = get_query_var('product_link'); ?>
<div id="registerDriveModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content custom-modal-content">
            <div class="form-modal-header">
                <div class="form-modal-title">Đăng ký lái thử</div>
            </div>
            <div class="form-modal-body">
                <form id="form-drive" class="form-drive" action="" method="POST" novalidate>
                    <div class="loading-spinner"></div>
                    <div class="form-general_content">
                        <div>
                            <div class="label-input">Họ và Tên</div>
                            <input id="form-drive__name" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_name'] ?>" autocomplete="off">
                        </div>
                        <div>
                            <div class="label-input">Số điện thoại</div>
                            <input id="form-drive__phone" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_phone'] ?>" autocomplete="off">
                        </div>
                        <div>
                            <div class="label-input">Email</div>
                            <input id="form-drive__email" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_email'] ?>" autocomplete="off">
                        </div>
                        <div>
                            <div class="label-input">Ngày</div>
                            <input min="<?php echo date('Y-m-d'); ?>" id="form-drive__date" class="custom-input" placeholder="<?php echo $placeholder_texts['form_holder_date'] ?>" autocomplete="off" autocomplete="off">
                        </div>
                        <input type="text" name="form-drive__product-name" id="form-drive__product-name" style="display: none;" value="<?php echo $product_title_single; ?>">
                        <input type="text" name="form-drive__product-link" id="form-drive__product-link" style="display: none;" value="<?php echo $product_link; ?>">
                    </div>
                    <div class="form-general_footer">
                        <button class="shinehover custom-button" type="submit">Gửi thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
