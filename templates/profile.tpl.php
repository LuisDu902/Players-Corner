<?php function drawProfile(Session $session)
{ ?>



    <div class="user-profile-container">
        <div class="user-profile">
            <div class="user-avatar-container">
                <img src="../images/profile.png" alt="user-profile">
            </div>
            <a href="../pages/index.php" id="edit-button">
                <span>Edit profile</span>
            </a>
            <div class="user-details">
                <ul>
                    <li> <span class="highlight">username</span> : <?=$session->getName()?> </li>
                    <li> <span class="highlight">email</span> : <?=$session->getName()?>  </li>
                    <li> <span class="highlight">type</span> : <?=$session->getName()?>  </li>
                </ul>
            </div>
        </div>
        <nav class="navbar">
            <ul>
            <li>Overview</li>
            <li>My Tickets</li>
            <li>Pending messages</li>
            <li>Stars</li>
            </ul>
        </nav>
        <div class="overview">
            <span> to be implement...</span>
        </div>
        <div class="my-tickets">
            <span> to be implement...</span>
        </div>
        <div class="messages">
            <span> to be implement...</span>
        </div>
        <div class="stars">
            <span> to be implement...</span>
        </div>
    </div>

<?php } ?>