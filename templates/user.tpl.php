<?php
  declare(strict_type = 1);
  require_once(__DIR__ . '/../classes/user.class.php');
?>

<?php function drawProfile(User $user) { ?>
  <div class="user-profile">
    <div class="user-reputation vert-flex">
      <span id="reputation" class="title center">Reputation</span>
      <span class="reputation-value circle-border gradient center bold"> <?= $user->reputation ?>% </span>
    </div>
    <div class="user-details center">
      <span id="about" class="title bold">About me</span>
      <span class="field round-border center"> Name </span>
      <span class="info round-border center"> <?= $user->name ?> </span>
      <span class="field round-border center"> Username </span>
      <span class="info round-border center"> <?= $user->username ?> </span>
      <span class="field round-border center"> Email </span>
      <span class="info round-border center">  <?= $user->email ?> </span>
      <span class="field round-border center"> Role </span>
      <span class="info round-border center"> <?= $user->type ?> </span>
    </div>
    <div class="profile-picture round-wrap vert-flex center">
      <img src=<?= $user->getPhoto() ?> alt="user-profile" class="gradient circle-border">
      <span class="bold"> <?= $user->username ?> </span>
      <div class="button-wrap gradient round-border">
      <a href="../pages/edit_profile.php"><button>Edit profile</button></a>
    </div>
    </div>
  </div>
<?php } ?>

<?php function drawEditUserForm(User $user) { ?>
  <div class="edit-profile center">
    <div class="edit-fields">
      <h2 class="auth-text center">Edit profile</h2>
      </h2>
      <form action="../actions/user_actions/action_edit_profile.php" method="post" class="authentication-form">
        <div class="input-box round-border">
          <input type="text" name="name" required="required" placeholder="Name">
          <img src="../images/icons/user.png" class="icon" alt="user">
        </div>
        <div class="input-box round-border">
          <input type="username" name="username" required="required" placeholder="Username">
          <img src="../images/icons/username.png" class="icon" alt="username">
        </div>
        <div class="input-box round-border">
          <input type="email" name="email" required="required" placeholder="Email">
          <img src="../images/icons/email.png" class="icon" alt="email">
        </div>
        <div class="input-box round-border">
          <input type="password" name="old-password" required="required" placeholder="Old password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </div>
        <div class="input-box round-border">
          <input type="password" name="new-password" required="required" placeholder="New password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </div>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <div class="button-wrap gradient round-border auth-button"> <button type="submit">Save</button> </div>       
      </form>
    </div>
    <div class="profile-picture center vert-flex">
      <form action="../actions/user_actions/action_upload_image.php" method="post" class="upload-form round-wrap center vert-flex" enctype="multipart/form-data">
        <img src=<?= $user->getPhoto() ?> alt="user-profile" id="user-image-preview" class="circle-border">
        <input type="file" id="user-image" name="imageToUpload">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <div class="button-wrap gradient round-border auth-button" id="upload"> <button type="submit">Upload photo</button> </div>
      </form>
    </div>
  </div>
<?php } ?>

<?php function drawUsers($users) { ?>
  <nav class="search-bar center">
    <div class="search-box center round-border white-border">
      <input id="search-user" type="text" placeholder="search">
      <img src="../images/icons/search.png">
    </div>
    <select class="filter-select round-border white-border" id="filter-user">
      <option value="users"> All users </option>
      <option value="client"> Clients </option>
      <option value="agent"> Agents </option>
      <option value="admin"> Admins </option>
    </select>
    <div class="order-condition round-border white-border">
      <span> Order by </span>
      <select class="order-select" id="order-user">
        <option value="name"> Name </option>
        <option value="reputation"> Reputation </option>
        <option value="type"> Role </option>
      </select>
    </div>
</nav>
  <div class="user-cards" id="users">
    <?php foreach ($users as $user):
      drawUserCard($user);
    endforeach; ?>
  </div>
  <div class="modal"> </div>
<?php } ?>


<?php function drawUserCard($user) { ?>
  <div class="user-card vert-flex round-border white-border">
    <div class="card-type">
      <span class="type <?= $user->type ?>-card-type bold center"><?= $user->type ?></span>
      <span class="rep center bold"> <?= $user->reputation ?> </span>
    </div>
    <img src="<?= $user->getPhoto() ?>" alt="profile" class="<?= $user->type ?>-card-border card-img circle-border"></img>
    <div class="card-details vert-flex center">
      <span class="card-name"> <?= $user->name ?> </span>
      <span class="span-username"> <?= $user->username ?> </span>
    </div>
    <div class="card-buttons center">
      <?php if ($user->type == "client") { drawClientCardButtons();} 
            else if ($user->type == "agent") { drawAgentCardButtons($user);} 
            else { drawAdminCardButtons($user);} ?>
    </div>
    <input type='hidden' value=<?= $user->userId ?> id='card-userId'>
  </div>
<?php } ?>


<?php function drawClientCardButtons() { ?>
  <div class="button-wrap gradient round-border"> <button>upgrade</button> </div>
<?php } ?>

<?php function drawAgentCardButtons($user) { ?>
  <div class="two-button-wrap button-wrap gradient round-border"> <button> upgrade </button> </div>
  <div class="two-button-wrap button-wrap gradient round-border"> <button> assign </button> </div>
<?php } ?>

<?php function drawAdminCardButtons($user) { ?>
  <div class="button-wrap gradient round-border"> <button>assign</button> </div>
<?php } ?>