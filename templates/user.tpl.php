<?php
declare(strict_type=1);
require_once(__DIR__ . '/../classes/user.class.php');
?>

<?php function drawProfile(Session $session, User $user)
{ ?>
  <header id="profile">Profile page</header>
  <section class="container" id="user-profile">
    <article class="round-border profile-picture round-wrap vert-flex center">
       <img src=<?= $user->getPhoto() ?> alt="user-profile" class="gradient circle-border">
        <h4 class="bold highlight"> <?= $user->username ?> </h4>
        <?php if ($session->getId() === $user->userId) {?>
          <div class="button-wrap gradient round-border">
            <a href="../pages/edit_profile.php"><button>Edit profile</button></a>
          </div>
        <?php } ?>
    </article>
    <article class="round-border user-details" id="about">
      <h2 class="center">General information</h2>
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
        <?php if ($user->type !== 'client'){ ?>
        <tr>
          <th class="field round-border">Reputation</th>
          <td class="info round-border"><?= $user->reputation ?></td>
        </tr>
        <?php } ?>
      </table>
    </article>
    <article class="round-border center vert-flex" id="ticket-stats">
      <h2>Created tickets</h2>
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
        <div class="button-wrap gradient round-border auth-button" id="upload"> <button type="submit">Upload photo</button> </div>
      </form>
    </div>
  </div>
<?php } ?>

<?php function drawUserSearchBar(){ ?>
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
<?php } ?>

<?php function drawUsers($users)
{ 
  drawUserSearchBar(); ?>
  <div class="user-cards" id="users"> </div>
  <div class="modal"> </div>
<?php } ?>