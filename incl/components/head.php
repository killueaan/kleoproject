<?
session_start();
if (isset($_SESSION['USER'])) {
    $id = $_SESSION['USER'];
    $sql = "SELECT users.*, cart.id AS id_cart FROM `cart` 
    LEFT JOIN users ON users.id=cart.id_user WHERE users.id='$id'";
    $USER = $connect->query($sql)->fetch();

    $id_cart = $USER['id_cart'];
    $id_user = $USER['id'];
}
if (isset($_GET['exit'])) {
    unset($_SESSION['USER']);
    echo '<script>document.location.href="?page=home"</script>';
}
