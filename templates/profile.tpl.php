<?php function drawProfile(User $user)
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
                <table>
                    <tr>
                        <th>
                        <span class="highlight">username :</span> 
                        </th>
                        <th>
                        <?=$user->username?> 
                        </th>
                    </tr>
                    <tr>
                        <th>
                        <span class="highlight">email :</span> 
                        </th>
                        <th>
                        <?=$user->username?> 
                        </th>
                    </tr>
                    <tr>
                        <th>
                        <span class="highlight">type :</span> 
                        </th>
                        <th>
                        <?=$user->type?> 
                        </th>
                    </tr>
                </table>
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