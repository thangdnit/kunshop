<?php
    $google_map_link = get_field("google_map_link", "option");
    $youtube = get_field("youtube", "option");
    $tiktok = get_field("tiktok", "option");
    $facebook = get_field("facebook", "option");
    $zalo = get_field("zalo", "option");
    $zalo_qr = get_field("zalo_qr", "option");
    $phone = get_field("phone", "option");
    $email = get_field("email", "option");
    $showroom = get_field("showroom", "option");
    $business_hours = get_field("business_hours", "option");
?>
<div>
    <div class="title-page">Hãy liên hệ với toàn cars</div>
    <div class="boxs-contact">
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Chăm sóc Khách hàng</div>
                <div class="box-contact__content">
                    <div><span class="text-bold color-tertiary">Hotline <a class="color-primary shinehover" href="tel:<?php echo $phone; ?>"><?php echo $phone ?></a></span></div>
                    <div><?php echo $business_hours; ?></div>
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
                            <a target="_blank" class="shinehover text-semibold color-primary" href="https://zalo.me/<?php echo $zalo; ?>"><?php echo $zalo; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Địa chỉ showroom</div>
                <div class="box-contact__content">
                    <div class="color-primary text-ultra">toàn cars - Chuyên xe lướt Bình Dương</div>
                    <div><a class="shinehover" href="<?php echo $google_map_link; ?>?" target="_blank"><?php echo $showroom; ?></div></a>
                    <div><a class="color-primary shinehover text-bold" href="tel:<?php echo $phone; ?>" target="_blank"><?php echo $phone; ?></a></div>
                </div>
            </div>
        </div>
        <div>
            <div class="box-contact">
                <div class="box-contact__title">Đăng ký theo dõi</div>
                <div class="box-contact__content">
                    <div class="follow-box">
                        <a class="shinehover image-hover-effect" href="<?php echo $youtube; ?>" target="_blank">
                            <div class="youtbRed-icon bgrsize100"></div>
                            <div class="color-red text-bold">toàn cars</div>
                        </a>
                        <a class="shinehover image-hover-effect" href="<?php echo $tiktok; ?>" target="_blank">
                            <div class="tiktokColor-icon bgrsize100"></div>
                            <div class="text-bold">toàn cars</div>
                        </a>
                        <a class="shinehover image-hover-effect" href="<?php echo $facebook; ?>" target="_blank">
                            <div class="fbColor-icon bgrsize100"></div>
                            <div class="color-primary text-bold">toàn cars</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>