<?php function drawTicketSearchBar()
{ ?>
    <div class="search-bar center">
        <div class="filter-condition round-border white-border">
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
<?php } ?>

<?php function drawTickets($tickets)
{
    if (!empty($tickets)) { ?>
        <table class="tickets">
            <thead>
                <tr class="ticket-info ">
                    <th>Creator</th>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Visibility</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div class="pagination-bar center"></div>
    <?php } else { ?>
        <span>No tickets</span>
    <?php }
}
?>

<?php
function drawTicket($ticket, $messages, $history, $attachedFiles)
{
    ?>
    <div id="ticket">
        <a href="../pages/ticket.php?id=<?= $ticket->ticketId ?>" class="ticket">
            <img src=<?= $ticket->creator->getPhoto() ?> class="<?= $ticket->creator->type ?>-card-border">
            <span>
                <?= $ticket->title ?>
            </span>
            <span>
                <?= $ticket->category ?>
            </span>
            <span class="status" id="<?= $ticket->status ?>-status"><?= $ticket->status ?></span>
            <span class="priority" id="<?= $ticket->priority ?>-priority"><?= $ticket->priority ?></span>
            <span>
                <?= $ticket->visibility ?>
            </span>
            <span>
                <?= $ticket->date ?>
            </span>
        </a>
        <div class="description">
            <span>
                <?= $ticket->text ?>
            </span>
            </br></br>
        </div>
        <div class="messages">
            <?php
            $sender = NULL;
            foreach ($messages as $message) {
                if ($message['user']->name !== $ticket->creator->name) {
                    echo '<div class="message-container-replier">';
                } else {
                    echo '<div class="message-container-creator">';
                }
                ?>
                <div class="message">
                    <span class="sender">
                        <?= $message['user']->name ?>
                    </span>
                    <br>
                    <span class="text">
                        <?= $message['text'] ?>
                    </span>
                    <br>
                    <span class="time">
                        <?= $message['date'] ?>
                    </span>
                    <br>
                </div>
                <?php
                if ($messag['user']->name !== $sender) {
                    echo '</div>';
                    ?>
                    <br>
                    <?php
                    $sender = $message['user']->name;
                }
            }
            ?>
        </div>
        <div class="history">
            <?php foreach ($history as $change) { ?>
                <span>
                    <?= $change->changes ?> :
                    <?= $change->old_field ?> ->
                    <?= $change->new_field ?>
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
            <?php } ?>
        </div>
        <form action="../actions/ticket_actions/action_attach_file.php" id="fileUploadForm" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">
                <img src="../images/icons/upload.png" alt="Upload icon" id="uploadFile">
            </label>
            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <input type="hidden" name="id" value="<?=$ticket->ticketId?>">
            <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
        </form>
        <?php foreach ($attachedFiles as $filename) { ?>
             <a href="../files/ticket<?=$ticket->ticketId?>_<?=$filename?>" download><?=$filename?></a>
            <?php } ?>
    </div>
    <?php
}
?>