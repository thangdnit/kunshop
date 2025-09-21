<?php include locate_template("template-parts/components/forms/error.php") ?>
<?php include locate_template("template-parts/components/forms/success.php") ?>
<?php include locate_template("template-parts/components/menu-mobile.php") ?>
</main>
<?php 
$address = get_field("address", "option");
$google_map_link = get_field("google_map_link", "option");
$phone = get_field("phone", "option");
$facebook = get_field("facebook", "option");
$lazada = get_field("lazada", "option");
$shopee = get_field("shopee", "option");
$tiktok = get_field("tiktok", "option");
$zalo_id = get_field("zalo_id", "option");
$messenger = get_field("messenger", "option");
?>
<section id="footer">
    <div class="wrapper">
        <div class="footer-bottom">
            <div class="footer-row">
                <a class="shinehover" href="<?php echo home_url(); ?>">
                    <div class="logo bottom-logo bgrsize100"></div>
                </a>
                <div>
                    <?php include locate_template("template-parts/components/forms/form-signup.php"); ?>
                </div>
            </div>
            <div class="footer-row">
                <div class="contact-footer">
                    <div class="contact-footer__item">
                        <div>
                            <div class="text-regular">Địa chỉ.</div>
                            <div class="text-bold"><a class="shinehover" target="_blank" href="<?php echo $google_map_link; ?>"><?php echo $address; ?></div></a>
                        </div>
                        <div>
                            <div class="text-regular">Điện thoại.</div>
                            <div class="text-bold"><a class="shinehover" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
                        </div>
                        <div class="footer-contact_phone mobile">
                            <a class="shinehover menu-contact__item" href="tel:<?php echo $phone; ?>" target="_blank">
                                <div class="phone-icon bgrsize100"> </div>
                                <div><?php echo $phone; ?></div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-footer__item">
                        <a class="shinehover image-hover-effect" href="<?php echo $tiktok; ?>" target="_blank"><div class="tiktokWhite-icon bgrsize100"></div></a>
                        <a class="shinehover image-hover-effect" href="<?php echo $facebook; ?>" target="_blank"><div class="fbWhite-icon bgrsize100"></div></a>
                        <a class="shinehover image-hover-effect" href="<?php echo $lazada; ?>" target="_blank"><div class="lazadaWhite-icon bgrsize100"></div></a>
                        <a class="shinehover image-hover-effect" href="<?php echo $shopee; ?>" target="_blank"><div class="shopeeWhite-icon bgrsize100"></div></a>
                    </div>
                </div>
                <div class="bottom-menu">
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_menu', 
                            'container'      => 'nav',
                            'container_class'=> 'footer-menu-container',
                            'menu_class'     => 'menu',
                        ));
                    ?>
                </div>
            </div>
            <div class="footer-row">
                <div>Copyright © 2025 KunKunShop</div>
                <a class="shinehover" href="<?php echo get_page_link(20); ?>" target="_blank">Chính sách bảo mật</a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";</script>
<?php wp_footer(); ?>
<?php include locate_template("template-parts/components/contact-popup.php") ?>
</body>
<div class="overlay transition-overlay"><div class="logo bgrsize100"></div></div>

</html>