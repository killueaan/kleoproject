    <header>

        <div class="header container">
            <input type="checkbox" id="burger">
            <label for="burger">
                <span class="icon"></span>
            </label>
            <div class="menu">
                <?php if (!isset($_SESSION['USER']) || $USER['role'] == 1) { ?>
                    <nav>
                        <a href="?page=home">Главная <img src="assets/media/images/header/right.png" alt=""></a>
                        <a href="?page=catalog">Каталог <img src="assets/media/images/header/right.png" alt=""></a>
                        <a href="?page=contacts">Контакты <img src="assets/media/images/header/right.png" alt=""></a>
                        <a href="?page=about">О нас <img src="assets/media/images/header/right.png" alt=""></a>
                    </nav>
                <? } else { ?>
                    <style>
                        .icons-all {
                            padding-left: 0;
                        }
                    </style>
                <? } ?>

                <div class="icons-nav">
                    <a href="?page=profile" class="ic">
                        <img src="assets/media/images/header/User.png" alt="">
                        <p>Мой профиль</p>
                    </a>
                    <?
                    if ($USER['role'] == 1) { ?>
                        <a href="?page=cart" class="ic">
                            <img src="assets/media/images/header/shop-bag.png" alt="">
                            <p>Корзина</p>
                        </a>
                    <? }
                    ?>
                </div>
            </div>
            <a href="?page=home">
                <img src="assets/media/images/logo/logo.png" alt="">
            </a>
            <div class="icons-all">
                <a href="?page=profile&id=<?= $id ?>">
                    <img src="assets/media/images/header/User.png" alt="">
                </a>
                <?
                if (isset($_SESSION['USER']) && $USER['role'] == 1) { ?>
                    <a href="?page=cart">
                        <img src="assets/media/images/header/shop-bag.png" alt="">
                    </a>
                <? }
                ?>
            </div>
        </div>
    </header>