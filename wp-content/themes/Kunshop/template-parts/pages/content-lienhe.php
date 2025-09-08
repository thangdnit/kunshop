<?php
if (have_posts()):
    the_post();
    $google_map = get_field("google_map", "option");
?>

<section id="contact-page" class="page-layout">
    <div class="wrapper">
        <?php include locate_template('template-parts/components/breadcrumb.php'); ?>
        <h1 class="title-page"><?php the_title(); ?></h1>
        <div class="google-map">
            <iframe src="<?php echo $google_map; ?>" width="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>`
        </div>
        <?php include locate_template("template-parts/components/boxs/contact-boxs.php"); ?>
    </div>
</section>
<?php endif; ?>