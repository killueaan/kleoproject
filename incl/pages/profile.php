<?
if (isset($_SESSION['USER'])) { ?>

    <body>
        <!-- header start -->

        <!-- header end -->
        <div class="mainn">
            <div class="profile container mt-150">
                <div class="profile-section">
                    <h2>Мой профиль</h2>
                    <div class="user">
                        <img src="<?= $USER['img'] ?>" alt="">
                        <div class="info-user">
                            <p><?= $USER['surname'] ?></p>
                            <p><?= $USER['name'] ?></p>
                            <a href="?page=edit_profile&id=<?= $id ?>">Редактировать профиль</a>
                        </div>
                    </div>
                    <div class="hrefs-user">
                        <?
                        if (isset($_SESSION['USER'])) {
                            if ($USER['role'] == 1) { ?>
                                <a href="?page=orders_user">
                                    <p>Мои заказы</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>
                                <a href="?page=faq">
                                    <p>Вопрос-ответ</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>

                            <? } else { ?>
                                <a href="?page=add">
                                    <p>Добавление товара</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>
                                <a href="?page=all_products">
                                    <p>Все товары</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>
                                <a href="?page=collections">
                                    <p>Коллекции</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>
                                <a href="?page=ordersAdmin">
                                    <p>Заказы пользователей</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>
                                <a href="?page=feedback">
                                    <p>Заявки</p>
                                    <img src="assets/media/images/header/right.png" alt="">
                                </a>
                        <? }
                        }
                        ?>
                        <div class="exit">
                            <a href="?exit">
                                <img src="assets/media/images/profile/Logout.png" alt="">
                                <p>Выйти</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="personal-info">
                    <div class="pi-block">
                        <h6>личная информация</h6>
                        <div class="pi-info">
                            <p><?= $USER['surname'] ?></p>
                            <p><?= $USER['name'] ?></p>
                        </div>
                    </div>
                    <?
                    if (isset($_SESSION['USER'])) {
                        if ($USER['role'] == 1) { ?>
                            <div class="pi-block">
                                <h6>дата рождения</h6>
                                <? if (empty($USER['date_of_birth'])) { ?>
                                    <div class="pi-info">
                                        <p style="color: #696969;">не указано</p>
                                    </div>
                                <? } else { ?>
                                    <div class="pi-info">
                                        <p><?= $USER['date_of_birth'] ?></p>
                                    </div>
                                <? } ?>
                            </div>
                    <? }
                    }
                    ?>
                    <div class="pi-block">
                        <h6>контакты</h6>
                        <div class="pi-info">
                            <p><?= $USER['email'] ?></p>
                        </div>
                        <? if (empty($USER['number'])) { ?>
                            <div class="pi-info">
                                <p style="color: #696969;margin-top:15px;">не указано</p>
                            </div>
                        <? } else { ?>
                            <div class="pi-info">
                                <p><?= $USER['number'] ?></p>
                            </div>
                        <? } ?>
                    </div>
                    <?
                    if (isset($_SESSION['USER'])) {
                        if ($USER['role'] == 1) { ?>
                            <div class="pi-block">
                                <h6>город</h6>
                                <? if (empty($USER['town'])) { ?>
                                    <div class="pi-info">
                                        <p style="color: #696969;">не указано</p>
                                    </div>
                                <? } else { ?>
                                    <div class="pi-info">
                                        <p><?= $USER['town'] ?></p>
                                    </div>
                                <? } ?>
                            </div>
                    <? }
                    }
                    ?>
                </div>
            </div>
        </div>
    <? } else {
    echo '<script>document.location.href="?page=reg"</script>';
}
    ?>