<?php function drawTicketForm($departments_get,$tags_get){?>
    <section class="vert-flex center">
        <div class="gradient round-border createTicket">
        <form action="../actions/action_ticket.php" method="post" class="authentication-form">
            <div class="title">
                <h2>Title</h2>
                <h6>Be as specific and clear as possible </h6>
                <input type="text" name="title" required="required" placeholder="e.g. Selling item x gives more gold than its supposed to" maxlength="50">
            </div>
            <div class="departments-choice">
                <h3> Department </h3>
                <select name="department">
                    <?php foreach($departments_get as $department){?>
                        <option value="<?= $department->category ?>"> <?= $department->category?> </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <h3 >Tags:</h3>
                <input type="text" id="tags" name="tags" list="taglist">
                <div id="tag-container"></div>
                <datalist id="taglist"></datalist>
            </div>
            <div class="description">
                <h2> Description </h2>
                <h6> Tell us the details of your problem.</h6>
                <textarea id="description" name="description" required="required" rows="4" cols="40"></textarea><br>
            </div>    
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <div class="button-wrap gradient round-border auth-button"> <button type="submit">Create ticket</button> </div>
        </form>
    </div>
    </section>
    <?php
} ?>