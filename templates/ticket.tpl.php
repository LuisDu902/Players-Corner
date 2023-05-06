<?php function drawTickets($tickets)
{ ?>
    <div class="search-bar center">
        <div class="filter-condition white-border">
            <span> Filter by </span>
            <select name="" class="filter-criteria" id="filter-ticket">
                <option value="title"> Title </option>
                <option value="creator"> Creator </option>
                <option value="replier"> Assigned agent </option>
                <option value="status"> Status </option>
                <option value="priority"> Priority </option>
                <option value="tag"> Hashtag </option>
                <option value="visibility"> Visibility </option>
                <option value="category"> Category </option>
            </select>
        </div>
        <div class="search-box center round-border white-border">
            <input id="search-ticket" type="text" placeholder="search">
            <img src="../images/icons/search.png">
        </div>

        <div class="order-condition round-border white-border">
            <span> Order by </span>
            <select name="" class="order-select" id="order-ticket">
                <option value="title"> Title </option>
                <option value="category"> Category </option>
                <option value="status"> Status </option>
                <option value="priority"> Priority </option>
                <option value="visibility"> Visibility </option>
                <option value="createDate"> Date </option>
            </select>
        </div>
    </div>

    <div class="tickets">
        <ul class="ticket-info">
            <li>Creator</li>
            <li>Title</li>
            <li>Tags</li>
            <li>Category</li>
            <li>Status</li>
            <li>Priority</li>
            <li>Visibility</li>
            <li>Date</li>
        </ul>
        <div id="ticket-cards">
            <?php foreach ($tickets as $ticket) { ?>
                <a href="../pages/ticket.php?id=<?= $ticket->ticketId ?>" class="ticket">
                    <img src=<?= $ticket->creator->getPhoto() ?> class="<?= $ticket->creator->type ?>-card-border">
                    <span>
                        <?= $ticket->title ?>
                    </span>
                    <div class="ticket-tags">
                        <?php foreach ($ticket->tags as $tag) { ?>
                            <span> <?= $tag ?></span>
                        <?php } ?>
                    </div>
                    <span>
                        <?= $ticket->category ?>
                    </span>
                    <span class="status" id="<?= $ticket->status ?>-status"> <?= $ticket->status ?> </span>
                    <span class="priority" id="<?= $ticket->priority ?>-priority"> <?= $ticket->priority ?> </span>
                    <span>
                        <?= $ticket->visibility ?>
                    </span>
                    <span>
                        <?= $ticket->date ?>
                    </span>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php function drawTicket($ticket, $messages, $history)
{ ?>
    <div id="ticket">
        <a href="../pages/ticket.php?id=<?= $ticket->ticketId ?>" class="ticket">
            <img src=<?= $ticket->creator->getPhoto() ?> class="<?= $ticket->creator->type ?>-card-border">
            <span>
                <?= $ticket->title ?>
            </span>
            <span>
                <?= $ticket->category ?>
            </span>
            <span class="status" id="<?= $ticket->status ?>-status"> <?= $ticket->status ?> </span>
            <span class="priority" id="<?= $ticket->priority ?>-priority"> <?= $ticket->priority ?> </span>
            <span>
                <?= $ticket->visibility ?>
            </span>
            <span>
                <?= $ticket->date ?>
            </span>
        </a>
        <div class="messages">
            <?php foreach ($messages as $message) { ?>
                <span>
                    <?= $message->user->name ?>:
                </span>
                <br><br>
                <span>
                    <?= $message->text ?>
                </span>
                <br><br>
            <?php } ?>
        </div>
        <div class="history">
            <?php foreach ($history as $change) { ?>
                <span>
                <?= $change->changes?> : <?= $change->old_field ?> -> <?= $change->new_field ?>
                </span>
                <br><br>
                <span>
                    <?= $change->date ?>
                </span>
                <br><br>
            <?php } ?>
        </div>
        <div class="tags">
            <?php foreach ($ticket->tags as $tag) { ?>
                <span>
                    <?= $tag ?>
                </span>
                <br>
            <?php } ?>
        </div>
    </div>
<?php } ?>