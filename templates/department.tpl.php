

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
            
            <?php if (!empty($department->members)){
                foreach ($department->members as $member): ?>
                <a href="../pages/profile.php?userId=<?=$member->userId?>" class="dept-member">
                    <img src=<?= $member->getPhoto() ?> alt="member image" class="gradient circle-border" id="dept-members-img"> 
                    <span class="center"> <?= $member->name?> </span>
                </a>
                <?php endforeach; }
            else { ?>
                <img src="../images/icons/not-found.png" class="no-background no-members">
                <h4 class="center warning no-background">No members yet</h4>
            <?php }
                ?>
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
