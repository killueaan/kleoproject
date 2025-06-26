<?
if (isset($_SESSION['USER'])) { ?>
    <div class="basket-section container mt-150">
        <h2>Корзина</h2>
    </div>
    <div class="basket container">
        <div class="products">

            <?
            $sql = "SELECT * FROM cart_item WHERE id_cart='$id_cart'";
            $cart_items = $connect->query($sql)->fetchAll();
            $sql = "SELECT * FROM cart WHERE id_user='$id_user'";
            $overPrice = $connect->query($sql)->fetch();
            $cart_price = 0;
            $sql = "SELECT SUM(count) as sum FROM cart_item WHERE id_cart=$id_cart";
            $countAll = $connect->query($sql)->fetch()['sum'];
            $prod_count = 0;

            foreach ($cart_items as $cart_item) {
                $id_product = $cart_item['id_product'];
                $sql = "SELECT * FROM product WHERE id=$id_product";
                $product = $connect->query($sql)->fetch();
                $cart_price = $cart_price + ($product['price'] * $cart_item['count']);
                $prod_count = ($product['price'] * $cart_item['count']);
            ?>
                <div class="p-block">
                    <div class="img-p">
                        <img src="<?= $product['main_img'] ?>" alt="">
                    </div>
                    <?
                    $id_typ = $product['id_type'];
                    $sql = "SELECT * FROM `type` WHERE id='$id_typ'";
                    $type = $connect->query($sql)->fetch();
                    ?>
                    <div class="info-p">
                        <h3><?= $type['name'] ?> из белого золота “<?= $product['name_product'] ?>”</h3>
                        <?
                        $idSize = $cart_item['id_size'];
                        $sql = "SELECT size.name as size_name FROM cart_item INNER JOIN `size` ON size.id=$idSize WHERE cart_item.id_product=$id_product";
                        $result = $connect->query($sql)->fetch();
                        if (empty($result)) { ?>
                            <p>Размер отсутствует</p>
                        <? } else { ?>
                            <p><?= $result['size_name'] ?> размер</p>
                        <? } ?>
                        <div class="count">

                            <a href="?page=cart&minus=<?= $id_product ?>&size_id=<?= $idSize ?>">-</a>
                            <?
                            $sql = "SELECT * FROM `product` WHERE `id`='$id_product'";
                            $available_count = $connect->query($sql)->fetch()['count'];
                            if ($cart_item['count'] > $available_count) {
                                $new_count = min($cart_item['count'], $available_count);
                                $sql = "UPDATE `cart_item` SET `count` = '$new_count'  WHERE `id_product` = '$id_product' AND `id_size` = '$id_size'";
                                $result = $connect->query($sql);
                                $cart_item['count'] = $new_count;
                            }
                            ?>
                            <p><?= $cart_item['count'] ?></p>
                            <a href="?page=cart&plus=<?= $id_product ?>&size_id=<?= $idSize ?>">+</a>

                        </div>
                        <div class="sum">
                            <p><? echo number_format($prod_count, 0, '.', ' '); ?> ₽</p>
                        </div>
                    </div>

                    <a href="?page=cart&id=<?= $cart_item['id_product'] ?>&del=<?= $cart_item['id_product'] ?>&size_id=<?= $idSize ?>" class="delete-bas">
                        <img src="assets/media/images/feedback/X.png" alt="">
                    </a>
                    <?
                    if (isset($_GET['del'])) {
                        $product_id = $_GET['del'];
                        $size_id = $_GET['size_id'];

                        $sql = "DELETE FROM `cart_item` WHERE `id_product`='$product_id' AND `id_cart`='$id_cart' AND `id_size`='$size_id'";
                        // var_dump($sql);
                        $result = $connect->query($sql)->fetch();
                        echo '<script>document.location.href="?page=cart"</script>';
                    }
                    ?>
                </div>
            <? }
            ?>
        </div>
        <?
        if ($cart_item['count'] > 0) { ?>
            <div class="amount">
                <h2>Итого: <? echo number_format($cart_price, 0, '.', ' '); ?> ₽</h2>
                <p>Количество товаров: <?= $countAll ?></p>
                <a href="?page=cart&toOrder" class="btn">Перейти к оформлению</a>
            </div>
        <? } else { ?>
            <div class="empty mt-75">
                <h3>Вы не добавили товары в корзину</h3>
                <p>Ознакомьтесь с нашим <a href="?page=catalog">ассортиментом</a> или перейдите к вашим <a href="?page=orders_user">заказам</a></p>
            </div>
        <? }
        ?>
        <?
        if (isset($_GET['minus'])) {
            $product_id = $_GET['minus'];
            $size_id = $_GET['size_id'];

            $sql = "SELECT * FROM cart_item WHERE `id_cart`='$id_cart' 
                            AND `id_product`='$product_id' AND `id_size`='$size_id'";
            $count = $connect->query($sql)->fetch()['count'];

            if ($count <= 1) {
                $sql = "DELETE FROM `cart_item` WHERE `id_product`='$product_id' 
                        AND `id_cart`='$id_cart' AND id_size=$size_id";
                $result = $connect->query($sql);
            } else {
                $count = $count - 1;
                $sql = "UPDATE `cart_item` SET `count`='$count' WHERE `id_product`='$product_id' 
                        AND `id_cart`='$id_cart' AND id_size=$size_id";
                $result = $connect->query($sql);
            }
            echo '<script>document.location.href="?page=cart"</script>';
        }
        ?>
        <?
        if (isset($_GET['plus'])) {
            $product_id = $_GET['plus'];
            $size_id = $_GET['size_id'];

            $sql = "SELECT * FROM cart_item WHERE `id_cart`='$id_cart' 
            AND `id_product`='$product_id' AND id_size=$size_id";
            $count = $connect->query($sql)->fetch()['count'];

            $sql = "SELECT * FROM `product` WHERE `id`=$product_id";
            $countP = $connect->query($sql)->fetch()['count'];

            $count++;
            if ($count <= $countP) {
                $sql = "UPDATE `cart_item` SET `count`='$count' WHERE  `id_product`='$product_id' 
                AND `id_cart`='$id_cart'AND id_size=$size_id";
                // var_dump($sql);
                $result = $connect->query($sql);
            }
            echo '<script>document.location.href="?page=cart"</script>';
        }
        ?>
        <?
        if (isset($_GET['toOrder'])) {
            $sql = "INSERT INTO `orders`(`id_user`, `price`, `status`) 
        VALUES ('$id_user','$cart_price','1')";
            // var_dump($sql);
            $result = $connect->query($sql);
            $sql = "SELECT `id` FROM `orders` ORDER BY id DESC LIMIT 1";
            // var_dump($sql);
            $id_order = $connect->query($sql)->fetch()['id'];
            // var_dump($id_order);
            foreach ($cart_items as $cart_item) {
                $id_product = $cart_item['id_product'];
                $count = $cart_item['count'];
                $id_size = $cart_item['id_size'];

                $sql = "INSERT INTO `orders_item`(`id_cart`, `id_order`, `count`,`id_product`, `id_size`) 
            VALUES ('$id_cart','$id_order','$count','$id_product','$id_size')";
                $connect->query($sql);

                $sql = "DELETE FROM `cart_item` WHERE `id_product`='$id_product' AND `id_cart`='$id_cart'";
                // var_dump($sql);
                $result = $connect->query($sql);

                $sql = "SELECT count FROM product WHERE id=$id_product";
                $count_product = $connect->query($sql)->fetch()['count'];

                $new_count = $count_product - $count;
                if ($new_count < 0) $new_count = 0;

                $sql = "UPDATE `product` SET `count`='$new_count' WHERE `id`='$id_product'";
                $result = $connect->query($sql);
                echo '<script>document.location.href="?page=cart"</script>';
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
?>