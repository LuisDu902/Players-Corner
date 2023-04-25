<?php function drawTickets($tickets)
{ ?>
    <div class="tickets">
        <div class="search-bar">
            <div class="search-box">
                <input id="search-user" type="text" placeholder="search">
                <i class="gg-search"></i>
            </div>
            <select name="" class="filter-select">
                <option value="users"> All users </option>
                <option value="client"> Clients </option>
                <option value="agent"> Agents </option>
                <option value="admin"> Admins </option>
            </select>
            <div class="order-condition">
                <span> Order by </span>
                <select name="" id="order-select">
                    <option value="name"> Name </option>
                    <option value="reputation"> Reputation </option>
                    <option value="type"> Role </option>
                </select>
            </div>
        </div>
        <ul class = "ticket-info">
            <li>Creator</li>
            <li>Title</li>
            <li>Category</li>
            <li>Status</li>
            <li>Priority</li>
            <li>Visibility</li>
            <li>Date</li>
        </ul>
        <?php foreach ($tickets as $ticket) { ?>
            <a href="../pages/ticket.php?id=<?=$ticket->ticketId?>" class="ticket">
                <img src = <?= $ticket->creator->getPhoto() ?> class="<?= $ticket->creator->type ?>-card-border">
                <span> <?= $ticket->title ?> </span>
                <span> <?= $ticket->category ?> </span>
                <span class="status" id="<?= $ticket->status ?>-status"> <?= $ticket->status ?> </span>
                <span class="priority" id="<?= $ticket->priority ?>-priority"> <?= $ticket->priority ?> </span>
                <span> <?= $ticket->visibility ?> </span>
                <span> <?= $ticket->date ?> </span>
            </a>
        <?php } ?>
    </div>
<?php } ?>

<?php function drawTicket($ticket, $messages)
{ ?>
    <div id="ticket">
    <a href="../pages/ticket.php?id=<?=$ticket->ticketId?>" class="ticket">
        <img src = <?= $ticket->creator->getPhoto() ?> class="<?= $ticket->creator->type ?>-card-border">
        <span> <?= $ticket->title ?> </span>
        <span> <?= $ticket->category ?> </span>
        <span class="status" id="<?= $ticket->status ?>-status"> <?= $ticket->status ?> </span>
        <span class="priority" id="<?= $ticket->priority ?>-priority"> <?= $ticket->priority ?> </span>
        <span> <?= $ticket->visibility ?> </span>
        <span> <?= $ticket->date ?> </span>
    </a>
    <div class="messages">
    <?php foreach ($messages as $message) { ?>
        <span><?=$message->user->name?>:</span>
        <br><br>
        <span><?=$message->text?></span>
        <br><br>
        <?php } ?>
    </div>
    </div>
<?php } ?>