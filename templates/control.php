
<?php function drawAllUsers($users)
{ ?>
   <header>
        <h2>Users</h2>
        <input id="search-user" type="text" placeholder="search">   
    </header>
  <div class="user-cards" id ="users">
    <?php foreach ($users as $user): ?>
      <div class="user-card">
        <div class="card-type">
          <span class="type <?= $user->type ?>-card-type"><?= $user->type ?></span>
          <span class="rep"><?= $user->reputation ?></span>
        </div>
        <img src=<?= $user->getPhoto() ?> alt="profile" class="<?= $user->type ?>-card-border"></img>
        <div class="card-details">
          <span class="card-name"><?= $user->name ?></span>
          <span><?= $user->username ?></span>
        </div>
        <div class="card-buttons">
          <?php if ($user->type == "client") {
            drawClientCardButtons();
          } else if ($user->type == "agent") {
            drawAgentCardButtons();
          } else {
            drawAdminCardButtons();
          }
          ?>
        </div>
        </div>
    <?php endforeach; ?>
        </div>
<?php } ?>

<?php function drawClientCardButtons(){ ?>
  <div class="button-wrap">
    <a href="../pages/register.php"><button class="upgrade">upgrade</button></a>
  </div>
<?php } ?>

<?php function drawAgentCardButtons(){ ?>
  <div class="two-button-wrap button-wrap">
    <a href="../pages/login.php"><button class="upgrade">upgrade</button></a>
  </div>
  <div class="two-button-wrap button-wrap">
    <a href="../pages/register.php"><button class="assign">assign</button></a>
  </div>
<?php } ?>

<?php function drawAdminCardButtons(){ ?>
  <div class="button-wrap">
    <a href="../pages/register.php"><button class="assign">assign</button></a>
  </div>
<?php } ?>
