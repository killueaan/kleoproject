<?
if (isset($_SESSION['USER'])) {
    if ($USER['role'] == 2) { ?>
        <a href="?page=profile" class="back container mt-150">
            <img src="assets/media/images/products/left.png" alt=""> Профиль
        </a>
        <div class="feedbacks container mt-30">
            <h2>Заявки на обратную связь</h2>

        </div>
        <div class="feedback-section container mt-75">
            <?
            $sql = "SELECT * FROM `feedback`  WHERE `status`<='2'ORDER BY id DESC";
            $result = $connect->query($sql);
            foreach ($result as $feedback) {
                $id = $feedback['id']; ?>
                <div class="f-block">
                    <div class="content-f">
                        <div class="info-f">
                            <h3>Номер заявки: <?= $feedback['id'] ?></h3>
                            <p><?= $feedback['surname'] ?> <?= $feedback['name'] ?></p>
                            <p class="number-f"><?= $feedback['email'] ?></p>
                        </div>
                        <div class="text-f">
                            <p><?= $feedback['question'] ?></p>
                            <?
                            if ($feedback['status'] == 1) { ?>
                                <p>Статус: Новый</p>
                                <div class="hrefs">
                                    <a href="?page=feedback&OK=<?= $id ?>"><img src="assets/media/images/feedback/checked.png" alt=""></a>
                                    <a href="?page=feedback&NO=<?= $id ?>"><img src="assets/media/images/feedback/X.png" alt=""></a>
                                </div>
                            <? } else if ($feedback['status'] == 2) { ?>
                                <p>Статус: Проверенный</p>
                                <div class="hrefs">
                                    <a href="?page=feedback&NO=<?= $id ?>"><img src="assets/media/images/feedback/X.png" alt=""></a>
                                </div> <? }
                                        ?>
                        </div>
                    </div>
                </div>
            <? }
            ?>
            <?
            if (isset($_GET['OK'])) {
                $id = $_GET['OK'];
                $sql = "UPDATE `feedback` SET `status`='2' WHERE id=$id";
                $result = $connect->query($sql);
                echo '<script>document.location.href="?page=feedback"</script>';
            }
            ?>
            <?
            if (isset($_GET['NO'])) {
                $id = $_GET['NO'];
                $sql = "UPDATE `feedback` SET `status`='3' WHERE id=$id";
                $result = $connect->query($sql);
                echo '<script>document.location.href="?page=feedback"</script>';
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