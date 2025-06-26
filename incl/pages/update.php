<?
if (isset($_SESSION['USER'])) {
    if ($USER['role'] == 2) { ?>
        <div class="bgr">
            <div class="update container mt-150">
                <h2>Редактирование товара</h2>
            </div>
            <?
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM `product` WHERE `id`='$id'";
                $product = $connect->query($sql)->fetch();

                if ($product) {
                    $old_img = $product['main_img'];
                    $old_path = dirname($old_img);
                    $additional_path = $old_path . '/additional';
                    $additional_imgs = [];

                    if (is_dir($additional_path)) {
                        $additional_imgs = glob($additional_path . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    }
            ?>
                    <div class="update-section container mt-30">
                        <?php
                        if (isset($_POST['update'])) {
                            $name_product = $_POST['name_product'];
                            $id_collection = $_POST['collection'];
                            $id_type = $_POST['type'];
                            $id_metal = $_POST['metal'];
                            $id_sample = $_POST['sample'];
                            $sum_of_inserts = $_POST['sum_of_inserts'];
                            $weight_of_inserts = $_POST['weight_of_inserts'];
                            // $id_sizes = $_POST['sizes'];
                            $price = $_POST['price'];
                            $count = $_POST['count'];

                            $flag = true;
                            $errors = [
                                '<p class="error">Введите данные</p>',
                                '<p class="error">Выберите 1 из пунктов</p>',
                            ];
                        }
                        ?>
                        <form action="" method="post" name="update" class="add-form-upd" enctype="multipart/form-data">
                            <div class="input-file-row">
                                <label class="input-file">
                                    <input type="file" name="main_img">
                                    <span>Выберите главное фото</span>
                                </label>
                                <div class="input-file-list" id="main-photo-container">
                                    <?php if ($old_img && file_exists($old_img)): ?>
                                        <div class="input-file-list-item main-photo">
                                            <img src="/<?= $old_img ?>" alt="Главное фото" style="max-width: 200px;">
                                            <span class="main-photo-label">(Главное)</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="input-file-row">
                                <label class="input-file">
                                    <input type="file" name="additional_img[]" multiple>
                                    <span>Выберите дополнительные фото</span>
                                </label>
                                <div class="input-file-list" id="additional-photos-container">
                                    <?php if (!empty($additional_imgs)): ?>
                                        <div class="photos-grid">
                                            <?php foreach ($additional_imgs as $img): ?>
                                                <div class="photo-item">
                                                    <img src="/<?= $img ?>" alt="Доп. фото" style="max-width: 150px;">
                                                    <div class="photo-actions">
                                                        <label>
                                                            <input type="checkbox" name="delete_photos[]" value="<?= basename($img) ?>"> Удалить
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                            <!-- <script src="js/script.js"></script> -->

                            <input type="text" name="name_product" placeholder="Введите название" value="<?= $product['name_product'] ?? '' ?>">
                            <?
                            if (isset($_POST['update'])) {
                                if (empty($_POST['name_product'])) {
                                    $flag = false;
                                    echo $errors[0];
                                }
                            }
                            ?>
                            <select name="collection" id="collection">
                                <option disabled value>Выберите коллекцию:</option>
                                <?
                                $sql = "SELECT * FROM `collection`";
                                $result = $connect->query($sql);
                                foreach ($result as $collection) {
                                    $selected = ($collection['id'] == $product['id_collection']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $collection['id'] ?>" <?= $selected ?>><?= $collection['name'] ?></option>
                                <? }
                                ?>
                            </select>

                            <select name="type" id="type">
                                <option disabled value>Выберите тип изделия:</option>
                                <?
                                $sql = "SELECT * FROM `type`";
                                $result = $connect->query($sql);
                                foreach ($result as $type) {
                                    $selected = ($type['id'] == $product['id_type']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $type['id'] ?>" <?= $selected ?>><?= $type['name'] ?></option>
                                <? }
                                ?>
                            </select>

                            <select name="metal" id="metal">
                                <option disabled value>Выберите металл:</option>
                                <?
                                $sql = "SELECT * FROM `metal`";
                                $result = $connect->query($sql);
                                foreach ($result as $metal) {
                                    $selected = ($metal['id'] == $product['id_metal']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $metal['id'] ?>" <?= $selected ?>><?= $metal['name'] ?></option>
                                <? }
                                ?>
                            </select>

                            <select name="sample" id="sample">
                                <option disabled value>Выберите пробу металла:</option>
                                <?
                                $sql = "SELECT * FROM `metal_sample`";
                                $result = $connect->query($sql);
                                foreach ($result as $metal_sample) {
                                    $selected = ($metal_sample['id'] == $product['id_sample']) ? 'selected' : '';  ?>
                                    <option value="<?= $metal_sample['id'] ?>" <?= $selected ?>><?= $metal_sample['name'] ?></option>
                                <? }
                                ?>
                            </select>

                            <input type="text" name="sum_of_inserts" placeholder="Введите количество вставок" value="<?= $product['sum_of_inserts'] ?? '' ?>">
                            <?
                            if (isset($_POST['update'])) {
                                if (empty($_POST['sum_of_inserts'])) {
                                    $flag = false;
                                    echo $errors[0];
                                }
                            }
                            ?>
                            <input type="text" name="weight_of_inserts" placeholder="Введите вес вставок" value="<?= $product['weight_of_inserts'] ?? '' ?>">
                            <?
                            if (isset($_POST['update'])) {
                                if (empty($_POST['weight_of_inserts'])) {
                                    $flag = false;
                                    echo $errors[0];
                                }
                            }
                            ?>
                            <input type="text" disabled placeholder="Выберите доступные размеры"></input>

                            <div class="sizes-change">
                                <?
                                $sql = "SELECT size.name as size_name, size.id as size_id FROM size";
                                $siz = $connect->query($sql);

                                $existing_sizes_sql = "SELECT id_size FROM sizes WHERE id_product='$id'";
                                $existing_sizes_result = $connect->query($existing_sizes_sql);
                                $existing_sizes = array_column($existing_sizes_result->fetchAll(), 'id_size');

                                foreach ($siz as $sizes) {
                                    $is_checked = in_array($sizes['size_id'], $existing_sizes) ? 'checked' : '';
                                ?>
                                    <input type="checkbox" name="selected_sizes[]" id="size_<?= $sizes['size_id'] ?>"
                                        value="<?= $sizes['size_id'] ?>" <?= $is_checked ?>>
                                    <label for="size_<?= $sizes['size_id'] ?>"><?= $sizes['size_name'] ?></label>
                                <? }
                                ?>
                            </div>

                            <input type="text" name="price" placeholder="Введите стоимость" value="<?= $product['price'] ?? '' ?>">
                            <?
                            if (isset($_POST['update'])) {
                                if (empty($_POST['price'])) {
                                    $flag = false;
                                    echo $errors[0];
                                }
                            }
                            ?>
                            <input type="text" name="count" placeholder="Введите количество" value="<?= $product['count'] ?? '' ?>">
                            <?
                            if (isset($_POST['update'])) {
                                if (empty($_POST['price'])) {
                                    $flag = false;
                                    echo $errors[0];
                                }
                            }
                            ?>
                            <input type="submit" value="Обновить" name="update" class="btn">
                        </form>


                        <?php
                        if (isset($_POST['update'])) {
                            if ($flag) {
                                $main_img_path = $old_img;
                                if (!empty($_FILES['main_img']['name'])) {
                                    if (file_exists($old_img)) {
                                        unlink($old_img);
                                    }

                                    $main_file_name = 'main_' . time() . '_' . $_FILES['main_img']['name'];
                                    $main_file = $old_path . '/' . $main_file_name;
                                    move_uploaded_file($_FILES['main_img']['tmp_name'], $main_file);
                                    $main_img_path = $main_file;
                                }

                                if (!empty($_FILES['additional_img']['name'][0])) {
                                    if (!file_exists($additional_path)) {
                                        mkdir($additional_path, 0777, true);
                                    }

                                    foreach ($_FILES['additional_img']['name'] as $i => $name) {
                                        $additional_file_name = time() . '_' . $i . '_' . $name;
                                        $additional_file = $additional_path . '/' . $additional_file_name;
                                        move_uploaded_file($_FILES['additional_img']['tmp_name'][$i], $additional_file);
                                    }
                                }

                                if (!empty($_POST['delete_photos'])) {
                                    foreach ($_POST['delete_photos'] as $photo_name) {
                                        $photo_path = $additional_path . '/' . $photo_name;
                                        if (file_exists($photo_path)) {
                                            unlink($photo_path);
                                        }
                                    }
                                }

                                $sql = "UPDATE `product` SET 
                                    `main_img`='$main_img_path',
                                    `img`='$additional_img_path',
                                    `name_product`='$name_product',
                                    `id_collection`='$id_collection',
                                    `id_type`='$id_type',
                                    `id_metal`='$id_metal',
                                    `id_sample`='$id_sample',
                                    `sum_of_inserts`='$sum_of_inserts',
                                    `weight_of_inserts`='$weight_of_inserts',
                                    `price`='$price',
                                    `count`='$count' 
                                    WHERE `id`='$id'";
                                // var_dump($sql);
                                $result = $connect->query($sql);

                                $sql = "SELECT id_size FROM sizes WHERE id_product='$id'";
                                $existing_sizes_result = $connect->query($sql);
                                $existing_sizes = array_column($existing_sizes_result->fetchAll(), 'id_size');

                                if (!empty($_POST['selected_sizes'])) {
                                    $selected_sizes = array_map('intval', $_POST['selected_sizes']);

                                    $sizes_to_add = array_diff($selected_sizes, $existing_sizes);
                                    $sizes_to_remove = array_diff($existing_sizes, $selected_sizes);

                                    if (!empty($sizes_to_add)) {
                                        $values = [];
                                        foreach ($sizes_to_add as $size_id) {
                                            $values[] = "('$size_id', '$id')";
                                        }
                                        $sql = "INSERT INTO `sizes` (`id_size`, `id_product`) VALUES " . implode(',', $values);
                                        $connect->query($sql);
                                    }

                                    if (!empty($sizes_to_remove)) {
                                        $sql = "DELETE FROM `sizes` WHERE id_product='$id' AND id_size IN (" . implode(',', $sizes_to_remove) . ")";
                                        $connect->query($sql);
                                        $sql = "DELETE FROM `cart_item` WHERE `id_product`='$id' AND id_size IN (" . implode(',', $sizes_to_remove) . ")";
                                        $connect->query($sql);
                                    }
                                }

                                echo '<script>document.location.href="?page=product&id=' . $id . '"</script>';
                            }
                        }
                        ?>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('input[name="main_img"]').change(function() {
                                if (this.files && this.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('#main-photo-container').html(`
                                    <div class="new-photo-preview">
                                        <img src="${e.target.result}" style="max-width: 200px;">
                                        <div>Новое главное фото</div>
                                    </div>
                                `);
                                    }
                                    reader.readAsDataURL(this.files[0]);
                                }
                            });

                            $('input[name="additional_img[]"]').change(function() {
                                var container = $('#additional-photos-container');
                                if ($('.photos-grid').length) {
                                    container.prepend('<h4>Новые дополнительные фото:</h4>');
                                }

                                for (var i = 0; i < this.files.length; i++) {
                                    var reader = new FileReader();
                                    reader.onload = (function(file) {
                                        return function(e) {
                                            container.append(`
                                        <div class="new-photo-preview">
                                            <img src="${e.target.result}" style="max-width: 150px;">
                                            <div>${file.name}</div>
                                        </div>
                                    `);
                                        };
                                    })(this.files[i]);
                                    reader.readAsDataURL(this.files[i]);
                                }
                            });
                        });
                    </script>
            <?php
                }
            }
            ?>
        </div>
    <? } else { ?>
        <div class="main">
            <div class="error-page container mt-150">
                <h1 style="font-size: 128px;font-family:'corm';font-weight:500;">403</h1>
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