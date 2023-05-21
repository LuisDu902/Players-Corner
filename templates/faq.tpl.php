<?php function drawFAQList($faqs, $session)
{ ?>
    <section id="faq-page" class="vert-flex center" data-role="<?= $session->getRole() ?>">
        <header>Frequently Asked Questions</header>
        <?php if ($session->getRole() === "admin") { ?>
            <div class="button-wrap round-border gradient"><button id="add-faq">Add New FAQ</button></div>
            <?php drawFAQForm();
        } ?>
        <ul id="faq-list">
            <?php foreach ($faqs as $faq) {
                drawFAQ($faq, $session);
            } ?>
        </ul>
        <div id="load" class="button-wrap gradient round-border">
            <button type="button" class="load-more">
                Load more
            </button>
        </div>
    </section>
<?php } ?>

<?php function drawFAQ($faq, $session)
{ ?>
    <li class="faq-item" data-role="<?= $faq->id ?>">
        <input id="cb<?= $faq->id ?>" type="checkbox" class="faq-item-checkbox">
        <label class="faq-item-header" for="cb<?= $faq->id ?>">
            <strong class="faq-title">
                <?= $faq->problem ?>
            </strong>
            <div class="faq-icons">
                <ion-icon name="add-outline"></ion-icon>
                <ion-icon name="remove-outline"></ion-icon>
                <?php if ($session->getRole() === "admin") { ?>
                    <form class="delete-faq" action="../actions/faq_actions/action_delete_faq.php" method="post">
                        <input type="hidden" name="id" value="<?= $faq->id ?>">
                        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <button type="submit" class="trash-button">
                            <ion-icon name="trash-outline" class="buzz-out-on-hover"></ion-icon>
                        </button>
                    </form>
                <?php } ?>
            </div>
        </label>
        <div class="faq-item-answer">
            <p>
                <?= $faq->answer ?>
            </p>
        </div>
    </li>

<?php } ?>


<?php
function drawFAQForm()
{ ?>
    <div id="faq-modal" class="modal">
        <article class="modal-content white-border round-border vert-flex center" id="faq-modal-content">
            <h2 class="modal-title"> Add new FAQ </h2>
            <form action="../actions/faq_actions/action_add_new_faq.php" method="post">
                <textarea name="problem" required="required" placeholder="Question" id="faq-problem"
                    class="white-border"></textarea>
                <textarea name="answer" required="required" placeholder="Answer" id="faq-answer"
                    class="white-border"></textarea>
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <div class="button-wrap gradient round-border ">
                    <button type="submit">Confirm</button>
                </div>
            </form>
        </article>
    </div>
<?php }
?>



<?php function drawFAQDropup($faqs)
{ ?>
    <div class="dropup">
        <button class="faq-btn">FAQ</button>
        <article class="dropup-content">
            <section class="search-box center round-border white-border">
                <input id="faq-bar" type="text" placeholder="search">
                <img src="../images/icons/search.png">
            </section>
            <ul id="faq-items" class="center">
                <?php foreach ($faqs as $faq) { ?>
                    <li class="faq-title" data-id=<?= $faq->id ?>>
                        <?= $faq->problem ?>
                    </li>
                <?php } ?>
            </ul>
        </article>
    </div>
<?php } ?>