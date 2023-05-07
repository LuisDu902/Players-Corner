<?php
declare(strict_type=1);
require_once(__DIR__ . '/../classes/user.class.php');
?>

<?php function drawProfile(User $user)
{ ?>
  <header id="profile">Profile page</header>
  <section class="container" id="user-profile">
    <article class="round-border profile-picture round-wrap vert-flex center">
       <img src=<?= $user->getPhoto() ?> alt="user-profile" class="gradient circle-border">
        <h4 class="bold highlight"> <?= $user->username ?> </h4>
        <div class="button-wrap gradient round-border">
          <a href="../pages/edit_profile.php"><button>Edit profile</button></a>
        </div>
    </article>
    <article class="round-border user-details" id="about">
      <h3 class="center">About me</h3>
      <table class="center">
        <tr>
          <th class="field round-border">Name</th>
          <td class="info round-border"> <?= $user->name ?></td>
        </tr>
        <tr>
          <th class="field round-border">Username</th>
          <td class="info round-border"> <?= $user->username ?></td>
        </tr>
        <tr>
          <th class="field round-border">Email</th>
          <td class="info round-border"> <?= $user->email ?></td>
        </tr>
        <tr>
          <th class="field round-border">Role</th>
          <td class="info round-border"><?= $user->type ?></td>
        </tr>
        <tr>
          <th class="field round-border">Reputation</th>
          <td class="info round-border"><?= $user->reputation ?></td>
        </tr>
      </table>
    </article>
    <article class="round-border center">
      <h3>Created tickets</h3>
      <canvas id="user-tkt" class="graphics"></canvas>
    </article>

  </section>
<?php } ?>

<?php function drawEditUserForm(User $user)
{ ?>
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
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <div class="button-wrap gradient round-border auth-button"> <button type="submit">Save</button> </div>
      </form>
    </div>
    <div class="profile-picture center vert-flex">
      <form action="../actions/user_actions/action_upload_image.php" method="post"
        class="upload-form round-wrap center vert-flex" enctype="multipart/form-data">
        <img src=<?= $user->getPhoto() ?> alt="user-profile" id="user-image-preview" class="gradient circle-border">
        <input type="file" id="user-image" name="imageToUpload">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <div class="button-wrap gradient round-border auth-button" id="upload"> <button type="submit">Upload
            photo</button> </div>
      </form>
    </div>
  </div>
<?php } ?>

<?php function drawUsers($users)
{ ?>
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


<?php function drawUserCard($user)
{ ?>
  <div class="user-card vert-flex round-border white-border">
    <div class="card-type">
      <span class="type <?= $user->type ?>-card-type bold center"><?= $user->type ?></span>
      <span class="rep center bold circle-border">
        <?= $user->reputation ?>
      </span>
    </div>
    <img src="<?= $user->getPhoto() ?>" alt="profile" class="<?= $user->type ?>-card-border card-img circle-border"></img>
    <div class="card-details vert-flex center">
      <span class="card-name">
        <?= $user->name ?>
      </span>
      <span class="span-username">
        <?= $user->username ?>
      </span>
    </div>
    <div class="card-buttons center">
      <?php if ($user->type != "admin") { ?>
        <div class="button-wrap gradient round-border"> <button id="upgrade">upgrade</button> </div>
      <?php }
      if ($user->type != "client") { ?>
        <div class="button-wrap gradient round-border"> <button id="assign-dep">assign</button> </div>
      <?php } ?>
    </div>
    <input type='hidden' value=<?= $user->userId ?> id='card-userId'>
  </div>
<?php } ?>