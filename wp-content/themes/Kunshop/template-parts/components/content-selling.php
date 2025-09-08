<?php
    query_posts( array (  'post_type' => 'page', 'post__in' => array( 11 ) ));
    if(have_posts()):
        the_post();
        $heading = get_field('heading');
        $phone = get_field('phone', 'option');
        $zalo = get_field('zalo', 'option');
?>
<div class="selling-page-header" id="selling-page-header">
    <div>
        <div class="selling-page-header__left">
            <h1 class="selling-page-header__title color-yellow text-ultra"><?php echo $heading ?></h1>
            <div class="selling-page-contact">
                <div class="text-semibold color-white">Liên hệ bán xe nhanh</div>
                <div class="selling-page-contact__phone">
                    <a class="shinehover menu-contact__item" href="tel:<?php echo $phone; ?>" target="_blank">
                        <div class="phone-icon bgrsize100"> </div>
                        <div class="padding-text"><?php echo $phone; ?></div>
                    </a>

                    <a class="shinehover menu-contact__item rounded-circle zalo" href="https://zalo.me/<?php echo $zalo; ?>" target="_blank">
                        <div class="zalo-icon bgrsize100"> </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="selling-page-header__right">
            <?php include locate_template("template-parts/components/forms/form-sellcar.php") ?>
        </div>
    </div>
</div>

<?php endif; ?>
<?php wp_reset_query(); ?>
