<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php wp_head(); ?>
    <meta name="author" content="Toan Car" />
    <title><?php bloginfo('name'); ?> - <?php wp_title(''); ?></title>
</head>

<body class="<?php echo implode(" ", get_body_class()); ?>">

<main id="swup" class="transition-main" body-class="<?php echo implode(" ", get_body_class()); ?>">
<?php
    $phone = get_field("phone", "option");
    $youtb = get_field("youtube", "option"); 
?>
<section id="header">
    <div class="wrapper">
        <div class="header-top">
            <a class="shinehover" href="<?php echo home_url(); ?>">
                <div class="logo top-logo bgrsize100"></div>
            </a>

            <div class="top-menu">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary', 
                        'container'      => 'nav',
                        'container_class'=> 'primary-menu-container',
                        'menu_class'     => 'menu',
                    ));
                ?>
            </div>
            
            <div class="menu-contact">
                <a class="shinehover menu-contact__item image-hover-effect" href="tel:<?php echo $phone; ?>" target="_blank">
                    <div class="phone-icon bgrsize100"> </div>
                    <div class="padding-text"><?php echo $phone; ?></div>
                </a>

                <a class="shinehover menu-contact__item rounded-circle image-hover-effect" href="<?php echo $youtb; ?>" target="_blank">
                    <div class="youtbBlue-icon bgrsize100"> </div>
                </a>
            </div>

            <div class="header-mobile__menu shinehover" onclick="toggleMenuMobile()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
    </div> 
</section>
<section id="header-fixed">
    <div class="wrapper">
        <div class="header-top">
            <a class="shinehover" href="<?php echo home_url(); ?>">
                <div class="logo top-logo bgrsize100"></div>
            </a>

            <div class="top-menu">
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary', 
                    'container'      => 'nav',
                    'container_class'=> 'primary-menu-container',
                    'menu_class'     => 'menu',
                ));
            ?>
            </div>
            
            <div class="menu-contact">
                <a class="shinehover menu-contact__item image-hover-effect" href="tel:<?php echo $phone; ?>" target="_blank">
                    <div class="phone-icon bgrsize100"> </div>
                    <div class="padding-text"><?php echo $phone; ?></div>
                </a>

                <a class="shinehover menu-contact__item rounded-circle image-hover-effect" href="<?php echo $youtb; ?>" target="_blank">
                    <div class="youtbBlue-icon bgrsize100"> </div>
                </a>
            </div>

            <div class="header-mobile__menu shinehover" onclick="toggleMenuMobile()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
    </div> 
</section>
<section class="extend-section">
    <?php if (is_page(11)): ?>
        <?php get_template_part('template-parts/components/content', 'selling'); ?>
    <?php endif; ?>
    
    <?php if (is_page(14)):?>
        <div class="search-custom">
            <?php include locate_template('template-parts/components/search-bar.php'); ?>
        </div>
    <?php endif; ?>
</section>
<div class="buffer">
</div>  
