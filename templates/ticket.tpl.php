<?php function drawUserTickets($tickets)
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
        <?php foreach ($tickets as $ticket) { ?>
            <div class="ticket">
                <h2>
                    <?= $ticket->title ?>
                </h2>
                <h3>
                    <?= $ticket->text ?>
                    </h2>
            </div>
        <?php } ?>
    </div>
<?php } ?>