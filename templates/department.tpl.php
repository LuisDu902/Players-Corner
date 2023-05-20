<?php function drawDepartments(session $session, array $departments){ ?>
    <h1 class="heading-title">Categories</h1>
         <?php if ($session->getRole() === "admin") { ?>
            <div class="button-wrap round-border gradient"><button id="add-department">Add new department</button></div>
            <?php  drawDepartmentModal() ;
        } ?>
         <div class="departments">
            <?php foreach ($departments as $department): ?>
            <a href="../pages/department.php?category=<?= $department->category ?>" class="department-card">
                <img src=<?= $department->getPhoto() ?> alt="department image" class="white-border round-border"></img>
                <span> <?= $department->category ?> </span>
            </a>
        <?php endforeach; ?>
    </div>
<?php } ?>



<?php
function drawDepartment(bool $hasAccess, Department $department)
{ ?>
    <section class="department">
    <header id="department-title"><?= $department->category ?></header>
    <?php if ($hasAccess) { ?>
        <section id="department-stats" class="container">
        <article class="round-border" id="dept-ticket-status">
            <h3>Tickets by status</h3>
            <canvas id="dept-status" class="graphics"></canvas>
        </article>
        <article class="round-border" id="dept-ticket-priority">
            <h3>Tickets by priority</h3>
            <canvas id="dept-priority" class="graphics"></canvas>
        </article>
        <article class="round-border vert-flex" id="dept-members">
            <h3>Members</h3>   
           <?php drawMembers($department->members); ?>
        </article>

    </section>
   
    <section id="department-tickets">
        <header> Tickets </header>
        <?php } ?>
        <?php drawTickets($department->tickets); ?>
    </section>
    <form action="../actions/department_actions/action_remove_department.php" method="POST">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="hidden" id="category" name="category" value="<?=$department->category?>" required>
        <div class="button-wrap gradient round-border"> <button type="submit">Remove department</button> </div>
    </form>
    </section>
<?php } ?>

<?php function drawDepartmentModal()
{ ?>
    <div id="department-modal" class="modal">
        <div class="modal-content white-border round-border vert-flex center" id="department-modal-content">
            <span class="modal-title"> Add new Department </span>
            <form action="../actions/department_actions/action_add_new_department.php" method="post" enctype="multipart/form-data">
                <input type="text" name="new_category" required="required" placeholder="Department's name" id="department-name" class="white-border round-border">
                <img id="dep-image-preview" src="../images/departments/default.png" alt="" class="white-border round-border">
                <input type="file" id="dep-image" name="departmentImage"><br>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <div class="button-wrap gradient round-border auth-button"> <button type="submit" >Confirm</button> </div>
            </form>
        </div>
    </div>
<?php } ?>


