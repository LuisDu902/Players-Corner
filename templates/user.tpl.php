<?php
declare(strict_type=1);
require_once(__DIR__ . '/../classes/user.class.php');
?>

<?php function drawProfile(User $user)
{ ?>
  <div class="user-profile">
    <div class="user-reputation">
      <span id="reputation" class="title">Reputation</span>
      <span class="reputation-value">
        <?= $user->reputation ?>%
      </span>
    </div>
    <div class="user-details">
      <span id="about" class="title">About me</span>
      <span class="field"> Name </span>
      <span class="info">
        <?= $user->name ?>
      </span>
      <span class="field"> Username </span>
      <span class="info">
        <?= $user->username ?>
      </span>
      <span class="field"> Email </span>
      <span class="info">
        <?= $user->email ?>
      </span>
      <span class="field"> Role </span>
      <span class="info">
        <?= $user->type ?>
      </span>
    </div>
    <div class="profile-picture round-wrap">
      <img src=<?= $user->getPhoto() ?> alt="user-profile">
      <span>
        <?= $user->username ?>
      </span>
      <a href="../pages/profile.edit.php" id="edit-button"> Edit profile</a>
    </div>
  </div>

<?php } ?>

<?php function drawEditUserForm(User $user)
{ ?>
  <div class="edit-profile">
    <div class="edit-fields">
      <h2 class="register-text">Edit profile</h2>
      </h2>
      <form action="../actions/action_edit_profile.php" method="post" class="authentication-form">
        <div class="input-box">
          <input type="text" name="name" required="required" placeholder="Name">
          <img src="../images/icons/user.png" class="icon" alt="user">
        </div>
        <div class="input-box">
          <input type="username" name="username" required="required" placeholder="Username">
          <img src="../images/icons/username.png" class="icon" alt="username">
        </div>
        <div class="input-box">
          <input type="email" name="email" required="required" placeholder="Email">
          <img src="../images/icons/email.png" class="icon" alt="email">
        </div>

        <div class="input-box">
          <input type="password" name="old-password" required="required" placeholder="New password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </div>
        <div class="input-box">
          <input type="password" name="new-password" required="required" placeholder="Old password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </div>
        <button type="submit" class="authentication-button">Save</button>
      </form>
    </div>
    <div class="upload-photo">
      <form action="../actions/action_upload_image.php" method="post" class="upload-form round-wrap"
        enctype="multipart/form-data">
        <img src=<?= $user->getPhoto() ?> alt="user-profile" id="user-image-preview">
        <input type="file" id="user-image" name="imageToUpload">
        <button type="submit" id="upload" class="authentication-button">Upload photo</button>
      </form>
    </div>
  </div>
<?php } ?>

<?php function drawUsers($users)
{ ?>
  <div class="search-bar">
    <div class="search-box">
      <input id="search-user" type="text" placeholder="search">
      <i class="gg-search"></i>
    </div>
    <select name="" id="filter-select">
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
  <div class="user-cards" id="users">
    <?php foreach ($users as $user):
      drawUserCard($user);
    endforeach; ?>
  </div>
<?php } ?>


<?php function drawUserCard($user)
{ ?>
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
      <?php if ($user->type == "client") {
        drawClientCardButtons();
        drawUpgradeModal($user);
      } else if ($user->type == "agent") {
        drawAgentCardButtons($user);
        drawUpgradeModal($user);
       // drawAssignModal($user);
      } else {
        drawAdminCardButtons($user);
        //drawAssignModal($user);
      } ?>
    </div>

  </div>
<?php } ?>


<?php function drawUpgradeModal($user)
{ ?>
  <div class="modal upgrade-modal">
    <div class="modal-content">
      <span class="modal-title">
        <?= $user->name ?>
      </span>
      <img src=<?= $user->getPhoto() ?> alt="profile" class="<?= $user->type ?>-card-border"></img>
      <form method="POST" action="../actions/action_upgrade_user.php">
        <div id="promote">
          <span>Upgrade to</span>
          <select name="role" id="filter-select">
            <?php if ($user->type == 'client') { ?>
              <option value="agent"> Agent </option>
            <?php } ?>
            <option value="admin"> Admin </option>
          </select>
        </div>
        <div class="button-wrap">
          <button type="submit" name="upgrade_user" class="confirm-upgrade">Upgrade</button>
        </div>
        <input type="hidden" name="userId" value="<?= $user->userId ?>">
      </form>
    </div>
  </div>
<?php } ?>


<?php function drawAssignModal($user)
{ ?>
  <div class="modal assign-modal">
    <div class="modal-content">
      <span class="modal-title">
        Choose departments
      </span>
      <form method="POST" action="../actions/action_upgrade_user.php">
        <div class="button-wrap">
          <button type="submit" name="upgrade_user" class="confirm-upgrade">Assign</button>
        </div>
        <input type="hidden" name="userId" value="<?= $user->userId ?>">
      </form>
    </div>
  </div>
<?php } ?>

<?php function drawClientCardButtons()
{ ?>
  <div class="button-wrap">
    <button class="upgrade">upgrade</button>
  </div>
<?php } ?>

<?php function drawAgentCardButtons($user)
{ ?>
  <div class="two-button-wrap button-wrap">
    <button class="upgrade">upgrade</button>
  </div>
  <div class="two-button-wrap button-wrap">
    <form method="post" action="../pages/assign_departments.php">
    <input type="hidden" name="userId" value=<?=$user->userId?>>
      <button type="submit" class="assign">Assign</button>
    </form>
  </div>
<?php } ?>

<?php function drawAdminCardButtons($user)
{ ?>
  <div class="button-wrap">
    <form method="post" action="../pages/assign_departments.php">
    <input type="hidden" name="userId" value=<?=$user->userId?>>
      <button type="submit" class="assign">Assign</button>
    </form>
  </div>
<?php } ?>