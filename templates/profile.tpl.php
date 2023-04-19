<?php function drawProfile(User $user)
{ ?>
    <div class="user-profile-container">
        <div class="user-profile round-wrap">
            <img src="../images/profile.png" alt="user-profile">
            <span> <?=$user->username?> </span>
            <a href="../pages/profile.edit.php" id="edit-button"> Edit profile</a>
        </div>
<?php } ?>


<?php function drawEditUserForm() { ?>
    <section id="edit-profile">
        <h1>Edit profile</h1>
        <form action="../actions/action_edit_profile.php" method="post">
            <label>Name: <input type="text" name="name" required="required" value="<?=htmlentities($_SESSION['input']['nome oldUser'])?>"></label>
            <label>Username: <input type="text" name="username" required="required" value="<?=htmlentities($_SESSION['input']['morada oldUser'])?>"></label>
            <label>Email: <input type="email" name="email" required="required" value="<?=$_SESSION['input']['telemovel oldUser']?>"></label>
            <label>Password: <input type="text" name="password" required="required" value="<?=htmlentities($_SESSION['input']['email oldUser'])?>"></label>
            <label>New password: <input type="new-password" name="password1"></label>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input id="button" type="submit" value="Concluir edição" >
        </form>
        <form action="../actions/uploadProfileImage.action.php" method="post" enctype="multipart/form-data">
          <label>Profile photo: <input type="file" name="image"></label>
          <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
          <input type="submit" value="Upload">
        </form>
    </section> 
<?php } ?>