<?php global $placeholder_texts; ?>
<form action="" id="form-contact" class="form-contact" method="POST" novalidate>
    <div class="loading-spinner"></div>
    <div class="form-contact_header form-general_header">
        <span>Gửi tin nhắn</span>
    </div>
    <div class="form-contact_content form-general_content">
        <div>
            <div>
                <div class="label-input color-black">Tên người liên hệ</div>
                <input id="form-contact__name" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_name'] ?>" autocomplete="off">
            </div>
            <div>
                <div class="label-input color-black">Tiêu đề</div>
                <input id="form-contact__title" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_title'] ?>" autocomplete="off">
            </div>
        </div>
        <div>
            <div>
                <div class="label-input color-black">Số điện thoại liên hệ</div>
                <input id="form-contact__phone" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_phone'] ?>" autocomplete="off">
            </div>
            <div>
                <div class="label-input color-black">Email</div>
                <input id="form-contact__email" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_email'] ?>" autocomplete="off">
            </div>
        </div>
        <div>
            <div>
                <div class="label-input color-black">Nội dung liên hệ</div>
                <textarea id="form-contact__content" class="custom-input" rows="6" placeholder="<?php echo $placeholder_texts['form_holder_content'] ?>"></textarea>
            </div>
        </div>
    </div>
    
    <div class="form-contact_footer form-general_footer">
        <button class="shinehover custom-button" type="submit">Gửi thông tin</button>
    </div>
</form>