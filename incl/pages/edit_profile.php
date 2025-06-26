<?
if (isset($_SESSION['USER'])) { ?>
    <div class="main">
        <div class="add  mt-150">
            <h2>Редактирование данных</h2>
        </div>
        <div class="add-section  mt-30">
            <?
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM `users` WHERE `id`='$id'";
                $result = $connect->query($sql)->fetch();

                $default_img = $result['img'];
            }
            ?>
            <?
            if (isset($_POST['edit_profile'])) {
                $surname = $_POST['surname'];
                $name = $_POST['name'];
                $number = $_POST['number'];
                $email = $_POST['email'];
                $town = $_POST['town'];
                $date_of_birth = $_POST['date_of_birth'];

                if (empty($_FILES['img']['name'])) {
                    $img = $default_img;
                } else {
                    $img = 'assets/media/images/profile/' . time() . $_FILES['img']['name'];
                    move_uploaded_file($_FILES['img']['tmp_name'], $img);
                }

                $flag = true;
                $errors = [
                    '<p class="error">введите данные</p>'
                ];
            }
            ?>
            <form action="" method="post" name="edit_profile" class="add-form-upd" enctype="multipart/form-data">
                <input type="file" name="img">
                <input type="text" name="surname" placeholder="Введите фамилию" value="<?= $result['surname'] ?>">
                <?
                if (isset($_POST['edit_profile'])) {
                    if (empty($_POST['surname'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="text" name="name" placeholder="Введите имя" value="<?= $result['name'] ?>">
                <?
                if (isset($_POST['edit_profile'])) {
                    if (empty($_POST['name'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="text" name="number" pattern="[0-9]*" title="Только цифры" inputmode="numeric" placeholder="Введите номер телефона" value="<?= $result['number'] ?>">

                <input type="text" name="email" placeholder="Введите эл.почту" value="<?= $result['email'] ?>">
                <?
                if (isset($_POST['edit_profile'])) {
                    if (empty($_POST['email'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <?
                if (isset($_SESSION['USER'])) {
                    if ($USER['role'] == 1) { ?>
                        <input type="text" name="town" placeholder="Введите город" value="<?= $result['town'] ?>">
                        <input type="date" name="date_of_birth" placeholder="Введите дату рождения" value="<?= $result['date_of_birth'] ?>">
                <? }
                }
                ?>
                <input type="submit" value="Изменить" name="edit_profile" class="btn">
            </form>
            <?
            if (isset($_POST['edit_profile'])) {
                if ($flag) {
                    $sql = "UPDATE `users` SET 
                    `surname`='$surname',
                    `name`='$name',
                    `email`='$email',
                    `img`='$img',
                    `town`='$town',
                    `number`='$number',
                    `date_of_birth`='$date_of_birth' WHERE `id`='$id'";
                    // var_dump($sql);
                    $result = $connect->query($sql);
                    echo '<script>document.location.href="?page=profile&id=' . $id . '"</script>';
                }
            }
            ?>
            <a href="?page=profile&id=<?= $id ?>" class="btn">Назад</a>
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
?>