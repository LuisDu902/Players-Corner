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