<?php require_once(__DIR__ . '/../templates/department.tpl.php'); ?>

<?php function drawInitial($session, $departments){ ?>
    <section id="banner">
        <span class="container banner">
            <article class="corner-text">
                <h1>
                    This is <br>
                    <span class="auto-type"></span>
                </h1>
                <p><br>The one-stop-shop for all your gaming FAQs and strategies. <br> No gamer should be left out!</p>
                <a href="#about-us" class="btn">About us</a>
            </article>
            <article class="gif">
                <img src="../images/banner.gif">
            </div>
        </span>
    </section>
    <section id="categories">
        <?php drawDepartments($session, $departments); ?>
    </section>
    <section id="about-us" class="container">
        <h2 class="heading-title">About us</h2>
        <div class="about-content">
            <img src="../images/about-us.jpeg" alt="about us banner" class="white-border round-border">
            <p>
            Welcome to Player's Corner, the ultimate destination for all your gaming FAQs and strategies. At Player's Corner, we believe that no gamer should be left out when it comes to finding solutions to their gaming troubles. Our dedicated team of experts is here to provide you with a one-stop-shop experience, offering comprehensive and reliable support for all your gaming needs. Whether you're stuck on a challenging level, seeking advice on game strategies, or looking for answers to common gaming queries, Player's Corner is your go-to resource. With our extensive collection of FAQs, helpful guides, and a vibrant community of fellow gamers, you'll never have to face gaming challenges alone. Join us at Player's Corner and unlock a world of knowledge, tips, and tricks to level up your gaming experience.
            </p>
        </div>
    </section>
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js" defer></script>
<script src="../javascript/typed.js" defer></script>
<?php } ?>