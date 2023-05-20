<?php function drawTicketSearchBar()
{ ?>
    <nav class="search-bar center">
        <div class="filter-condition round-border white-border">
            <label> Filter by </label>
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
            <label> Order by </label>
            <select name="" class="order-select" id="order-ticket">
                <option value="title"> Title </option>
                <option value="category"> Category </option>
                <option value="status"> Status </option>
                <option value="priority"> Priority </option>
                <option value="visibility"> Visibility </option>
                <option value="createDate"> Date </option>
            </select>
        </div>
    </nav>
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
        <h2 class="center">No tickets</h2>
    <?php }
}
?>

<?php
function drawTicket($session, $ticket, $messages, $history, $attachedFiles, $faqs)
{ ?>
    <section id="ticket-page" data-id="<?= $ticket->ticketId ?>" data-creator="<?= $ticket->creator->userId ?>">
        <article id="tkt">
            <h1 class="highlight">
                <?= $ticket->title ?>
            </h1>
            <h3>Created by:
                <?= $ticket->creator->name ?> |
                <?= $ticket->date ?>
            </h3>
            <h2 id="ticket-text" class="round-border">
                <?= $ticket->text ?>
            </h2>
            <hr>
            <ol id="ticket-messages">
                <?php foreach ($messages as $message) {
                    if ($message['user']->userId !== $ticket->creator->userId) { ?>
                        <li class="replier-msg ticket-msg">
                        <?php } else { ?>
                        <li class="creator-msg ticket-msg">
                        <?php } ?>
                        <img src="<?= $message['user']->getPhoto() ?>" alt="user-img" class="circle-border">
                        <span>
                            <?= $message['user']->name ?>
                        </span>
                        <section class="message-content round-border">
                            <p>
                                <?= $message['text'] ?>
                            </p>
                            <p class="message-date">
                                <?= $message['date'] ?>
                            </p>
                        </section>
                    </li>
                <?php }
                if (($ticket->status == 'closed') && ($session->getId() === $ticket->creator->userId) && ($ticket->feedback === 1)) {
                    drawSurvey($ticket);
                } ?>
            </ol>
            <?php if (($session->isLoggedIn()) && ($ticket->status !== 'closed') && ($session->getId() === $ticket->creator->userId || $session->getId() === $ticket->replier->userId)) { ?>
                <section id="respond">
                    <textarea id="message-input" placeholder="Type your message..." rows="1"></textarea>
                    <button id="upload-button" class="no-background"><img src="../images/icons/upload.png" alt="Send"></button>
                    <?php if ($session->getId() === $ticket->replier->userId) {
                        drawFAQDropup($faqs);
                    } ?>
                    <button id="send-button" class="no-background"><img src="../images/icons/send.png" alt="Send"></button>
                </section>
            <?php } ?>
        </article>









        <aside class="sidebar">
            <h1>Edit Ticket</h1>
            <div class="sidebar-content">

                <p>Welcome,
                    <?= $session->getRole() ?>
                </p>
            </div>
            <article id="files">
                <h2>Attached Files</h2>
                <ul>
                    <?php foreach ($attachedFiles as $filename) { ?>
                        <li>
                            <a href="../files/ticket<?= $ticket->ticketId ?>_<?= $filename ?>" download><?= $filename ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </article>
        </aside>

    </section>
    <?php
}
?>


<?php function drawSurvey(Ticket $ticket)
{ ?>
    <li class="bot-msg ticket-msg">
        <img src="../images/icons/bot.png" alt="user-img" class="circle-border bot-img">
        <span> Satisfaction survey </span>
        <div class="message-content round-border">
            <p>Using your game expertise, how would you classify the level of awesomeness our agent's service
                achieved?</p>
            <section id="feedback" class="center" data-id="<?= $ticket->replier->userId ?>">
                <div class="vert-flex">
                    <button data-value=-10><img src="../images/icons/terrible.png" alt="Terrible"></button>
                    <p>Terrible</p>
                </div>
                <div class="vert-flex">
                    <button data-value=-5><img src="../images/icons/bad.png" alt="Not Good"></button>
                    <p>Not good</p>
                </div>
                <div class="vert-flex">
                    <button data-value=0><img src="../images/icons/normal.png" alt="Okay"></button>
                    <p>Okay</p>
                </div>
                <div class="vert-flex">
                    <button data-value=5><img src="../images/icons/great.png" alt="Great"></button>
                    <p>Great</p>
                </div>
                <div class="vert-flex">
                    <button data-value=10><img src="../images/icons/awesome.png" alt="Awesome"></button>
                    <p>Awesome</p>
                </div>
            </section>
    </li>
<?php } ?>