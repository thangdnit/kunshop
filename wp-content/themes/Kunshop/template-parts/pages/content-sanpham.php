<section id="buying-page" class="page-layout">
    <div class="wrapper">
        <h1 class="title-page color-primary text-ultra"><?php echo get_the_title(11); ?></h1>

        

        <h2 class="title-page mobile color-primary text-ultra position-relative">Tất cả sản phẩm <div class="keyword-ajax"></div><div class="loading-spinner"></div></h2>
        <div class="car-list-section">
            <div>
                <div class="car-list-wrapper" id="car-list-ajax">
                    <?php
                        $posts_per_page = 4;
                        $current_page = 1;

                        $data = [
                            'posts_per_page' => $posts_per_page,
                            'paged' => $current_page,
                            'post_type' => 'product',
                        ];

                        $products = new WP_Query($data);


                        $total_pages = $products->max_num_pages;
                    ?>

                    <?php if($products->have_posts()): ?>
                        <?php while($products->have_posts()): ?>
                            <?php
                                $products->the_post();
                                $code = get_field('code');
                                $price = get_field('price');
                                $promotional_price = get_field('promotional_price');
                                $image = get_field('image');
                                $description = get_field('description');
                                $gallery = get_field('gallery');
                                $infomation = get_field('information');
                            ?>
                        <?php include locate_template("template-parts/components/boxs/car-box.php"); ?>   
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="title-not-found">Không tìm thấy kết quả nào</div>
                    <?php endif; ?>
                </div>
                <div id="pagination-ajax">
                    <?php include locate_template("template-parts/components/paginations/pagination-ajax-filter.php"); ?>
                </div>
            </div>
        </div>
    </div>
</section>