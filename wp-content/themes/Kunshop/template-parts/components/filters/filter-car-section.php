<div class="car-filter-section">
    <?php include locate_template("template-parts/components/filters/filter-car.php"); ?>
    <?php
        $taxonomy_all = get_object_taxonomies('cars', 'objects');
        $taxonomys = [];
        foreach ($taxonomy_all as $taxonomy) {
            $taxonomys[] = [
                'terms' => get_terms( array(
                    'taxonomy' => $taxonomy->name,
                    'hide_empty' => false,
                    'parent' => 0,
                )),
                'class' => $taxonomy->name,
                'label' => $taxonomy->label
            ];
        }
        $count_item = 1;
    ?>
    <div class="car-filter-all">
        <?php foreach ($taxonomys as $taxonomy): ?>
            <div class="car-filter__<?php echo $taxonomy['class']; ?> car-filter">

                <?php if ($taxonomy['class'] == 'hang-xe'): ?>
                    <select name="car-filter__<?php echo $taxonomy['class']; ?>" id="car-filter__<?php echo $taxonomy['class']; ?>" onchange="loadCarModel('car-filter__<?php echo $taxonomy['class']; ?>')">
                        <option value="0"><?php echo $taxonomy['label'] ?></option>
                        <?php foreach($taxonomy['terms'] as $term): ?>
                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <select name="car-filter__<?php echo $taxonomy['class']; ?>" id="car-filter__<?php echo $taxonomy['class']; ?>" onchange="updateLocalStorageSelect('car-filter__<?php echo $taxonomy['class']; ?>')">
                        <option value="0"><?php echo $taxonomy['label'] ?></option>
                        <?php foreach($taxonomy['terms'] as $term): ?>
                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <?php if ($taxonomy['class'] == 'hang-xe'): ?>
                <?php
                    $full = get_terms('hang-xe', array('hide_empty' => 0));

                    $dong_xe = array_filter($full, function ($t) {
                        return $t->parent != 0;
                    });
                ?>
                <div class="car-filter__dong-xe car-filter">
                <select name="car-filter__dong-xe" id="car-filter__dong-xe" onchange="loadCarBrand('car-filter__dong-xe')" value="0">
                    <option value="0">Dòng xe</option>
                    <?php foreach($dong_xe as $dong): ?>
                        <option value="<?php echo $dong->term_id; ?>"><?php echo $dong->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <?php if ($count_item == 2) {
                break;
            }?>
            <?php $count_item++; ?>
        <?php endforeach; ?>

        <?php include locate_template("template-parts/components/filters/filter-car-advanced.php") ?>
        
        <div>
            <button class="shinehover btn-advanced-filter" onclick="showAdvancedFilter()">
                <div class="filter-icon bgrsize100"></div> 
                <div>Bộ Lọc</div>
            </button>
        </div>
        
        <div class="car-filter__button">
            <button onclick="loadCarFilterMain()" class="shinehover custom-button">
                <div class="search-icon bgrsize100"></div>
                <div>Tìm kiếm</div>
            </button>
        </div>
    </div>
</div>