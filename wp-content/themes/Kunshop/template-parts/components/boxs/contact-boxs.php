<?php
    $google_map_link = get_field("google_map_link", "option");
    $tiktok = get_field("tiktok", "option");
    $facebook = get_field("facebook", "option");
    $zalo_id = get_field("zalo_id", "option");
    $zalo_qr = get_field("zalo_qr", "option");
    $hotline = get_field("hotline", "option");
    $email = get_field("email", "option");
    $address = get_field("address", "option");
    $working_hours = get_field("work_hours", "option");
?>
<div>
    <div class="title-page">Hãy liên hệ với KunkunShop</div>
    <div class="boxs-contact">
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Chăm sóc Khách hàng</div>
                <div class="box-contact__content">
                    <div><span class="text-bold color-tertiary">Hotline <a class="color-primary shinehover" href="tel:<?php echo $hotline; ?>"><?php echo $hotline ?></a></span></div>
                    <div class="color-black"><?php echo $working_hours; ?></div>
                    <div><span class="text-semibold color-primary">email. <a class="shinehover" href="mailto:<?php echo $email; ?>"><?php echo $email ?></a></span></div>
                </div>
            </div>
        </div>
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Liên hệ qua Zalo</div>
                <div class="box-contact__content">
                    <div>
                        <div class="zalo-qr">
                            <?php echo get_image($zalo_qr, 'large'); ?>
                        </div>
                        <div>
                            <div class="text-bold">Zalo ID</div>
                            <a target="_blank" class="shinehover text-semibold color-primary" href="https://zalo.me/<?php echo $zalo_id; ?>"><?php echo $zalo_id; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Địa chỉ</div>
                <div class="box-contact__content">
                    <div class="color-primary text-ultra">Kunshop - Chuyên dược mỹ phẩm chính hãng</div>
                    <div><a class="shinehover" href="<?php echo $google_map_link; ?>?" target="_blank"><?php echo $address; ?></div></a>
                    <div><a class="color-primary shinehover text-bold" href="tel:<?php echo $hotline; ?>" target="_blank"><?php echo $hotline; ?></a></div>
                </div>
            </div>
        </div>
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Đăng ký theo dõi</div>
                <div class="box-contact__content">
                    <div class="follow-box">
                        <a class="shinehover image-hover-effect" href="<?php echo $tiktok; ?>" target="_blank">
                            <div class="tiktokColor-icon bgrsize100"></div>
                            <div class="text-bold color-black">KunkunShop</div>
                        </a>
                        <a class="shinehover image-hover-effect" href="<?php echo $facebook; ?>" target="_blank">
                            <div class="fbColor-icon bgrsize100"></div>
                            <div class="color-primary text-bold">KunkunShop</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>