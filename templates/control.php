<?php function drawAllUsers($users)
{ ?>
  <div class="search-bar">
    <input id="search-user" type="text" placeholder="search">
    <div class="filter-condition">
      <span> Filter by </span>
      <select name="" id="filter-select">
        <option value="users"> All users </option>
        <option value="client"> Clients </option>
        <option value="agent"> Agents </option>
        <option value="admin"> Admins </option>
      </select>
    </div>
    <div class="order-condition">
      <span> Order by </span>
      <select name="" id="order-select">
        <option value="name"> Name </option>
        <option value="reputation"> Reputation </option>
        <option value="type"> Role </option>
      </select>
    </div>
  </div>
  <div class="user-cards" id="users">
    <?php foreach ($users as $user): ?>
      <div class="user-card">
        <div class="card-type">
          <span class="type <?= $user->type ?>-card-type"><?= $user->type ?></span>
          <span class="rep">
            <?= $user->reputation ?>
          </span>
        </div>
        <img src=<?= $user->getPhoto() ?> alt="profile" class="<?= $user->type ?>-card-border"></img>
        <div class="card-details">
          <span class="card-name">
            <?= $user->name ?>
          </span>
          <span>
            <?= $user->username ?>
          </span>
        </div>
        <div class="card-button">
          <div class="button-wrap">
            <a href="../pages/register.php"><button class="details">details</button></a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php } ?>