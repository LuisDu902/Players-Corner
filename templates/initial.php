<?php require_once(__DIR__ . '/../templates/department.tpl.php'); ?>

<?php function drawInitial($session){ ?>
    <section id="container">
        <article class="corner-text">
            <h1>Player's Corner</h1>
            <p><br>The one-stop-shop for all your gaming FAQs and strategies. <br> No gamer should be left out!</p>
            <a href="#" class="btn">About us</a>
        </article>
        <article class="gif">
            <img src="../images/banner.gif">
        </article>
    </section>
    <section class="categories">
         <h1 class="heading-title">Categories</h1>
         <?php if ($session->getRole() === "admin") { ?>
            <div class="button-wrap round-border gradient"><button id="add-department">Add new department</button></div>
            
        <?php  drawDepartmentModal() ;
    } ?>
         <div class="container">
            <div class="product">
                <div class="effect-1"></div>
                <div class="effect-2"></div>
                <div class="content">
                    <i class='bx bxl-dev-to' ></i>
                </div>
                <span class="title">
                    Game Development
                </span>
            </div>
            <div class="product">
                <div class="effect-1"></div>
                <div class="effect-2"></div>
                <div class="content">
                    <i class='bx bxl-dev-to' ></i>
                </div>
                <span class="title">
                Tech Support
                </span>
            </div>
            <div class="product">
                <div class="effect-1"></div>
                <div class="effect-2"></div>
                <div class="content">
                    <i class='bx bxl-dev-to' ></i>
                </div>
                <span class="title">
                    Game Design
                </span>
            </div>
        </div>
    </section>
<?php
}
