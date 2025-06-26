<?
if (isset($_SESSION['USER'])) {
    if ($USER['role'] == 2) { ?>
        <a href="?page=profile" class="back container mt-150">
            <img src="assets/media/images/products/left.png" alt=""> Профиль
        </a>
        <div class="add container mt-30">
            <h2>Добавление товара</h2>
        </div>
        <?
        if (isset($_POST['add'])) {
            $name_product = $_POST['name_product'];
            $id_collection = $_POST['collection'];
            $id_type = $_POST['type'];
            $id_metal = $_POST['metal'];
            $id_sample = $_POST['sample'];
            $sum_of_inserts = $_POST['sum_of_inserts'];
            $weight_of_inserts = $_POST['weight_of_inserts'];
            $price = $_POST['price'];
            $count = $_POST['count'];

            $flag = true;
            $errors = [
                '<p class="error">Введите данные</p>',
                '<p class="error">Выберите 1 из пунктов </p>',
                '<p class="error">данный товар уже существует</p>',
            ];
        }
        ?>
        <div class="add-section container mt-30">
            <form method="post" name="add" class="add-form-upd" enctype="multipart/form-data">
                <div class="input-file-row">
                    <label class="input-file">
                        <input type="file" name="main_img">
                        <span>Выберите главное фото</span>
                    </label>
                    <div class="input-file-list" id="main-photo-container"></div>
                </div>

                <div class="input-file-row">
                    <label class="input-file">
                        <input type="file" name="additional_img[]" multiple>
                        <span>Выберите дополнительные фото</span>
                    </label>
                    <div class="input-file-list" id="additional-photos-container"></div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                <script src="js/script.js"></script>

                <input type="text" name="name_product" placeholder="Введите название" value="<? if (isset($_POST['add'])) {
                                                                                                    echo $name_product;
                                                                                                } ?>">
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['name_product'])) {
                        $flag = false;
                        echo $errors[0];
                    } else {
                        $sql = "SELECT * FROM `product` WHERE `name_product`='$name_product'";
                        $result = $connect->query($sql)->fetchColumn();
                        if ($result != 0) {
                            $flag = false;
                            echo $errors[2];
                        }
                    }
                }
                ?>
                <select name="collection" id="collection">
                    <option disabled selected value>Выберите коллекцию:</option>
                    <?
                    $sql = "SELECT * FROM `collection`";
                    $result = $connect->query($sql);
                    foreach ($result as $collection) { ?>
                        <option value="<?= $collection['id'] ?>"><?= $collection['name'] ?></option>
                    <? }
                    ?>
                </select>
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['collection'])) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <select name="type" id="type">
                    <option disabled selected value>Выберите тип изделия:</option>
                    <?
                    $sql = "SELECT * FROM `type`";
                    $result = $connect->query($sql);
                    foreach ($result as $type) { ?>
                        <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                    <? }
                    ?>
                </select>
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['type'])) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <select name="metal" id="metal">
                    <option disabled selected value>Выберите металл:</option>
                    <?
                    $sql = "SELECT * FROM `metal`";
                    $result = $connect->query($sql);
                    foreach ($result as $metal) { ?>
                        <option value="<?= $metal['id'] ?>"><?= $metal['name'] ?></option>
                    <? }
                    ?>
                </select>
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['metal'])) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <select name="sample" id="sample">
                    <option disabled selected value>Выберите пробу металла:</option>
                    <?
                    $sql = "SELECT * FROM `metal_sample`";
                    $result = $connect->query($sql);
                    foreach ($result as $metal_sample) { ?>
                        <option value="<?= $metal_sample['id'] ?>"><?= $metal_sample['name'] ?></option>
                    <? }
                    ?>
                </select>
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['sample'])) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <input type="text" name="sum_of_inserts" placeholder="Введите количество вставок" pattern="[0-9]*" title="Только цифры" inputmode="numeric" value="<? if (isset($_POST['add'])) {
                                                                                                                                                                        echo $sum_of_inserts;
                                                                                                                                                                    } ?>">
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['sum_of_inserts'])) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <input type="text" name="weight_of_inserts" placeholder="Введите вес вставок" pattern="[0-9]*" title="Только цифры" inputmode="numeric" value="<? if (isset($_POST['add'])) {
                                                                                                                                                                    echo $weight_of_inserts;
                                                                                                                                                                } ?>">
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['weight_of_inserts'])) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <input type="text" disabled placeholder="Выберите доступные размеры"></input>

                <div class="sizes-change">
                    <?

                    $sql = "SELECT size.name as size_name,size.id as size_id FROM size";
                    // var_dump($sql);
                    $siz = $connect->query($sql);
                    foreach ($siz as $sizes) {
                    ?>
                        <input type="checkbox" name="selected_sizes[]" id="size_<?= $sizes['size_id'] ?>"
                            value="<?= $sizes['size_id'] ?>">
                        <label for="size_<?= $sizes['size_id'] ?>"><?= $sizes['size_name'] ?></label>
                    <? }
                    ?>
                </div>

                <input type="text" name="price" placeholder="Введите стоимость" pattern="[0-9]*" title="Только цифры" inputmode="numeric" value="<? if (isset($_POST['add'])) {
                                                                                                                                                        echo $price;
                                                                                                                                                    } ?>">
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['price'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="text" name="count" placeholder="Введите количество" pattern="[0-9]*" title="Только цифры" inputmode="numeric" value="<? if (isset($_POST['add'])) {
                                                                                                                                                        echo $count;
                                                                                                                                                    } ?>">
                <?
                if (isset($_POST['add'])) {
                    if (empty($_POST['price'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="submit" value="Добавить" name="add" class="btn">
            </form>
            <?
            if (isset($_POST['add'])) {
                if ($flag) {
                    $id = $connect->query("SELECT * FROM `product` ORDER BY `id` DESC")->fetch()['id'];
                    $id++;
                    $path = 'assets/media/images/catalog/product_' . $id;

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    $main_img_path = '';
                    if (!empty($_FILES['main_img']['name'])) {
                        $main_file_name = 'main_' . time() . '_' . $_FILES['main_img']['name'];
                        $main_file = $path . '/' . $main_file_name;
                        move_uploaded_file($_FILES['main_img']['tmp_name'], $main_file);
                        $main_img_path = $main_file;
                    }

                    $additional_img_path = '';
                    if (!empty($_FILES['additional_img']['name'][0])) {
                        $additional_path = $path . '/additional';

                        if (!file_exists($additional_path)) {
                            mkdir($additional_path, 0777, true);
                        }

                        foreach ($_FILES['additional_img']['name'] as $i => $name) {
                            $additional_file_name = time() . '_' . $i . '_' . $name;
                            $additional_file = $additional_path . '/' . $additional_file_name;
                            move_uploaded_file($_FILES['additional_img']['tmp_name'][$i], $additional_file);
                        }
                        $additional_img_path = $additional_path;
                    }

                    $sql = "INSERT INTO `product`(`main_img`, `img`, `name_product`, `id_collection`, `id_type`, `id_metal`, `id_sample`, `sum_of_inserts`, `weight_of_inserts`, `price`, `count`) 
                VALUES ('$main_img_path','$additional_img_path','$name_product','$id_collection','$id_type','$id_metal','$id_sample','$sum_of_inserts','$weight_of_inserts','$price','$count')";
                    var_dump($sql);
                    $result = $connect->query($sql);

                    if (!empty($_POST['selected_sizes'])) {
                        foreach ($_POST['selected_sizes'] as $size_id) {
                            $sql = "SELECT * FROM product ORDER BY id DESC LIMIT 1";
                            $id_prod = $connect->query($sql)->fetch()['id'];
                            $size_id = $size_id;
                            $sql = "INSERT INTO `sizes`(`id_size`, `id_product`) VALUES ('$size_id','$id_prod')";
                            var_dump($sql);
                            $result = $connect->query($sql);
                        }
                    }
                    echo '<script>document.location.href="?page=all_products"</script>';
                }
            }
            ?>
            <a href="?page=profile" class="btn">Назад</a>
        </div>
    <? } else { ?>
        <div class="main">
            <div class="error-page container mt-150">
                <h1 style="font-size: 128px;">403</h1>
                <p>Для пользователей, столкнувшихся с ошибкой 403, <br> можно попробовать следующее:</p>
                <a href="?page=home" class="btn">Вернуться на главную страницу</a>
            </div>
        </div>
    <? }
} else { ?>
    <div class="main">
        <div class="error-page container mt-150">
            <h1 style="font-size: 128px;font-family:'corm';font-weight:500;">403</h1>
            <p>Для пользователей, столкнувшихся с ошибкой 403, <br> можно попробовать следующее:</p>
            <a href="?page=home" class="btn">Вернуться на главную страницу</a>
        </div>
    </div>
<? }
?>