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
        <img src="../images/icons/warning.png">
        <h2 class="center">No tickets yet</h2>
    <?php }
}
?>

<?php function drawUserTickets(Session $session, User $user, array $tickets)
{ ?>
    <section id="user-tickets" class="center" data-user="<?= $user->name ?>">
        <header>
            <?= $user->name ?>'s tickets
        </header>
        <?php drawTickets($tickets);

        if ($session->getId() === $user->userId) { ?>
            <div class="button-wrap gradient round-border">
                <a href="../pages/create_ticket.php"><button>Create new ticket</button></a>
            </div>
        <?php } ?>
    </section>
<?php } ?>

<?php
function drawTicket($session,$ticket, $departments,$status,$priorities,$department,$messages, $history,$attachedFiles,$faqs)
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
            
            <article id="properties">
            <h1>Properties</h1>
                    <div id="cat">
                        <label >Category: 
                        <select name="categories" id="categories">
                            <?php foreach($departments as $category) {
                                if($category->category === $ticket->category){
                                    ?>
                                   <option value="<?= $ticket->category ?>" selected><?= $ticket->category ?></option><?php
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
                                if($stat === $ticket->status){
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
                                if($priority === $ticket->priority) { ?>
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
                                   <option value="<?= $ticket->replier->userId?>" selected><?= $ticket->replier->name ?> </option><?php
                                }
                                else{ ?>
                                    <option value="<?= $member->userId ?>"><?= $member->name ?> </option> <?php
                                }
                            } ?>
                        </select>
                        </label>
                    </div>
                    
                    <br>

                    <div id="vis">
                        <label for="visibility">Visiblity: 
                            <select name="visibility" id="visibility">
                            <?php if($ticket->visibility === 'public'){?>
                                    <option value="public" selected> Public  </option>
                                    <option value="private" > Private  </option>
                                    <?php
                            } else {?>
                                    <option value="public" > Public  </option>
                                    <option value="private" selected> Private  </option>
                                    <?php
                            } ?>
                            </select>
                        </label>
                    </div>
                    </br>
                    <div>
                        <label>Tags: 
                        <input type="text" id="tags-edit" name="tags-edit" list="taglist1">
                        <input type="hidden" id="ticket_tags" name="ticket_tags" />
                        <div id="tag-container">
                            <?php foreach($ticket->tags as $tag){ ?>
                            <div class="tag-block">
                                <span id="value"><?= $tag ?></span>
                                <button class="remove-button">x</button>
                            </div>
                            <?php } ?>
                        </div>
                        <datalist id="taglist1">
                        </datalist>
                        </label>
                    </div>
                    <br>
                    <button id="edit-btn" class="no-background">Submit edit</button>
                    </div>
                    <hr>

                    <div class="history">
                    <?php foreach ($history as $date => $changes) : ?>
    <h2><?= $date; ?></h2>
    <strong>User:</strong> <?= $changes[0]->user->name; ?><br>

    <ul>
      <?php foreach ($changes as $change) : ?>
        <li>
            <?php if ($change->old_field == '') { ?>
                <strong><?= $change->changes ?></strong>
            <?php } else { ?>
          <strong><?= $change->changes ?></strong> : <?= $change->old_field; ?> >>> <?= $change->new_field; ?><br>
            <?php } ?>
          </li>
      <?php endforeach; ?>
    </ul>
  <?php endforeach; ?>
                    </div>
                    <hr>
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
            </article>
            
            <article id="files">
                
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