<?php
    $title = $car->get_title();
    $price = $car->get_price();
    $thumbnail = $car->get_thumbnail();
    $advanced = $car->get_advanced();
    $loai_hop_so = $car->get_term_car('loai-hop-so');
    $status = $car->get_term_car('tinh-trang');
    $tags = $car->get_term_car('tag-xe');
    $link = $car->get_link();
?>
<div class="car-box">
    <div class="car-box__image">
        <a class="shinehover" href="<?php echo $link; ?>"><?php echo $thumbnail; ?></a>
    </div>
    <div class="car-box__content">
        <div class="car-box__name">
            <h3 class="text-ultra color-primary"><a class="shinehover" href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
            <div><?php echo $status->name . ' - ' . $status->description; ?></div>
        </div>
        <div class="car-box__info">
            <div class="car-box__info__item">
                <div>
                    <div class="odo-icon bgrsize100"></div>
                    <div class="text-semibold"><?php echo $advanced['so_km_da_di'] . ' km'; ?></div>
                </div>
            </div>
            <div class="car-box__info__item">
                <div>
                    <div class="fuel-icon bgrsize100"></div>
                    <div class="text-semibold"><?php echo $advanced['nhien_lieu'] ?></div>
                </div>
            </div>
            <div class="car-box__info__item">
                <div>
                    <div class="transmission-icon bgrsize100"></div>
                    <div class="text-semibold"><?php echo $loai_hop_so->name; ?></div>
                </div>
            </div>
        </div>
        <div class="car_box__price">
            <div class="text-bold color-primary"><?php echo $price; ?></div>
            <div class="text-semibold color-primary"><a class="d-inline-flex align-items-center shinehover text-semibold" href="<?php echo $link; ?>">Xem thêm &nbsp;<div class="arrow-icon bgrsize100"></div></a></div>
        </div>
    </div>
    <div class="car-box__tag">
        <?php foreach ($tags as $tag): ?>
            <div class="car-box__tag-item"><?php echo $tag->name; ?></div>
        <?php endforeach; ?>
    </div>
</div>