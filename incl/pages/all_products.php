<?
if (isset($_SESSION['USER'])) {
    if ($USER['role'] == 2) { ?>
        <div class="main">
            <a href="?page=profile" class="back container mt-150">
                <img src="assets/media/images/products/left.png" alt=""> Профиль
            </a>
            <div class="catalog container mt-30">
                <h2>Все товары</h2>

                <form action="" method="post" class="form-search" name="form-serch">
                    <input type="text" name="name" placeholder="поиск">
                    <input type="submit" class="search-btn" name="form-search" value="">
                </form>

            </div>
            <?
            if (isset($_POST['form-search'])) {

                $text = $_POST['name'];
                $dop_sql = "WHERE `name_product` LIKE '%" . $text . "%' OR id_type IN (SELECT id FROM `type` WHERE `name` LIKE '%" . $text . "%') $sql_cat ";

                if (empty($text)) {
                    echo '<script>document.location.href="?page=all_products"</script>';
                }

                $sql = "SELECT * FROM `product` $dop_sql";
                $res = $connect->query($sql)->rowCount();
                if ($res == 0) {
                    echo "<p class='error container mt-30'>Товара с названием '$text' не существует.</p>";
                }
            } else {
                $dop_sql = "";
            }
            ?>
            <div class="catalog-section container mt-75">
                <?
                $sql = "SELECT * FROM `product`";
                $sql .= "$dop_sql";

                $result = $connect->query($sql);
                foreach ($result as $product) {
                    $id = $product['id'];
                ?>
                    <div class="product-card">
                        <div class="img-pr">
                            <img src="<?= $product['main_img'] ?>" alt="">
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
                                ?>
                                <h3><?= $type['name'] ?> из белого золота «<?= $product['name_product'] ?>»</h3>
                                <h4><?= $product['count'] ?> шт.</h4>
                                <?
                                if ($product['count'] < 5) { ?>
                                    <div class="count-low">
                                        <p style="color: red; font-weight:500; ">Внимание! Требуется новое поступление</p>
                                    </div>
                                <? }
                                ?>
                            </div>
                            <a href="?page=product&id=<?= $id ?>" class="btn">Подробнее</a>
                        </div>
                    </div>
                <? }
                ?>
            </div>
        </div>
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