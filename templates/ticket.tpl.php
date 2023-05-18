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
function drawTicket($_session, $ticket, $messages, $history, $attachedFiles)
{
    ?>
    <div id="ticket-page" data-id="<?= $ticket->ticketId ?>" data-creator="<?= $ticket->creator->userId ?>">
        <article id="tkt">
            <h1 class="highlight"><?= $ticket->title ?></h1>
            <h3>Created by: <?= $ticket->creator->name ?> | <?= $ticket->date ?></h3>
            <p id="ticket-text" class="round-border"><?= $ticket->text ?></p>
            <hr>
            <div class="vert-flex messages-ticket">
                <?php foreach ($messages as $message) {
                    if ($message['user']->userId !== $ticket->creator->userId) { ?>
                        <div class="vert-flex replier-msg round-border">
                        <?php } else { ?>
                            <div class="vert-flex creator-msg round-border">
                            <?php } ?>
                            <h2 class="sender">
                                <?= $message['user']->name ?>
                            </h2>
                            <h3 class="text">
                                <?= $message['text'] ?>
                            </h3>
                            <h4 class="time">
                                <?= $message['date'] ?>
                            </h4>
                        </div>
                    <?php } ?>
                </div>

                <?php if (($_session->getId() === $ticket->creator->userId || $_session->getId() === $ticket->replier->userId)) { ?>
                    <div id="respond">
                        <textarea id="message-input" placeholder="Type your message..." rows="1"></textarea>
                        <button id="upload-button" class="no-background"><img src="../images/icons/upload.png"
                                alt="Send"></button>
                        <button id="faq-button" class="no-background"><span>FAQ</span></button>
                        <button id="send-button" class="no-background"><img src="../images/icons/send.png" alt="Send"></button>
                    </div>
                <?php } ?>
        </article>

        <?php if ($_session->getRole() == 'admin' || $_session->getRole() == 'agent') {
            ?>
            <section class="sidebar">
                <h1>Edit Ticket</h1>
                <div class="sidebar-content">

                    <p>Welcome,
                        <?= $_session->getRole() ?>
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
            </section>
            <?php
        } ?>
    </div>
    </div>
    <?php
}
?>