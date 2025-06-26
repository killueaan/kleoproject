<?
if (isset($_SESSION['USER'])) {
    if ($USER['role'] == 2) { ?>
        <a href="?page=profile" class="back container mt-150">
            <img src="assets/media/images/products/left.png" alt=""> Профиль
        </a>
        <div class="orders container mt-30">
            <h2>Заявки на заказы</h2>
        </div>

        <div class="orders-section container mt-75">
            <?
            $sql = "SELECT * FROM orders ORDER BY id DESC";
            $result = $connect->query($sql);
            foreach ($result as $ordAdmin) {
                $id = $ordAdmin['id']; ?>
                <div class="order-block">
                    <div class="content-order">
                        <div class="info-order">
                            <h3>Номер заявки: <?= $ordAdmin['id'] ?></h3>
                            <div class="user-order">
                                <p>Пользователь: <?= $ordAdmin['id_user'] ?></p>
                            </div>
                            <!-- <div class="date-order">
                                <p>Дата создания: 15.01.2025</p>
                            </div> -->
                            <?
                            if ($ordAdmin['status'] == 1) { ?>
                                <div class="status-order">
                                    <p>Статус: В обработке</p>
                                </div>
                            <? } else if ($ordAdmin['status'] == 2) { ?>
                                <div class="status-order">
                                    <p>Статус: <span style="color: orange; font-weight:500;">Принят</span></p>
                                </div>
                            <? } else if ($ordAdmin['status'] == 3) { ?>
                                <div class="status-order">
                                    <p>Статус: <span style="color: green; font-weight:500;">Готов</span></p>
                                </div>
                            <? } else { ?>
                                <div class="status-order">
                                    <p>Статус: <span style="color: red; font-weight:500;">Отклонен</span></p>
                                </div>
                            <? }
                            ?>
                            <div class="order-img">
                                <?
                                $sql = "SELECT product.main_img as main_img, 
                                orders_item.count as count 
                            FROM product 
                            INNER JOIN `orders_item` ON product.id = orders_item.id_product 
                            WHERE orders_item.id_order = " . $ordAdmin['id'];

                                $result = $connect->query($sql)->fetchAll();
                                foreach ($result as $product) {
                                ?>
                                    <div class="dropdown-img">
                                        <img src="<?= $product['main_img'] ?>">
                                        <span class="product-count">×<?= $product['count'] ?></span>
                                    </div>
                                <?
                                }
                                ?>
                            </div>
                        </div>
                        <?
                        if ($ordAdmin['status'] == 1) { ?>
                            <div class="text-order">
                                <div class="hrefs">
                                    <a href="?page=ordersAdmin&OK=<?= $id ?>" class="btn ok">Принять</a>
                                    <a href=" ?page=ordersAdmin&NO=<?= $id ?>" class="btn no">Отклонить</a>
                                </div>
                            </div>
                        <? } else if ($ordAdmin['status'] == 2) { ?>
                            <div class="text-order">
                                <div class="hrefs">
                                    <a href="?page=ordersAdmin&READY=<?= $id ?>" class="btn ready">Заказ готов</a>
                                </div>
                            </div>
                        <? } ?>

                        <?
                        if (isset($_GET['OK'])) {
                            $id = $_GET['OK'];
                            $sql = "UPDATE `orders` SET `status`='2' WHERE `id`='$id'";
                            $result = $connect->query($sql);
                            echo '<script>document.location.href="?page=ordersAdmin"</script>';
                        }
                        ?>
                        <?
                        if (isset($_GET['READY'])) {
                            $id = $_GET['READY'];
                            $sql = "UPDATE `orders` SET `status`='3' WHERE `id`='$id'";
                            $result = $connect->query($sql);
                            echo '<script>document.location.href="?page=ordersAdmin"</script>';
                        }
                        ?>
                        <?
                        if (isset($_GET['NO'])) {
                            $id = $_GET['NO'];
                            $sql = "UPDATE `orders` SET `status`='4' WHERE `id`='$id'";
                            $result = $connect->query($sql);
                            echo '<script>document.location.href="?page=ordersAdmin"</script>';
                        }
                        ?>

                    </div>
                </div>
            <? }
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