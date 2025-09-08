<?php
get_header();

$current_taxonomy = get_queried_object();

if (is_tag()) {
    get_template_part('template-parts/tag/content', 'post');
} else {
    get_template_part('template-parts/pages/content', '404');
}

get_footer();
