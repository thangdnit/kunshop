<?php include locate_template("template-parts/components/forms/form-quote.php") ?>
<?php include locate_template("template-parts/components/forms/form-drive.php") ?>
<?php include locate_template("template-parts/components/error.php") ?>
<?php include locate_template("template-parts/components/success.php") ?>
<?php include locate_template("template-parts/components/menu-mobile.php") ?>
</main>
<?php 
$gpkd = get_field("gpkd", "option");
$showroom = get_field("showroom", "option");
$google_map_link = get_field("google_map_link", "option");
$phone = get_field("phone", "option");
$youtube = get_field("youtube", "option");
$facebook = get_field("facebook", "option");
$tiktok = get_field("tiktok", "option");
$zalo = get_field("zalo", "option");
?>
<section id="footer">
    <div class="wrapper">
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
                    <div class="text-semibold"><?php echo $gpkd ?></div>
                </div>
                <div class="contact-footer__item">
                    <div>
                        <div class="text-book">Showroom.</div>
                        <div class="text-bold"><a class="shinehover" target="_blank" href="<?php echo $google_map_link; ?>"><?php echo $showroom; ?></div></a>
                    </div>
                    <div>
                        <div class="text-book">Điện thoại.</div>
                        <div class="text-bold"><a class="shinehover" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
                    </div>
                    <div class="selling-page-contact__phone mobile">
                        <a class="shinehover menu-contact__item" href="tel:<?php echo $phone; ?>" target="_blank">
                            <div class="phone-icon bgrsize100"> </div>
                            <div class="padding-text"><?php echo $phone; ?></div>
                        </a>
                    </div>
                </div>
                
                <div class="contact-footer__item">
                    <a class="shinehover image-hover-effect" href="<?php echo $youtube; ?>" target="_blank"><div class="youtbWhite-icon bgrsize100"></div></a>
                    <a class="shinehover image-hover-effect" href="<?php echo $tiktok; ?>" target="_blank"><div class="tiktokWhite-icon bgrsize100"></div></a>
                    <a class="shinehover image-hover-effect" href="<?php echo $facebook; ?>" target="_blank"><div class="fbWhite-icon bgrsize100"></div></a>
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
            <div>Copyright © 2024 Toàn Cars</div>
            <a class="shinehover" href="<?php echo get_page_link(436); ?>" target="_blank">Chính sách bảo mật</a>
        </div>
    </div>
</section>

<script type="text/javascript">var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";</script>
<?php wp_footer(); ?>
<?php include locate_template("template-parts/components/contact-popup.php") ?>
</body>
<div class="overlay transition-overlay"><div class="logo bgrsize100"></div></div>

</html>