<section id="buying-page" class="page-layout">
    <div class="wrapper">
        <h1 class="title-page color-primary text-ultra"><?php echo get_the_title(14); ?></h1>

        <?php include locate_template("template-parts/components/filters/filter-car-section.php"); ?>

        <h2 class="title-page mobile color-primary text-ultra position-relative">Tất cả các xe <div class="keyword-ajax"></div><div class="loading-spinner"></div></h2>
        <div class="car-list-section">
            <div>
                <div class="car-list-wrapper" id="car-list-ajax">
                    <?php
                        $widthValue = intval(get_option('widthValue'));

                        $posts_per_page = $widthValue < 801 ? 4 : get_field('cars_per_page', 'option'); 
                        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;

                        $data = [
                            'posts_per_page' => $posts_per_page,
                            'paged' => $current_page,
                        ];

                        $cars = ToanCar\Car::get_cars($data);
                        $total_pages = $cars->max_num_pages;
                    ?>
                   
                    <?php if($cars->have_posts()): ?>
                        <?php while($cars->have_posts()): ?>
                            <?php 
                                $cars->the_post(); 
                                $car = new ToanCar\Car([
                                    'id' => get_the_ID(),
                                    'title' => get_the_title(),
                                    'excerpt' => get_the_excerpt(),
                                ]);
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