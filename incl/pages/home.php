<div class="bg">

    <!-- banner start -->
    <div class="banner container">
        <div class="banner-content">
            <h1>Украшения, которые прослужат вам всю жизнь</h1>
            <p>Наша цель — сохранить семейные традиции путем создания высококачественных ювелирных изделий.</p>
            <a href="?page=catalog" class="btnn">Перейти в каталог</a>
        </div>
    </div>
    <!-- banner end -->
</div>

<!-- types start -->
<div class="types container mt-150">
    <div class="t-block t1">
        <a href="?page=catalog&type=4">
            <img src="assets/media/images/types/1.png" alt="">
        </a>
        <h4 class="t-block-title">Браслеты</h4>
    </div>
    <div class="t-block t2">
        <a href="?page=catalog&type=1">
            <img src="assets/media/images/types/2.png" alt="">
        </a>
        <h4 class="t-block-title">Кольца</h4>
    </div>
    <div class="t-block t3">
        <a href="?page=catalog&type=2">
            <img src="assets/media/images/types/3.png" alt="">
        </a>
        <h4 class="t-block-title">Серьги</h4>
    </div>
</div>
<!-- types end -->
<script>
    let t_blocks = document.querySelectorAll('.t-block');
    t_blocks.forEach(block => {
        let img = block.querySelector('img');
        let title = block.querySelector('.t-block-title');
        title.style.display = 'none';
        block.addEventListener('mouseenter', function() {
            img.style.filter = 'brightness(60%)';
            title.style.display = 'block';
        });

        block.addEventListener('mouseleave', function() {
            img.style.filter = 'brightness(100%)';
            title.style.display = 'none';
            img.style.transition = '0.5s';
        });
    });
</script>

<!-- mini-catalog start -->
<div class="catalog container mt-150">
    <h2>Новинки сезона</h2>
</div>
<div class="catalog-section container mt-75">
    <?
    $sql = "SELECT * FROM `product` ORDER BY id DESC LIMIT 4";
    $result = $connect->query($sql);
    foreach ($result as $product) {
        $id = $product['id']; ?>
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
                    <h3><?= $type['name'] ?> из белого золота</h3>
                    <h4><? echo number_format($product['price'], 0, '.', ' '); ?> ₽</h4>
                </div>
                <a href="?page=product&id=<?= $id ?>" class="btn">Подробнее</a>
            </div>
        </div>
    <? }
    ?>
</div>
<!-- mini-catalog end -->

<!-- collection start -->
<div class="collection container mt-150">
    <div class="collection-content">
        <h2>Коллекция “BALANCE”</h2>
        <p>Визуальную динамику создают солитеры c гало и разомкнутые кольца, интерпретирующие классический стиль Toi
            et Moi, пусеты и акцентные серьги. Сияние и внушительная каратность соединились в гармонии. Драгоценные
            камни находятся в постоянном диалоге, они дополняют и уравновешивают друг друга, многократно усиливая
            дисперсию. <br><br>
            Мы намеренно отказываемся от ювелирной «сюжетности», чувствуя потребность в гармонии. Вместо
            нагромождения смыслов в коллекции BALANCE — почти «обнаженные» подлинные бриллианты в тонкой оправе
            из белого золота.</p>
        <a href="?page=catalog&collection=3" class="btnn">Перейти в каталог</a>
    </div>
    <div class="slider">
        <div class="slider-body">
            <div class="slider-content">
                <div class="slider-item active">
                    <img src="assets/media/images/collection/1.png" alt="">
                </div>
                <div class="slider-item">
                    <img src="assets/media/images/collection/2.png" alt="">
                </div>
                <div class="slider-item">
                    <img src="assets/media/images/collection/3.jpeg" alt="">
                </div>
                <div class="slider-item">
                    <img src="assets/media/images/collection/4.jpeg" alt="">
                </div>
            </div>
        </div>
        <div class="slider-nav">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
    <script src="js/slider.js"></script>
</div>
<!-- collection end -->