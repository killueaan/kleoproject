<div class="contacts">
    <div class="contacts-section container">
        <div class="title-contacts">
            <h2>Связаться с нами</h2>
            <hr>
        </div>
        <div class="info-contacts">
            <div class="c-block">
                <img src="assets/media/images/contacts/1.png" alt="">
                <p><a href="tel:+79656243349">8 (965) 624 33 49</a> (Казань)</p>
            </div>
            <div class="c-block">
                <img src="assets/media/images/contacts/2.png" alt="">
                <p>ТРК "Кольцо, ул. Петербургская, 1, Казань, Респ. Татарстан, 420107</p>
            </div>
            <div class="c-block">
                <img src="assets/media/images/contacts/3.png" alt="">
                <p> <a href="mailto:kleojewelry@gmail.com">kleojewelry@gmail.com</a></p>
            </div>
        </div>
        <div class="feedback-contacts">
            <div class="info-feedback">
                <h2>Остались вопросы?</h2>
                <p>Заполни форму и мы ответим в течение 15 минут!</p>
            </div>
            <?
            if (isset($_POST['feedback'])) {
                $surname = $_POST['surname'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $question = $_POST['question'];

                $flag = true;
                $errors = [
                    '<p class="error">введите данные</p>',
                    '<p class="error">неверный формат почты</p>'
                ];
            }
            ?>
            <form name="feedback" class="feedback-form" method="post">
                <input type="text" name="surname" placeholder="Введите фамилию" value="<?= $surname ?? '' ?>">
                <?
                if (isset($_POST['feedback'])) {
                    if (empty($_POST['surname'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="text" name="name" placeholder="Введите имя" value="<?= $name ?? '' ?>">
                <?
                if (isset($_POST['feedback'])) {
                    if (empty($_POST['name'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="text" name="email" placeholder="Введите электронную почту" value="<?= $email ?? '' ?>">
                <?
                if (isset($_POST['feedback'])) {
                    if (empty($_POST['email'])) {
                        $flag = false;
                        echo $errors[0];
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $flag = false;
                        echo $errors[1];
                    }
                }
                ?>
                <textarea name="question" placeholder="Введите вопрос"></textarea>
                <?
                if (isset($_POST['feedback'])) {
                    if (empty($_POST['question'])) {
                        $flag = false;
                        echo $errors[0];
                    }
                }
                ?>
                <input type="submit" name="feedback" value="Отправить" class="btn sent-mes">
            </form>
            <div class="modal-container message-f-sent">
                <div class="modal mt-150 ">
                    <div class="modal-content content-message-f">
                        <h2>Ваша заявка отправлена</h2>
                        <p>Ожидайте ответа от нашего сотрудника. Это займет немного времени.</p>
                    </div>
                </div>
            </div>
            <?
            if (isset($_POST['feedback'])) {
                if ($flag) {
                    $sql = "INSERT INTO `feedback`(`surname`,`name`, `email`, `question`,`status`) VALUES ('$surname','$name','$email','$question','1')";
                    // var_dump($sql);
                    $result = $connect->query($sql);
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    const modal = document.querySelector(".modal-container.message-f-sent");
                    modal.style.display = "block";
                    
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 3000);
                    
                });
            </script>';
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="map container">
    <script type="text/javascript" charset="utf-8" async
        src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A67f61c8add0805ea387cf7901389d4bfdf83066c66fc24041aa1d906db281f91&amp;&amp;&amp;lang=ru_RU&amp;scroll=true"></script>
</div>