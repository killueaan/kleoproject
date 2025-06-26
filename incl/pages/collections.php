<?
if (isset($_SESSION['USER'])) {
    if ($USER['role'] == 2) { ?>
        <div class="main">
            <a href="?page=profile" class="back container mt-150">
                <img src="assets/media/images/products/left.png" alt=""> Профиль
            </a>

            <div class="collections container mt-30">
                <h2>Коллекции</h2>

                <form action="" method="post" class="form-search">
                    <input type="text" name="name" placeholder="поиск">
                    <input type="submit" class="search-btn" name="form-search" value="">
                </form>
            </div>
            <div class="collections-section container mt-75">
                <div class="add-collection">
                    <div class="add-col-title">
                        <h2>Добавление коллекции</h2>
                    </div>
                    <div class="add-col-section container mt-30">
                        <?
                        if (isset($_POST['add-collection'])) {
                            $name = $_POST['name'];

                            $flag = true;
                            $errors = [
                                '<p class="error">введите данные</p>',
                                '<p class="error">данная коллекция уже существует</p>'
                            ];
                        }
                        ?>
                        <form action="" method="post" name="add-collection" class="add-form-upd">
                            <input type="text" name="name" placeholder="Введите название">
                            <?
                            if (isset($_POST['add-collection'])) {
                                if (empty($_POST['name'])) {
                                    $flag = false;
                                    echo $errors[0];
                                } else {
                                    $sql = "SELECT * FROM `collection` WHERE `name`='$name'";
                                    $result = $connect->query($sql)->fetchColumn();
                                    if ($result != 0) {
                                        $flag = false;
                                        echo $errors[1];
                                    }
                                }
                            }
                            ?>
                            <input type="submit" value="Добавить" name="add-collection" class="btn">
                        </form>
                        <?
                        if (isset($_POST['add-collection'])) {
                            if ($flag) {
                                $sql = "INSERT INTO `collection`(`name`) VALUES ('$name')";
                                $result = $connect->query($sql);
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="collections-content">
                    <?
                    if (isset($_POST['form-search'])) {
                        $text = $_POST['name'];
                        $dop_sql = "WHERE `name` LIKE '%" . $text . "%' $sql_cat ";

                        if (empty($text)) {
                            echo '<script>document.location.href="?page=collections"</script>';
                        }

                        $sql = "SELECT * FROM `collection` $dop_sql";
                        $res = $connect->query($sql)->rowCount();
                        if ($res == 0) {
                            echo "<p class='error-search'>По запросу '$text' ничего не найдено.<br> Попробуйте еще раз.</p>";
                        }
                    } else {
                        $dop_sql = "";
                    }
                    ?>
                    <?
                    $sql = "SELECT * FROM `collection` $dop_sql";
                    $result = $connect->query($sql);
                    foreach ($result as $collection) {
                        $id = $collection['id'];
                        $col_name = $collection['name']; ?>
                        <div class="collect-card">
                            <h3>Коллекция:</h3>
                            <p><?= $col_name ?></p>
                            <button class="btn delete-btn" data-id="<?= $id ?>">Удалить</button>
                        </div>
                        <div class="modal-container product-delete" id="modal-<?= $id ?>" style="display: none;">
                            <div class="modal content-prod-del mt-150">
                                <h2>Вы хотите удалить коллекцию "<?= $col_name ?>"?</h2>
                                <div class="hrefs">
                                    <a href="?page=collections&del=<?= $id ?>&id=<?= $id ?>" class="btn confirm-delete">Да, удалить</a>
                                    <a href="#" class="btn cancel-delete">Нет</a>
                                </div>
                            </div>
                        </div>
                    <?
                    }
                    ?>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.delete-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const id = this.getAttribute('data-id');
                                document.getElementById(`modal-${id}`).style.display = 'flex';
                            });
                        });

                        document.querySelectorAll('.cancel-delete').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                this.closest('.modal-container').style.display = 'none';
                            });
                        });
                    });
                </script>
                <?
                if (isset($_GET['del'])) {
                    $id = $_GET['del'];
                    $sql = "DELETE FROM `collection` WHERE `id`='$id'";
                    $result = $connect->query($sql)->fetch();
                    echo '<script>document.location.href="?page=collections"</script>';
                }
                ?>
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