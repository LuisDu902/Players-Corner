<?php function drawFAQList($faqs, $session) { ?>
        <div id="faq-page" data-role="<?=$session->getRole()?>">
            <h1>Frequently Asked Questions</h1>
            <?php if ($session->getRole() === "admin"){ ?>
                <div class="button-wrap round-border gradient"><button id="add-faq">Add New FAQ</button></div>
                <?php drawFAQForm();
            }?>
            <ul id="faq-list">
                <?php foreach($faqs as $faq)
                    drawFAQ($faq, $session);
                ?>
            </ul>
            <div id ="load" class="button-wrap gradient round-border">
                <button type="button" class="load-more">
                    Load more
                </button>
            </div>
        </div>
<?php } ?>

<?php function drawFAQ($faq, $session) { ?>
    <li class="faq-item" data-role="<?=$faq->id?>">
    <input id="cb<?=$faq->id?>" type="checkbox" class="faq-item-checkbox">
    <label class="faq-item-header" for="cb<?=$faq->id?>">
        <span class="faq-title"><?=$faq->problem?></span>
        <div class="faq-icons">
            <ion-icon name="add-outline"></ion-icon>
            <ion-icon name="remove-outline"></ion-icon>
            <?php if ($session->getRole() === "admin"){ ?>
                <form class="delete-faq" action="../actions/faq_actions/action_delete_faq.php" method="post" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                <input type="hidden" name="id" value="<?=$faq->id?>">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <button type="submit" class="trash-button">
                    <ion-icon name="trash-outline" class="buzz-out-on-hover"></ion-icon>
                </button>
                </form>
            <?php } ?>
        </div>
    </label>
    <div class="faq-item-answer">
        <p><?=$faq->answer?></p>
    </div>
    </li>

<?php } ?>


<?php
function drawFAQForm()
{ ?>
    <div id="faq-modal" class="modal">
        <div class="modal-content white-border round-border vert-flex center" id="faq-modal-content">
            <span class="modal-title"> Add new FAQ </span>
            <form action="../actions/faq_actions/action_add_new_faq.php" method="post">
                <textarea name="problem" required="required" placeholder="Question" id="faq-problem" class="white-border round-border"></textarea>
                <textarea name="answer" required="required" placeholder="Answer" id="faq-answer" class="white-border round-border"></textarea>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <div class="button-wrap gradient round-border auth-button">
                    <button type="submit">Confirm</button>
                </div>
            </form>
        </div>
    </div>
<?php }
?>

