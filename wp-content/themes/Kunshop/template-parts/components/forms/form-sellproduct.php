<?php global $placeholder_texts; ?>
<form action="" id="form-sellproduct" class="form-sellproduct" method="POST" novalidate>
    <div class="loading-spinner"></div>
    <div class="form-sellproduct_header form-general_header">
        <div>Bán xe</div>
        <span>Nhập thông tin chi tiết xe của bạn</span>
    </div>
    <div class="form-sellproduct_content form-general_content">
        <div>
            <div>
                <div class="label-input">Dòng xe cần bán</div>
                <input id="form-sellproduct__product-model" class="custom-input" type="text" placeholder="Ford" autocomplete="off">
            </div>
            <div>
                <div class="label-input">Phiên bản</div>
                <input id="form-sellproduct__product-version" class="custom-input" type="text" placeholder="Đặc biệt" autocomplete="off">
            </div>
        </div>
        <div>
            <div>
                <div class="label-input">Số KM đã đi</div>
                <input id="form-sellproduct__product-odo" class="custom-input" type="text" placeholder="10000" autocomplete="off">
            </div>
            <div>
                <div class="label-input">Năm sản xuất</div>
                <input id="form-sellproduct__product-year" class="custom-input" type="text" placeholder="2025" autocomplete="off">
            </div>
        </div>
        <div>
            <div>
                <div class="label-input">Số điện thoại liên hệ</div>
                <input id="form-sellproduct__phone" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_phone'] ?>" autocomplete="off">
            </div>
            <div>
                <div class="label-input">Email</div>
                <input id="form-sellproduct__email" class="custom-input" type="text" placeholder="<?php echo $placeholder_texts['form_holder_email'] ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="form-sellproduct_footer form-general_footer">
        <button class="shinehover custom-button" type="submit">Gửi thông tin</button>
    </div>
</form>