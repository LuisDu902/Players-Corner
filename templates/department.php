<?php function drawDepartments($departments)
{ ?>
    <div class="departments-bar">
        <span>Departments</span>
        <button id="add-department">Add new department</button>
    </div>

    <?php drawDepartmentModal() ?>

    <div class="departments">
        <?php foreach ($departments as $department): ?>
            <a href="../pages/department.php?category=<?= $department->category ?>" class="department">
                <img src=<?= $department->getPhoto() ?> alt="department image"></img>
                <span>
                    <?= $department->category ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

<?php } ?>


<?php
function drawDepartment($department, $members)
{ ?>
    <div class="departments-bar">
        <span>
            <?= $department->category ?>
        </span>
    </div>
    <div class="department-content">
        <div class="tickets-container">
            <h3>Trouble Tickets</h3>
            <div class="tickets"></div>
        </div>
        <div class="members-container">
            <h3>Members</h3>
            <div class="members">
                <?php foreach ($members as $member): ?>
                    <a href="../pages/profile.php" class="member buttons">
                        <img src=<?= $member->getPhoto() ?> alt="profile" class="member-img "></img>
                        <span>
                            <?= $member->name ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
            <button id="add-member-container">Add new member</button>
        </div>
    </div>

<?php } ?>

<?php function drawDepartmentModal()
{ ?>
    <div id="department-modal" class="modal">
        <div class="modal-content">
            <span class="modal-title"> Add new Department </span>
            <form action="../actions/action_add_department.php" method="post" enctype="multipart/form-data">
                <input type="text" name="new_category" required="required" placeholder="Department's name"
                    id="department-name">
                <img id="dep-image-preview" src="../images/departments/default.png" alt="">
                <input type="file" id="dep-image" name="departmentImage"><br>
                <input type="submit" value="Confirm" class="authentication-button">
            </form>
        </div>
    </div>
<?php } ?>


<?php function drawAssignableDepartments($departments, $userId)
{ ?>
    <form action="../actions/action_assign_departments.php" method="POST" id="assign-department-form">
        <div class="departments" id="assign-departments">
            <?php foreach ($departments as $department): ?>
                <div class="department" id="department">
                    <img src=<?= $department->getPhoto() ?> alt=<?= $department->category ?>></img>
                    <span>
                        <?= $department->category ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" name="assign" id="assign-button" class="button-wrap">Assign</button>
        <input type="hidden" name="selected_departments" id="selected-departments">
        <input type="hidden" name="userId" id=<?= $userId ?> value=<?= $userId ?>>
    </form>
<?php } ?>