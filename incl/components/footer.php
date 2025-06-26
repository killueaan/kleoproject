<footer class="mt-75">
    <?php if (!isset($_SESSION['USER']) || $USER['role'] == 1) { ?>

        <div class="footer container">
            <div class="left">
                <img src="assets/media/images/logo/logoo.png" alt="">
                <a href="tel:+79996665544">
                    <h3>8 (999) 666 55 44 </h3>
                </a>
                <p>круглосуточный телефон call-центра</p>
            </div>
            <div class="right">
                <nav class="footer-nav">
                    <a href="?page=home">Главная</a>
                    <a href="?page=catalog">Каталог</a>
                    <a href="?page=contacts">Контакты</a>
                    <a href="?page=about">О нас</a>
                </nav>
                <div class="partners">
                    <h3>Партнеры</h3>
                    <a href="https://sunlight.net/">https://sunlight.net/</a>
                    <a href="https://alrosadiamond.ru/">https://alrosadiamond.ru/</a>
                </div>
            </div>
        </div>
    <? } ?>
</footer>