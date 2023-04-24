<?php function drawUserTickets($tickets)
{ ?>
    <?php foreach ($tickets as $ticket) { ?>
        <div class="ticket">
            <h2> <?= $ticket->title ?></h2>
            <h3> <?= $ticket->text ?></h2>
        </div>
    <?php } ?>
<?php } ?>