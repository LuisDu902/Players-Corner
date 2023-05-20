<?php require_once(__DIR__ . '/../templates/department.tpl.php'); ?>

<?php function drawInitial($session, $departments){ ?>
    <section id="container">
        <article class="corner-text">
            <h1>
                This is <br>
                <span class="auto-type"></span>
            </h1>
            <p><br>The one-stop-shop for all your gaming FAQs and strategies. <br> No gamer should be left out!</p>
            <a href="#" class="btn">About us</a>
        </article>
        <article class="gif">
            <img src="../images/banner.gif">
        </article>
    </section>
    <section class="categories">
        <?php drawDepartments($session, $departments); ?>
    </section>
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
<script src="../javascript/typed.js"></script>
<?php } ?>