<div class="menu-mobile" id="menu-mobile">
    <?php
        wp_nav_menu(array(
            'theme_location' => 'primary', 
            'container'      => 'nav',
            'container_class'=> 'primary-menu-container',
            'menu_class'     => 'menu',
        ));
    ?>
</div>