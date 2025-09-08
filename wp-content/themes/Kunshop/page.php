<?php
get_header();
$queriedobjectid = get_queried_object_id();
switch ($queriedobjectid) {
    case 11:
        get_template_part( 'template-parts/pages/content', 'banxe' );
        break;
    case 14:
        get_template_part( 'template-parts/pages/content', 'muaxe' );
        break;
    case 18:
        get_template_part( 'template-parts/pages/content', 'lienhe' );
        break;
    case 20:
        get_template_part( 'template-parts/pages/content', 'gioithieu' );
        break;
    case 436:
        get_template_part( 'template-parts/pages/content', 'riengtu' );
        break;
    default:
        get_template_part( 'template-parts/pages/content', '404' ); /*404*/
        break;
}    
get_footer();  
?>