<?php function drawClients($clients){?>
    <div class="users-row">
  <?php foreach ($clients as $client): ?>
    <div class="user-box">
      <a href="/user-profile.php?userId=<?= $client->name ?>">
        
        <h3><?= $client->username ?></h3>
        <p><?= $client->email ?></p>
        <p><?= $client->reputation ?></p>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<?php } ?>