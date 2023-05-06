<?php function drawDepartments($departments)
{ ?>
    <div class="departments-bar">
        <span>Departments</span>
        <div class="button-wrap round-border gradient"><button id="add-department">Add new department</button></div>
    </div>

    <?php drawDepartmentModal() ?>

    <div class="departments">
        <?php foreach ($departments as $department): ?>
            <a href="../pages/department.php?category=<?= $department->category ?>" class="department">
                <img src=<?= $department->getPhoto() ?> alt="department image" class="white-border round-border"></img>
                <span>
                    <?= $department->category ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

<?php } ?>


<?php
function drawDepartment($department, $tickets, $members)
{ ?>
    <span class="department-title"> <?= $department->category ?> </span>
            
<?php } ?>

<?php function drawDepartmentModal()
{ ?>
    <div id="department-modal" class="modal">
        <div class="modal-content white-border round-border vert-flex center" id="department-modal-content">
            <span class="modal-title"> Add new Department </span>
            <form action="../actions/department_actions/action_add_new_department.php" method="post" enctype="multipart/form-data">
                <input type="text" name="new_category" required="required" placeholder="Department's name"
                    id="department-name" class="white-border round-border">
                <img id="dep-image-preview" src="../images/departments/default.png" alt="" class="white-border round-border">
                <input type="file" id="dep-image" name="departmentImage"><br>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <div class="button-wrap gradient round-border auth-button"> <button type="submit" >Confirm</button> </div>

            </form>
        </div>
    </div>
<?php } ?>
