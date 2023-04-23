<?php function drawDepartments($departments)
{ ?>
    <div class="departments-bar">
        <span>Departments</span>
        <button type="submit">Add new department</button>
  </div>
    <div class = "departments">
    <?php foreach ($departments as $department): ?>
        
        <a href="../pages/index.php"  class="department">
            <img src="../images/departments/image.png" alt="department image"></img>
            <span><?=$department->category?></span>
        </a>
    <?php endforeach; ?>
    </div>
    
<?php } ?>