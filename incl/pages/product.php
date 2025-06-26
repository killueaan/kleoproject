<?
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `product` WHERE `id`='$id'";
    $result = $connect->query($sql)->fetch();

    if ($result) {
        $main_img = $result['main_img'];
        $additional_path = dirname($main_img) . '/additional';
        $additional_imgs = [];

        if (is_dir($additional_path)) {
            $additional_imgs = glob($additional_path . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        }

?>
        <?
        if ($USER['role'] == 2) { ?>
            <a href="?page=all_products" class="back container mt-150">
                <img src="assets/media/images/products/left.png" alt=""> Все товары
            </a>
        <? } else { ?>
            <a href="?page=catalog" class="back container mt-150">
                <img src="assets/media/images/products/left.png" alt=""> В каталог
            </a>
        <? }
        ?>
        <div class="product-page container mt-30">
            <div class="pp-images">
                <div class="additional-images">
                    <div class="thumbnails">
                        <div class="thumbnail active" data-image="/<?= $result['main_img'] ?>" onclick="slider('<?= $main_img ?>')">
                            <img src="/<?= $result['main_img'] ?>">
                        </div>
                        <?php foreach ($additional_imgs as $img): ?>
                            <div class="thumbnail" data-image="/<?= $img ?>" onclick="slider('<?= $img ?>')">
                                <img src="/<?= $img ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="main-img">
                    <img src="/<?= $result['main_img'] ?>" alt="<?= $result['name_product'] ?>" id="main-preview" class="ras">
                </div>
            </div>
            <script>
                function slider(image) {
                    document.querySelector(".ras").src = image;
                }
            </script>
            <div class="pp-info">
                <div class="pp-name">
                    <?
                    $id_cat = $result['id_collection'];
                    $sql = "SELECT * FROM `collection` WHERE id=$id_cat";
                    $collection = $connect->query($sql)->fetch();
                    ?>
                    <p>Коллекция <?= $collection['name'] ?></p>
                    <?
                    $id_typ = $result['id_type'];
                    $sql = "SELECT * FROM `type` WHERE id=$id_typ";
                    $type = $connect->query($sql)->fetch();
                    ?>
                    <h3><?= $type['name'] ?> из белого золота «<?= $result['name_product'] ?>»</h3>
                </div>
                <div class="s-p">
                    <div class="pp-size">
                        <h5>Размер</h5>
                        <div class="pp-sizes">
                            <?
                            $sql = "SELECT * FROM product WHERE id=$id";
                            $id_prod = $connect->query($sql)->fetch()['id'];
                            $sql = "SELECT size.name as size_name,size.id as size_id FROM size 
                            INNER JOIN sizes ON size.id=sizes.id_size WHERE id_product=$id_prod";
                            // var_dump($sql);
                            $siz = $connect->query($sql)->fetchAll();
                            if (empty($siz)) { ?>
                                <script>
                                    let block_size = document.querySelector('.pp-size').style.display = 'none';
                                </script>
                                <? } else {
                                foreach ($siz as $sizes) { ?>
                                    <input type="radio" name="selected_size" id="size_<?= $sizes['size_id'] ?>" value="<?= $sizes['size_id'] ?>">
                                    <label for="size_<?= $sizes['size_id'] ?>"><?= $sizes['size_name'] ?></label>
                            <? }
                            } ?>
                        </div>
                    </div>
                    <div class="pp-proba">
                        <h5>Проба</h5>
                        <?
                        $id_sample = $result['id_sample'];
                        $sql = "SELECT * FROM `metal_sample` WHERE id=$id_sample";
                        $sample = $connect->query($sql)->fetch();
                        ?>
                        <div class="proba">
                            <p><?= $sample['name'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="pp-price">
                    <h4><? echo number_format($result['price'], 0, '.', ' '); ?> ₽</h4>
                </div>
                <div class="href">
                    <?
                    if (isset($_SESSION['USER'])) {
                        if ($USER['role'] == 2) { ?>
                            <a href="?page=update&id=<?= $id ?>" class="btn">Редактировать</a>
                            <button class="btn delete-btn" data-id="<?= $id ?>">Удалить</button>
                        <? } else if ($USER['role'] == 1) { ?>
                            <?
                            if ($result['count'] == 0) { ?>
                                <h4>Нет в наличии</h4>
                                <script>
                                    let size = document.querySelector('.pp-size');
                                    size.style.display = 'none';
                                </script>
                            <? } else { ?>
                                <a href="?page=product&id=<?= $id ?>&toCart" onclick="return validateSizeSelection()" class="toCart btn">Добавить в корзину</a>
                    <? }
                        }
                    } ?>

                    <? if ($USER['role'] < 1) {
                        if ($result['count'] == 0) { ?>
                            <h4>Нет в наличии</h4>
                            <script>
                                let size = document.querySelector('.pp-size');
                                size.style.display = 'none';
                            </script>
                    <? }
                    }
                    ?>
                    <div class="modal-container product-delete">
                        <div class="modal content-prod-del  mt-150 ">
                            <h2>Вы хотите удалить товар
                                Кольцо из белого золота «<?= $result['name_product'] ?>»?</h2>
                            <div class="hrefs">
                                <a href="?page=product&id=<?= $id ?>&del=<?= $id ?>" class="btn confirm-delete">Да, удалить</a>
                                <a href="?page=product&id=<?= $id ?>" class="btn cancel-delete">Нет</a>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteBtns = document.querySelectorAll('.delete-btn');
                            const deleteModal = document.querySelector('.modal-container');
                            const confirmDeleteBtn = document.querySelector('.confirm-delete');
                            const cancelDeleteBtn = document.querySelector('.cancel-delete');

                            if (deleteBtns.length > 0) {
                                deleteBtns.forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        const productId = this.getAttribute('data-id');
                                        deleteModal.style.display = 'flex';

                                    });
                                });
                            }
                        });
                    </script>
                    <?
                    if (isset($_GET['del'])) {
                        $id = $_GET['del'];
                        $sql = "DELETE FROM `product` WHERE `id`='$id'";
                        // var_dump($sql);
                        $result = $connect->query($sql);
                        $sql = "DELETE FROM `sizes` WHERE `id_product`='$id'";
                        $result = $connect->query($sql);
                        $sql = "DELETE FROM `cart_item` WHERE `id_product`='$id'";
                        $result = $connect->query($sql);
                        echo '<script>document.location.href="?page=all_products"</script>';
                    }
                    ?>

                    <script>
                        function validateSizeSelection() {
                            const selectedSize = document.querySelector('input[name="selected_size"]:checked');

                            window.location.href = `?page=product&id=<?= $id ?>&toCart&size_id=${selectedSize.value}`;
                            return false;
                        }
                    </script>
                    <main>
                        <div class="modal-container product-added">
                            <div class="modal mt-150">
                                <div class="modal-content content-prod-add">
                                    <h2>Товар добавлен в корзину</h2>
                                    <div class="hrefs">
                                        <a href="?page=cart" class="btn">Перейти в корзину</a>
                                        <a href="?page=product&id=<?= $id ?>" class="btn">Продолжить покупки</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <hr>
                <div class="characters">
                    <h3>Подробные характеристики</h3>
                    <div class="characters-info">
                        <p>тип изделия: <?= $type['name'] ?></p>
                        <?
                        $id_metal = $result['id_metal'];
                        $sql = "SELECT * FROM `metal` WHERE `id`='$id_metal'";
                        $metal = $connect->query($sql)->fetch();
                        ?>
                        <p>металл: <?= $metal['name'] ?></p>
                        <?
                        $id_sample = $result['id_sample'];
                        $sql = "SELECT * FROM `metal_sample` WHERE `id`='$id_sample'";
                        $metal = $connect->query($sql)->fetch();
                        ?>
                        <p>проба металла: <?= $sample['name'] ?></p>
                        <p>количество вставок: <?= $result['sum_of_inserts'] ?></p>
                        <p>вес вставок: <?= $result['weight_of_inserts'] ?> карат</p>
                    </div>
                </div>
            </div>
        </div>
        <?
        if (isset($_GET['toCart'])) {
            $id_user = $USER['id'];
            $selected_size_id = isset($_GET['size_id']) ? $_GET['size_id'] : 0;

            $sql = "SELECT COUNT(*) as size_count FROM sizes WHERE id_product=$id";
            $has_sizes = $connect->query($sql)->fetch()['size_count'] > 0;

            if ($has_sizes && empty($selected_size_id)) {
                echo '<script>alert("Пожалуйста, выберите размер перед добавлением в корзину");</script>';
            } else {
                $sql = "SELECT cart_item.count as count FROM cart_item 
                        INNER JOIN cart on cart_item.id_cart = cart.id 
                        WHERE id_user=$id_user AND cart_item.id_product=$id AND cart_item.id_size='$selected_size_id'";
                // var_dump($sql);
                $productCount = $connect->query($sql)->fetch();

                $sql = "SELECT * FROM product WHERE id=$id";
                $countP = $connect->query($sql)->fetch()['count'];

                if ($productCount != NULL) {
                    $productCount = $productCount['count'] + 1;
                    if ($productCount <= $countP) {
                        $sql = "UPDATE `cart_item` SET `count`='$productCount' 
                                WHERE `id_cart`='$id_cart' AND `id_product`='$id' AND cart_item.id_size='$selected_size_id'";
                        $result = $connect->query($sql);
                    }
                } else {
                    if ($productCount <= $countP) {
                        $sql = "INSERT INTO `cart_item`(`id_cart`, `id_product`, `id_size`, `count`) 
                            VALUES ('$id_cart','$id','$selected_size_id','1')";
                        $result = $connect->query($sql);
                    }
                }
                echo '<script>
             document.addEventListener("DOMContentLoaded", function() {
            const modal = document.querySelector(".modal-container.product-added");
            modal.style.display = "flex";
            setTimeout(() => {
            modal.style.display = "none";
            }, 3000);
            });
            </script>';
            }
        }

        ?>
<? }
} ?>