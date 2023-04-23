<?php function drawDepartments($departments){
?>
<!DOCTYPE html>
<html>
    <div class="departments">
        <ul>
        <?php
            foreach ($departments as $department){ 
                ?>
                
                <li> <?=$department['category']?></li>

            <?php } 
        ?>
        </ul>
    </div>
    
</html> <?php } ?>