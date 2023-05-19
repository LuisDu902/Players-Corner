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
function drawTicket($_session,$ticket, $departments,$status,$priorities,$department,$messages, $history,$attachedFiles){ ?>
    <div id="ticket-page" data-id="<?= $ticket->ticketId ?>" data-creator="<?= $ticket->creator->userId ?>">
        <article id="tkt">
            <h1 class="highlight"> <?= $ticket->title ?> </h1>
            <h3>Created by: <?= $ticket->creator->name ?> | <?= $ticket->date ?></h3>
            <h2 id="ticket-text" class="round-border"> <?= $ticket->text ?> </h2>
            <hr>
            <ol id="ticket-messages">
                <?php foreach ($messages as $message) {
                    if ($message['user']->userId !== $ticket->creator->userId) { ?>
                        <li class="replier-msg ticket-msg">
                    <?php } else { ?>
                        <li class="creator-msg ticket-msg">
                    <?php } ?>
                        <img src="<?= $message['user']->getPhoto() ?>" alt="user-img" class="circle-border">
                        <span> <?= $message['user']->name ?> </span>
                        <div class="message-content round-border">
                            <p> <?= $message['text'] ?> </p>
                            <p class="message-date"> <?= $message['date'] ?> </p>
                        </div>
                    </li>
                <?php } ?>
            </ol>
            <?php if (($_session->getId() === $ticket->creator->userId || $_session->getId() === $ticket->replier->userId)) { ?>
                <div id="respond">
                    <textarea id="message-input" placeholder="Type your message..." rows="1"></textarea>
                    <button id="upload-button" class="no-background"><img src="../images/icons/upload.png" alt="Send"></button>
                    <button id="faq-button" class="no-background"><span>FAQ</span></button>
                    <button id="send-button" class="no-background"><img src="../images/icons/send.png" alt="Send"></button>
                </div>
            <?php } ?>
        </article>
    <?php if($_session->getRole()=='admin' || $_session->getRole()== 'agent'){
        ?>
            <section id="sidebar">
                <h1>Properties</h1>
                    <div id="cat">
                        <label >Category: 
                        <select name="categories" id="categories">
                            <?php foreach($departments as $category) {
                                if($category->category == $ticket->category){
                                    ?>
                                   <option value="<?= $ticket->category ?>" selected><?= $ticket->category ?> </option><?php
                                }
                                else{ ?>
                                    <option value="<?= $category->category ?>"><?= $category->category ?> </option> <?php
                                }
                            } ?>
                        </select>
                        </label>
                    </div>
                        <br>
                    <div id="st">
                        <label>Status: 
                        <select name="stat" id="stat">
                            <?php foreach($status as $stat) {
                                if($stat == $ticket->status){
                                    ?>
                                   <option value="<?= $ticket->status?>" selected><?= $ticket->status ?> </option><?php
                                }
                                else{ ?>
                                    <option value="<?= $stat ?>"><?= $stat ?> </option> <?php
                                }
                            } ?>
                        </select>
                        </label>
                    </div>
                        <br>
                    <div id="pri">
                        <label>Priority: 
                        <select name="priorities" id="priorities">
                            <?php foreach($priorities as $priority) {
                                if($priority== $ticket->priority){
                                    ?>
                                   <option value="<?= $ticket->priority?>" selected><?= $ticket->priority ?> </option><?php
                                }
                                else{ ?>
                                    <option value="<?= $priority ?>"><?= $priority ?> </option> <?php
                                }
                            } ?>
                        </select>
                        </label>
                    </div>
                        <br>
                    <div id="as">
                        <label>Assignee: 
                        <select name="assignee" id="assignee">
                            <?php foreach($department->members as $member) {
                                if($member->userId== $ticket->replier->userId){
                                    ?>
                                   <option value="<?= $ticket->replier->name?>" selected><?= $ticket->replier->name ?> </option><?php
                                }
                                else{ ?>
                                    <option value="<?= $member->name ?>"><?= $member->name ?> </option> <?php
                                }
                            } ?>
                        </select>
                        </label>
                    </div>
                    <div>
                        <h3 >Tags:</h3>
                        <input type="text" id="tags-edit" name="tags-edit" list="taglist">
                        <input type="hidden" id="ticket_tags" name="ticket_tags" />
                        <div id="tag-container"></div>
                        <datalist id="taglist"></datalist>
                    </div>
                    <div class="history">
                        <br><br>
                        <?php foreach ($history as $change) { ?>
                            <span><?= $change->changes ?> : <?= $change->old_field ?> -> <?= $change->new_field ?></span>
                            <span class="status_date"><?= $change->date ?></span>
                            <br><br>
                        <?php } ?>
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
    <?php } ?>

