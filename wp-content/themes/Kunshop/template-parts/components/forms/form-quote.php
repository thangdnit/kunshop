<?php global $placeholder_texts; ?>
<?php $product_title_single = get_query_var('product_title_single'); ?>
<?php $product_link = get_query_var('product_link'); ?>
<div id="quoteModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content custom-modal-content">
            <div class="form-modal-header">
                <div class="form-modal-title">Báo giá lăn bánh</div>
            </div>
            <div class="form-modal-body">
                <form id="form-quote" class="form-quote" action="" method="POST" novalidate>
                    <div class="loading-spinner"></div>
                    <div class="form-general_content">
                        <div>
                            <div class="label-input">Họ và Tên</div>
                            <input id="form-quote__name" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_name'] ?>" autocomplete="off">
                        </div>
                        <div>
                            <div class="label-input">Số điện thoại</div>
                            <input id="form-quote__phone" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_phone'] ?>" autocomplete="off">
                        </div>
                        <div>
                            <div class="label-input">Email</div>
                            <input id="form-quote__email" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_email'] ?>" autocomplete="off">
                        </div>
                        <input type="text" name="form-quote__product-name" id="form-quote__product-name" style="display: none;" value="<?php echo $product_title_single; ?>">
                        <input type="text" name="form-quote__product-link" id="form-quote__product-link" style="display: none;" value="<?php echo $product_link; ?>">
                    </div>
                    <div class="form-general_footer">
                        <button class="shinehover custom-button" type="submit">Gửi thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
