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
function drawTicket($_session,$ticket, $messages, $history,$attachedFiles)
{ 
    ?>
    <head>
        <link rel="stylesheet" href="../css/ticket_form.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/ticket.css">
    </head>
    <div id="ticket-page">
    <div id="ticket">
        <div class="ticket-header">
            <span class="ticket-title"><?= $ticket->title ?></span>
            <span class="ticket-date"><?= $ticket->date ?></span> 
        </div>
        <br>
        <span class="ticket-creator-small">Created by: <?= $ticket->creator->name ?></span>
        <span class="assigned">Assigned to: <?= $ticket->replier->name ?> </span>
        <br>
        <div class="ticket-info-details">
            <span class="ticket-dep"><?= $ticket->category ?></span>
            <span id="<?= $ticket->status ?>-status" class="round-border status"><?= $ticket->status ?></span>
            <span id="<?= $ticket->priority ?>-priority" class="ticket-priority"><?= $ticket->priority ?></span>
            <span class="ticket-visibility"><?= $ticket->visibility ?></span>
        </div>
        <div class="tags-info">
            <?php foreach ($ticket->tags as $tag) { ?>
                <span><?= $tag ?></span>
            <?php } ?>
        </div>
        <div class="description">
            <span class="desc"><?= $ticket->text?> </span>
            </br></br>
        </div>
        <div class="messages-ticket">
            <?php 
            foreach ($messages as $message) {
                if ($message['user']->userId !== $ticket->creator->userId) {
                    echo '<div class="message-container-replier">';
                } else {
                    echo '<div class="message-container-creator">';
                }
            ?>
                <div class="message-ticket">
                    <span class="sender"><?= $message['user']->name ?></span>
                    <br>
                    <span class="text"><?= $message['text'] ?></span>
                    <br>
                    <span class="time"><?= $message['date'] ?></span>
                    <br>
                </div>
            <?php
                echo '</div>';
                ?> 
                <br>
                <?php
            }
            ?>
        </div>


        <?php if(($_session->getId()=== $ticket->creator->userId || $_session->getId()=== $ticket->replier->userId)) {?>
        <div id="respond">
            <form action="../actions/ticket_actions/action_add_message.php" method="post" id="reply">
                <textarea name="text" id="text" rows="10" tabindex="4"  required="required"></textarea>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input type="hidden" name="id" value="<?=$ticket->ticketId?>">
                <input name="submit" type="submit" value="Submit reply" />
            </form>

        </div>
        <?php }?>
        <div class="history">
            <br><br>
            <?php foreach ($history as $change) { ?>
                <span><?= $change->changes ?> : <?= $change->old_field ?> -> <?= $change->new_field ?></span>
                <span class="status_date"><?= $change->date ?></span>
                <br><br>
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
    <?php if($_session->getRole()=='admin' || $_session->getRole()== 'agent'){
        ?>
            <div class="sidebar">
                <h1>Edit Ticket</h1>
                <div class="sidebar-content">
                    <!-- Sidebar content goes here -->
                    <p>Welcome, <?= $_session->getRole() ?></p>
                </div>
            </div>
            <?php
    }?>
    </div>    
<?php 
}
?>