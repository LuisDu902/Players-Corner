<?php function drawHeader(Session $session)
{ ?>
  <!DOCTYPE html>

  <head>
    <title>Player's Corner</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/authentication.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="../css/department.css">
    <link rel="stylesheet" href="../css/ticket.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/create_ticket.css">
    <link rel="stylesheet" href="../css/reports.css">
    <link rel="stylesheet" href="../css/ticket_form.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../javascript/add_new_department.js" defer></script>
    <script src="../javascript/add_new_faq.js" defer></script>
    <script src="../javascript/load_more_faq.js" defer></script>
    <script src="../javascript/assign_to_departments.js" defer></script>
    <script src="../javascript/upgrade_user.js" defer></script>
    <script src="../javascript/search_users.js" defer></script>
    <script src="../javascript/search_tickets.js" defer></script>
    <script src="../javascript/preview_image.js" defer></script>
    <script src="../javascript/dropdown.js" defer></script>
    <script src="../javascript/autocomplete_tags.js" defer></script>
    <script src="../javascript/chart.js" defer></script>
    <script src="../javascript/attach_file.js" defer></script>
    <script src="../javascript/edit_assignee.js" defer></script>
    <script src="../javascript/autocomple_edit.js" defer></script>
    <script src="../javascript/add_message.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </head>

  <body data-csrf="<?=$_SESSION['csrf']?>">
    <header id="header">
      <a href="../pages/index.php"><img class="logo" src="../images/icons/logo.png" alt="logo"> </a>
      <nav>
        <ul class="nav_links">
          <li class="home"> <a href="../pages/index.php">Home</a></li>
          <li class="Users"><a href="../pages/tickets.php">Forum</a></li>
          <li class="FAQ"><a href="../pages/faq.php">FAQ</a></li>
          <?php 
          if ($session->isLoggedIn()){?>
          	<li class="create-Ticket"><a href="../pages/create_ticket.php">Create Tickets</a></li> <?php 
          }?>
        
          <?php if ($session->isLoggedIn() && $session->getRole() === "admin") {
            drawAdminButtons();
          } ?>
            <li class="Help"><a href="#">Help</a></li>

        </ul>
      </nav>
      <?php
      if ($session->isLoggedIn()) {
        drawProfileButton($session);
      } else
        drawAuthForms(); ?>
    </header>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?= $messsage['type'] ?>">
          <?= $messsage['text'] ?>
        </article>
      <?php } ?>
    </section>
    <main>
    <?php } ?>

    <?php function drawFooter()
    { ?>
    </main>
  </body>

  </html>
<?php } ?>


<?php function drawAdminButtons()
{ ?>
  <li class="Users"><a href="../pages/users.php">Users</a></li>
  <li class="Users"><a href="../pages/reports.php">Reports</a></li>
<?php } ?>

<?php function drawAuthForms()
{ ?>
  <div class="buttons">
    <div class="button-wrap gradient round-border">
      <a href="../pages/login.php"><button>Sign In</button></a>
    </div>
    <div class="button-wrap gradient round-border">
      <a href="../pages/register.php"><button>Sign Up</button></a>
    </div>
  </div>
<?php } ?>


<?php function drawProfileButton(Session $session)
{ ?>
  <div class="dropdown">
    <button class="dropbtn center">
        <img src=<?=$session->getPhoto() ?> alt="user-profile" class="gradient circle-border">
        <span class="username"><?= $session->getName() ?></span>
    </button>
    <div class="dropdown-content">
      <a href="../pages/profile.php?userId=<?=$session->getId()?>">Profile</a>
      <a href="../actions/user_actions/action_logout.php">Sign out</a>
    </div>
  </div>
<?php } ?>