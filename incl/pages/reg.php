<?
if (!isset($_SESSION['USER'])) { ?>

    <!-- registration start -->
    <div class="autoreg container">
        <div class="autoreg-title">
            <h1>Регистрация</h1>
            <p>Если у вас уже есть аккаут, то <a href="?page=auto">войдите</a></p>
        </div>

        <?
        if (isset($_POST['reg'])) {
            $surname = $_POST['surname'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordr = $_POST['passwordr'];
            $default_img = 'assets/media/images/profile/def.jpg';

            $flag = true;
            $errors = [
                '<p class="error">введите данные</p>',
                '<p class="error">неверный формат почты</p>',
                '<p class="error">данный пользователь уже существует</p>',
                '<p class="error">минимальная длина - 8 символов</p>',
                '<p class="error">пароли не совпадают</p>',
                '<p class="error">примите согласие на обработку данных</p>',
            ];
        }
        ?>
        <div class="autoreg-f">
            <form class="add-form-upd" method="post" name="reg">
                <div class="inputs-r">
                    <input type="text" name="surname" placeholder="Введите фамилию" pattern="[а-яА-Я\s\-]{2,30}$"
                        title="Имя должно содержать от 2 до 30 символов (латинские буквы, пробелы или дефисы)" value="<? if (isset($_POST['reg'])) {
                                                                                                                            echo $surname;
                                                                                                                        } ?>">
                    <?
                    if (isset($_POST['reg'])) {
                        if (empty($_POST['surname'])) {
                            $flag = false;
                            echo $errors[0];
                        }
                    }
                    ?>
                    <input type="text" name="name" placeholder="Введите имя" pattern="[а-яА-Я\s\-]{2,30}$"
                        title="Имя должно содержать от 2 до 30 символов (латинские буквы, пробелы или дефисы)" value="<? if (isset($_POST['reg'])) {
                                                                                                                            echo $name;
                                                                                                                        } ?>">
                    <?
                    if (isset($_POST['reg'])) {
                        if (empty($_POST['name'])) {
                            $flag = false;
                            echo $errors[0];
                        }
                    }
                    ?>
                    <input type="text" name="email" placeholder="Введите электронную почту" pattern="[a-z]+@[a-z]+\.com"
                        title="Неверный формат почты" id="email" value="<? if (isset($_POST['reg'])) {
                                                                            echo $email;
                                                                        } ?>">
                    <?
                    if (isset($_POST['reg'])) {
                        if (empty($_POST['email'])) {
                            $flag = false;
                            echo $errors[0];
                        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $flag = false;
                            echo $errors[1];
                        } else {
                            $sql = "SELECT * FROM `users` WHERE email = '$email'";
                            $result = $connect->query($sql)->fetchColumn();
                            if ($result != 0) {
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
                    if (isset($_POST['reg'])) {
                        if (empty($_POST['password'])) {
                            $flag = false;
                            echo $errors[0];
                        } else if (strlen($password) < 8) {
                            $flag = false;
                            echo $errors[3];
                        }
                    }
                    ?>
                    <input type="password" name="passwordr" placeholder="Повторите пароль">
                    <?
                    if (isset($_POST['reg'])) {
                        if (empty($_POST['passwordr'])) {
                            $flag = false;
                            echo $errors[0];
                        } else if ($password != $passwordr) {
                            $flag = false;
                            echo $errors[4];
                        }
                    }
                    ?>

                    <label><input type="checkbox" name="checkbox" value="1"> Согласие на обработку персональных данных</label>
                    <?
                    if (isset($_POST['reg'])) {
                        if (empty($_POST['checkbox'])) {
                            $flag = false;
                            echo $errors[5];
                        }
                    }
                    ?>
                </div>
                <input type="submit" name="reg" value="Зарегистрироваться" class="btn">
                <p class="autoreg-ff">Нажимая «Зарегистрироваться», вы принимаете пользовательское соглашение и политику конфиденциальности
                </p>
            </form>
        </div>
        <?
        if (isset($_POST['reg'])) {
            if ($flag) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`( `surname`, `name`, `email`, `password`, `role`,`img`,`town`) 
                VALUES ('$surname','$name','$email','$password','1','$default_img','')";
                $result = $connect->query($sql);

                $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                $id_user = $connect->query($sql)->fetch()['id'];

                $sql = "INSERT INTO `cart`( `id_user`) VALUES ('$id_user')";
                $result = $connect->query($sql);
                echo '<script>document.location.href="?page=auto"</script>';
            }
        }
        ?>
    </div>
    <!-- registration end -->

<? } else {
    echo '<script>document.location.href="?page=profile&id=' . $id . '"</script>';
}
?>