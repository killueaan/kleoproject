<div class="bg2">
</div>

<!-- catalog start -->
<div class="catalog container mt-75">
    <h2>Каталог</h2>

    <form action="" method="post" class="form-search" name="form-serch">
        <input type="text" name="name" placeholder="поиск">
        <input type="submit" class="search-btn" name="form-search" value="">
    </form>

</div>

<div class="catalog-page-section container">
    <input type="checkbox" name="" id="filter">
    <label for="filter"></label>
    <div class="filters">
        <div class="filt-block">
            <h3>Тип изделия</h3>
            <div class="vars">
                <?
                $sql = "SELECT * FROM `type`";
                $result = $connect->query($sql);
                foreach ($result as $type) { ?>
                    <a href="?page=catalog&type=<?= $type['id'] ?>"><?= $type['name'] ?></a>
                <?
                }
                ?>
            </div>
        </div>
        <div class="filt-block">
            <h3>Коллекция</h3>
            <div class="vars">
                <?
                $sql = "SELECT * FROM `collection` ORDER BY id ASC LIMIT 2";
                $result = $connect->query($sql);
                foreach ($result as $collection) { ?>
                    <a href="?page=catalog&collection=<?= $collection['id'] ?>"><?= $collection['name'] ?></a>
                <?
                }
                ?>
                <div class="drop-down">
                    <div class="drop-down-btn">
                        <button>Показать больше</button>
                    </div>
                    <div class="submenu">
                        <?
                        $sql = "SELECT * FROM `collection` WHERE id NOT IN (1,2) ORDER BY id ASC";
                        $result = $connect->query($sql);
                        foreach ($result as $collection) { ?>
                            <a href="?page=catalog&collection=<?= $collection['id'] ?>"><?= $collection['name'] ?></a>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="filt-block">
            <h3>Металл</h3>
            <div class="vars">
                <?
                $sql = "SELECT * FROM `metal` ORDER BY id ASC LIMIT 2";
                $result = $connect->query($sql);
                foreach ($result as $metal) { ?>
                    <a href="?page=catalog&metal=<?= $metal['id'] ?>"><?= $metal['name'] ?></a>
                <?
                }
                ?>
                <div class="drop-down">
                    <div class="drop-down-btn">
                        <button>Показать больше</button>
                    </div>
                    <div class="submenu">
                        <?
                        $sql = "SELECT * FROM `metal` WHERE id NOT IN (1,2) ORDER BY id ASC";
                        $result = $connect->query($sql);
                        foreach ($result as $metal) { ?>
                            <a href="?page=catalog&metal=<?= $metal['id'] ?>"><?= $metal['name'] ?></a>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="filt-block">
            <h3>Проба металла</h3>
            <div class="vars">
                <?
                $sql = "SELECT * FROM `metal_sample` ORDER BY id ASC LIMIT 2";
                $result = $connect->query($sql);
                foreach ($result as $sample) { ?>
                    <a href="?page=catalog&sample=<?= $sample['id'] ?>"><?= $sample['name'] ?></a>
                <?
                }
                ?>
                <div class="drop-down">
                    <div class="drop-down-btn">
                        <button>Показать больше</button>
                    </div>
                    <div class="submenu">
                        <?
                        $sql = "SELECT * FROM `metal_sample` WHERE id NOT IN (1,2) ORDER BY id ASC";
                        $result = $connect->query($sql);
                        foreach ($result as $sample) { ?>
                            <a href="?page=catalog&sample=<?= $sample['id'] ?>"><?= $sample['name'] ?></a>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/filters.js"></script>

        <div class="filters-btn">
            <button onclick="filtBtn()" class="btn filt-btn">Сбросить фильтры</button>
            <script>
                function filtBtn() {
                    window.location.href = `?page=catalog`;
                }
            </script>
        </div>
    </div>
    <?
    if (isset($_POST['form-search'])) {
        if (isset($_GET['collection'])) {
            $id_cat = $_GET['collection'];
            $sql_cat = "AND `id_collection` = '$id_cat'";
        } else
        if (isset($_GET['type'])) {
            $id_type = $_GET['type'];
            $sql_cat = "AND `id_type` = '$id_type'";
        } else
        if (isset($_GET['sample'])) {
            $id_sample = $_GET['sample'];
            $sql_cat = "AND `id_sample` = '$id_sample'";
        } else {
            $sql_cat = "";
        }
        $text = $_POST['name'];
        $dop_sql = "WHERE `name_product` LIKE '%" . $text . "%' OR id_type IN (SELECT id FROM `type` WHERE `name` LIKE '%" . $text . "%') 
        OR id_collection IN (SELECT id FROM `collection` WHERE `name` LIKE '%" . $text . "%') $sql_cat ";

        if (empty($text)) {
            echo '<script>document.location.href="?page=catalog"</script>';
        }

        $sql = "SELECT * FROM `product` $dop_sql";
        $res = $connect->query($sql)->rowCount();
        if ($res == 0) {
            echo "<p class='error-search'>По запросу '$text' ничего не найдено.<br> Попробуйте еще раз.</p>";
        }
    } else {
        $dop_sql = "";
    }
    ?>
    <div class="catalog-section">
        <?
        $sql = "SELECT * FROM `product`";
        $where = [];
        $dop_sql = "";
        $search_performed = false;


        // Обработка поиска
        if (isset($_POST['form-search']) && !empty($_POST['name'])) {
            $text = $_POST['name'];
            $search_performed = true;

            $search_conditions = [
                "`name_product` LIKE '%" . $text . "%'",
                "id_type IN (SELECT id FROM `type` WHERE `name` LIKE '%" . $text . "%')",
                "id_collection IN (SELECT id FROM `collection` WHERE `name` LIKE '%" . $text . "%')",
                "id_metal IN (SELECT id FROM `metal` WHERE `name` LIKE '%" . $text . "%')",
                "id_sample IN (SELECT id FROM `metal_sample` WHERE `name` LIKE '%" . $text . "%')"
            ];
            $where[] = "(" . implode(" OR ", $search_conditions) . ")";
        }

        // Обработка фильтров
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $where[] = "`id_type` = '" . $_GET['type'] . "'";
        }
        if (isset($_GET['collection']) && !empty($_GET['collection'])) {
            $where[] = "`id_collection` = '" . $_GET['collection'] . "'";
        }
        if (isset($_GET['sample']) && !empty($_GET['sample'])) {
            $where[] = "`id_sample` = '" . $_GET['sample'] . "'";
        }
        if (isset($_GET['metal']) && !empty($_GET['metal'])) {
            $where[] = "`id_metal` = '" . $_GET['metal'] . "'";
        }

        // Формируем SQL запрос
        $sql = "SELECT * FROM `product`";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
            $res = $connect->query($sql)->fetchAll();
            if (empty($res)) {
                echo "<p class='error-search'>Ничего не найдено.</p>";
            }
        }
        $sql .= "$dop_sql";

        $result = $connect->query($sql);
        foreach ($result as $product) {
            $id = $product['id'];
        ?>
            <div class="product-card">
                <div class="img-pr">
                    <img src="<?= $product['main_img'] ?>">
                </div>
                <div class="content-card">
                    <div class="text-card">
                        <?
                        $id_col = $product['id_collection'];
                        $sql = "SELECT * FROM `collection` WHERE id=$id_col";
                        $collection = $connect->query($sql)->fetch();
                        ?>
                        <p>Коллекция <?= $collection['name'] ?></p>
                        <?
                        $id_typ = $product['id_type'];
                        $sql = "SELECT * FROM `type` WHERE id=$id_typ";
                        $type = $connect->query($sql)->fetch();

                        $id_metal = $product['id_metal'];
                        $sql = "SELECT * FROM `metal` WHERE id=$id_metal";
                        $metal = $connect->query($sql)->fetch();

                        if ($metal['id'] == 1) { ?>
                            <h3><?= $type['name'] ?> из белого золота «<?= $product['name_product'] ?>»</h3>

                        <? } else if ($metal['id'] == 2) { ?>
                            <h3><?= $type['name'] ?> из желтого золота «<?= $product['name_product'] ?>»</h3>

                        <? } else { ?>
                            <h3><?= $type['name'] ?> из розового золота «<?= $product['name_product'] ?>»</h3>
                        <? }
                        ?>
                        <h4><? echo number_format($product['price'], 0, '.', ' '); ?> ₽</h4>
                    </div>
                    <a href="?page=product&id=<?= $id ?>" class="btn">Подробнее</a>
                </div>
            </div>
        <? }
        ?>
    </div>
</div>