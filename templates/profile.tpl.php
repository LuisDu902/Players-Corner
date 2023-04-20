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
            <img src="../images/profile.png" alt="user-profile">
            <span>
                <?= $user->username ?>
            </span>
            <a href="../pages/profile.edit.php" id="edit-button"> Edit profile</a>
        </div>
    </div>

<?php } ?>

<?php function drawEditUserForm()
{ ?>
    <div class="user-profile round-wrap">
        <div class="edit-profile">
            <h2 class="register-text">Edit profile</h2>
            </h2>
            <form action="../actions/action_edit_profile.php" method="post" class="authentication-form">
                <div class="input-box">
                    <input type="text" name="name" required="required" placeholder="Name">
                    <img src="../images/user.png" class="icon" alt="user">
                </div>

                <div class="input-box">
                    <input type="email" name="email" required="required" placeholder="Email">
                    <img src="../images/email.png" class="icon" alt="email">
                </div>

                <div class="input-box">
                    <input type="password" name="password" required="required" placeholder="Password">
                    <img src="../images/password.png" class="icon" alt="password">
                </div>

                <div class="input-box">
                    <input type="username" name="username" required="required" placeholder="Username">
                    <img src="../images/username.png" class="icon" alt="username">
                </div>
                <button type="submit" class="authentication-button">Edit</button>
            </form>
        </div>
        <div class="upload-photo round-wrap">
            <form action="../actions/action_upload_image.php" method="post" enctype="multipart/form-data" class="authentication-form">
                <img src="../images/profile.png" alt="user-profile">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <button type="submit" value="upload" class="authentication-button" id="upload">Upload photo</button>
            </form>
        </div>
    </div>
<?php } ?>