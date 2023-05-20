<?php function drawTicketForm($departments_get,$tags_get) { ?>
    <section class="vert-flex center">
        <div class="gradient round-border createTicket">
        <form action="../actions/ticket_actions/action_create_ticket.php" method="post" class="authentication-form">
            <label class="title">
                <h2>Title</h2>
                <h6>Be as specific and clear as possible </h6>
                <input type="text" name="title" required="required" placeholder="e.g. Selling item x gives more gold than its supposed to" maxlength="50">
            </label>
            <label class="departments-choice">
                <h3> Department </h3>
                <select name="category">
                    <?php foreach($departments_get as $department){?>
                        <option value="<?= $department->category ?>"> <?= $department->category?> </option>
                    <?php } ?>
                </select>
            </label>
            <label>
                <h3 >Tags:</h3>
                <input type="text" id="tags" name="tags" list="taglist">
                <input type="hidden" id="chosen_tags" name="chosen_tags" />
                <div id="tag-container"></div>
                <datalist id="taglist"></datalist>
            </label>
            <label class="description">
                <h2> Description </h2>
                <h6> Tell us the details of your problem.</h6>
                <textarea id="description" name="text" required="required" rows="4" cols="40"></textarea><br>
            </label>    
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <div class="button-wrap gradient round-border auth-button"> <button type="submit">Create ticket</button> </div>
        </form>
    </div>
    </section>
    <?php
} ?>