<?php function drawFAQList($faqs) { ?>
        <div id="faq-page">
            <h1>Frequently Asked Questions</h1>
            <ul id="faq-list">
                <?php foreach($faqs as $faq)
                    drawFAQ($faq);
                ?>
            </ul>
            <div class="button-wrap gradient round-border">
                <button type="button" class="load-more">
                    Load more
                </button>
            </div>
        </div>
<?php } ?>

<?php function drawFAQ($faq) { ?>
    <li class="faq-item">
        <input id="cb<?=$faq->id?>" type="checkbox" class="faq-item-checkbox">
        <label class="faq-item-header" for="cb<?=$faq->id?>">
            <?=$faq->problem?>
            <ion-icon name="add-outline"></ion-icon>
            <ion-icon name="remove-outline"></ion-icon>
        </label>
        <div class="faq-item-answer">
            <p><?=$faq->answer?></p>
        </div>
    </li>
<?php } ?>