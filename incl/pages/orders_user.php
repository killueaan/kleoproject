<?
if (isset($_SESSION['USER'])) { ?>
    <a href="?page=profile" class="back container mt-150">
        <img src="assets/media/images/products/left.png" alt=""> Профиль
    </a>
    <div class="orders-user container mt-30">
        <h2>Мои заказы</h2>
    </div>
    <div class="orders-section container mt-75">
        <?

        $sql = "SELECT * FROM orders WHERE id_user=$id_user ORDER BY id DESC";
        $result = $connect->query($sql);
        foreach ($result as $order) { ?>
            <div class="order-block">
                <div class="content-order">
                    <div class="info-order">
                        <h3>Номер заказа: <?= $order['id'] ?></h3>
                        <div class="order-img">
                            <?
                            $sql = "SELECT product.main_img as main_img, 
                                orders_item.count as count 
                            FROM product 
                            INNER JOIN `orders_item` ON product.id = orders_item.id_product 
                            WHERE orders_item.id_order = " . $order['id'];

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
                        <!-- <script src="js/orders_user.js"></script> -->
                    </div>
                    <?
                    if ($order['status'] == 1) { ?>
                        <div class="text-order">
                            <h4>В ожидании подтверждения</h4>
                        </div>
                    <? } else if ($order['status'] == 2) { ?>
                        <div class="text-order status-2">
                            <h4>Заказ в пути</h4>
                        </div>
                    <? } else if ($order['status'] == 3) { ?>
                        <div class="text-order status-3">
                            <h4>Заказ готов к получению</h4>
                        </div>
                    <? } else { ?>
                        <div class="text-order status-4">
                            <h4>Заказ отменен / отклонен</h4>
                        </div>
                    <? }
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
?>