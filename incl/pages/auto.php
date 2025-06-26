<?
if (!isset($_SESSION['USER'])) { ?>
    <!-- registration start -->
    <div class="autoreg container">
        <div class="autoreg-title">
            <h1>Авторизация</h1>
            <p>Если у вас еще нет аккаунта, то <a href="?page=reg">зарегистрируйтесь</a></p>
        </div>

        <div class="autoreg-f">
            <?
            if (isset($_POST['auto'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $flag = true;
                $errors = [
                    '<p class="error">введите данные</p>',
                    '<p class="error">неверный формат почты</p>',
                    '<p class="error">данного пользователя не существует</p>',
                    '<p class="error">неверный пароль или почта</p>',
                ];
            }
            ?>
            <form class="add-form-upd" method="post" name="auto">
                <div class="inputs-r">
                    <input type="text" name="email" placeholder="Введите электронную почту" pattern="[a-z]+@[a-z]+\.com"
                        title="Неверный формат почты" id="email" value="<? if (isset($_POST['auto'])) {
                                                                            echo $email;
                                                                        } ?>">
                    <?
                    if (isset($_POST['auto'])) {
                        if (empty($_POST['email'])) {
                            $flag = false;
                            echo $errors[0];
                        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $flag = false;
                            echo $errors[1];
                        } else {
                            $sql = "SELECT * FROM `users` WHERE email = '$email'";
                            $result = $connect->query($sql)->fetchColumn();
                            if ($result == 0) {
                                $flag = false;
                                echo $errors[2];
                            }
                        }
                    }
                    ?>
                    <input type="password" name="password" placeholder="Введите пароль "
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$"
                        title="Минимальная длина — 8 символов. Должен содержать хотя бы одну заглавную букву, одну строчную букву, одну цифру и один специальный символ (!@#$%^&*).">
                    <?
                    if (isset($_POST['auto'])) {
                        if (empty($_POST['password'])) {
                            $flag = false;
                            echo $errors[0];
                        } else {
                            $sql = "SELECT * FROM `users` WHERE `email`='$email'";
                            $result = $connect->query($sql)->fetch();
                            if (!password_verify($password, $result['password'])) {
                                $flag = false;
                                echo $errors[3];
                            }
                        }
                    }
                    ?>
                </div>
                <input type="submit" name="auto" value="Войти" class="btn">
                <div class="autoreg-ff">
                    <p>Нажимая «Войти», вы принимаете пользовательское соглашение и политику конфиденциальности.

                </div>
                </p>
            </form>
            <?
            if (isset($_POST['auto'])) {
                if ($flag) {
                    $_SESSION['USER'] = $result['id'];
                    echo "<script>document.location.href='?page=profile&id=" . $id . "'</script>";
                }
            }
            ?>
        </div>
    </div>
    <!-- registration end -->

<? } else {
    echo '<script>document.location.href="?page=profile&id=' . $id . '"</script>';
}
?>