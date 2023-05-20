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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
   
    <script src="../javascript/preview_image.js" defer></script>
    <script src="../javascript/drop_menus.js" defer></script>

    <script src="../javascript/user/search_users.js" defer></script>
    <script src="../javascript/user/upgrade_user.js" defer></script>

    <script src="../javascript/department/add_new_department.js" defer></script>
    <script src="../javascript/department/assign_to_departments.js" defer></script>

    <script src="../javascript/charts/chart.js" defer></script>
    <script src="../javascript/charts/user_charts.js" defer></script>
    <script src="../javascript/charts/dept_charts.js" defer></script>
    <script src="../javascript/charts/ticket_charts.js" defer></script>

    <script src="../javascript/ticket/add_message.js" defer></script>
    <script src="../javascript/ticket/answer_with_faq.js" defer></script>
    <script src="../javascript/ticket/attach_file.js" defer></script>
    <script src="../javascript/ticket/autocomplete_tags.js" defer></script>
    <script src="../javascript/ticket/feedback.js" defer></script>
    <script src="../javascript/ticket/search_tickets.js" defer></script>

    <script src="../javascript/faq/add_new_faq.js" defer></script>
    <script src="../javascript/faq/load_more_faq.js" defer></script>
    <script src="../javascript/faq/search_faq.js" defer></script>

   </head>

  <body data-csrf="<?= $_SESSION['csrf'] ?>">
    <header id="header">
      <a href="../pages/index.php"><img class="logo" src="../images/icons/logo.png" alt="logo"> </a>
      <nav>
        <ul class="nav_links">
          <li class="home"> <a href="../pages/index.php">Home</a></li>
          <li class="Users"><a href="../pages/tickets.php">Forum</a></li>
          <li class="FAQ"><a href="../pages/faq.php">FAQ</a></li>
          <?php
          if ($session->isLoggedIn()) { ?>
            <li class="create-Ticket"><a href="../pages/create_ticket.php">Create Tickets</a></li>
          <?php
          } ?>

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
    <footer>
      <section class="footer-top">
      <h3>Contact Us</h3>
      <ul class="socials">
        <li><a class="white-border" href="https://www.facebook.com/NIAEFEUP" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a></li>
        <li ><a class="white-border" href="https://www.instagram.com/niaefeup/" target="_blank"><ion-icon name="logo-instagram"></ion-icon></a></li>
        <li ><a class="white-border" href="https://twitter.com/niaefeup" target="_blank"><ion-icon name="logo-twitter"></ion-icon></a></li>
        <li ><a class="white-border" href="https://www.linkedin.com/company/sinffeup/" target="_blank"><ion-icon name="logo-linkedin"></ion-icon></a></li>
      </ul>
      </section>
      <section class="footer-copyright">
        <p>LTW Project &copy; 2023 | Developed by: ltw13g04</p>
      </section>
    </footer>
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
  <ul class="buttons">
    <li class="button-wrap gradient round-border">
      <a href="../pages/login.php"><button>Sign In</button></a>
    </li>
    <li class="button-wrap gradient round-border">
      <a href="../pages/register.php"><button>Sign Up</button></a>
    </li>
  </ul>
<?php } ?>


<?php function drawProfileButton(Session $session)
{ ?>
  <div class="dropdown">
    <button class="dropbtn center">
      <img src=<?= $session->getPhoto() ?> alt="user-profile" class="gradient circle-border">
      <strong class="username"> <?= $session->getName() ?> </strong>
    </button>
    <div class="dropdown-content">
      <a href="../pages/profile.php?userId=<?= $session->getId() ?>">Profile</a>
      <a href="../pages/user_tickets.php?userId=<?= $session->getId() ?>">My tickets</a>
      <a href="../actions/user_actions/action_logout.php">Sign out</a>
    </div>
  </div>
<?php } ?>