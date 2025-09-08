<section id="buying-page" class="page-layout">
    <div class="wrapper">
        <div class="product-list-column">
            <h1 class="title-page mobile color-primary text-ultra position-relative"><?php the_title(); ?><div class="keyword-ajax"></div><div class="loading-spinner"></div></h1>
            <div class="product-list-section">
                <div>
                    <div class="product-list-wrapper" id="product-list-ajax">
                        <?php
                            $posts_per_page = 12;
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
                                    $link = get_permalink();
                                    $title = get_the_title();
                                    $product_tag = get_the_terms(get_the_ID(), 'product_tag');
                                ?>
                            <?php include locate_template("template-parts/components/boxs/product-box.php"); ?>   
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
        <?php include locate_template("template-parts/components/filters/filter-product-column.php"); ?>
    </div>
</section>