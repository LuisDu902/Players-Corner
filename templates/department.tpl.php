<?php function drawDepartments(session $session, array $departments)
{ ?>
    <h2 class="heading-title">Categories</h2>
    <?php if ($session->getRole() === "admin") { ?>
        <div class="button-wrap round-border gradient"><button id="add-department">Add new department</button></div>
        <?php drawDepartmentModal();
    } ?>
    <section class="departments">
        <?php foreach ($departments as $department): ?>
            <a href="../pages/department.php?category=<?= $department->category ?>" class="department-card">
                <img src=<?= $department->getPhoto() ?> alt="department image" class="white-border round-border"></img>
                <strong>
                    <?= $department->category ?>
                </strong>
            </a>
        <?php endforeach; ?>
    </section>
<?php } ?>



<?php function drawDepartment(Department $department)
{ ?>
    <header class="title" id="department-title"><?= $department->category ?></header>
    <?php if (has_access($department)) { ?>
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
        <?php } ?>
        <section id="department-tickets">
        <?php drawTickets($department->tickets); ?>
    </section>
    <form action="../actions/department_actions/action_remove_department.php" method="POST">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <input type="hidden" id="category" name="category" value="<?= $department->category ?>" required>
        <div class="button-wrap gradient round-border"> <button type="submit">Remove department</button> </div>
    </form>

<?php } ?>

<?php function drawDepartmentModal()
{ ?>
    <div id="department-modal" class="modal">
        <article class="modal-content white-border round-border vert-flex center" id="department-modal-content">
            <h2 class="modal-title"> Add new Department </h2>
            <form action="../actions/department_actions/action_add_new_department.php" method="post"
                enctype="multipart/form-data">
                <input type="text" name="new_category" required="required" placeholder="Department's name"
                    id="department-name" class="white-border round-border">
                <img id="dep-image-preview" src="../images/departments/default.png" alt=""
                    class="white-border round-border">
                <input type="file" id="dep-image" name="departmentImage"><br>
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <div class="button-wrap gradient round-border auth-button"> <button type="submit">Confirm</button> </div>
            </form>
        </article>
    </div>
<?php } ?>