<?
include('connect/connect.php')
?>
<?
include('incl/components/head.php')
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/media/images/logo/logo.png" type="image/x-icon">
    <title>КЛЕО</title>
</head>

<body>
    <? include('incl/components/header.php') ?>
    <?
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page == 'home') {
            include('incl/pages/home.php');
        } else if ($page == 'about') {
            include('incl/pages/about.php');
        } else if ($page == 'add') {
            include('incl/pages/add.php');
        } else if ($page == 'auto') {
            include('incl/pages/auto.php');
        } else if ($page == 'cart') {
            include('incl/pages/cart.php');
        } else if ($page == 'catalog') {
            include('incl/pages/catalog.php');
        } else if ($page == 'collections') {
            include('incl/pages/collections.php');
        } else if ($page == 'contacts') {
            include('incl/pages/contacts.php');
        } else if ($page == 'all_products') {
            include('incl/pages/all_products.php');
        } else if ($page == 'edit_profile') {
            include('incl/pages/edit_profile.php');
        } else if ($page == 'faq') {
            include('incl/pages/faq.php');
        } else if ($page == 'feedback') {
            include('incl/pages/feedback.php');
        } else if ($page == 'orders_user') {
            include('incl/pages/orders_user.php');
        } else if ($page == 'ordersAdmin') {
            include('incl/pages/ordersAdmin.php');
        } else if ($page == 'product') {
            include('incl/pages/product.php');
        } else if ($page == 'profile') {
            include('incl/pages/profile.php');
        } else if ($page == 'reg') {
            include('incl/pages/reg.php');
        } else if ($page == 'update') {
            include('incl/pages/update.php');
        } else {
            include('incl/pages/home.php');
        }
    } else {
        include('incl/pages/home.php');
    }
    ?>
    <? include('incl/components/footer.php') ?>
</body>

</html>