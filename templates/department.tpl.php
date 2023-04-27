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
function drawDepartment($department, $tickets, $members)
{ ?>
    <div class="departments-bar">
        <span>
            <?= $department->category ?>
        </span>
    </div>
    <div class="department-content">
        <div class="tickets-container">
            <h3>Trouble Tickets</h3>
            <div class="tickets">

            <?php foreach ($tickets as $ticket): ?>
                         <span>
                            <?= $ticket->title ?>
                        </span>
                <?php endforeach; ?>
            </div>

        </div>
        <div class="members-container">
            <h3>Members</h3>
            <div class="members buttons">
                <?php foreach ($members as $member): ?>
                    <button class="member">
                        <img src=<?= $member->getPhoto() ?> alt="profile"></img>
                        <span><?= $member->name ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="modal member-modal"></div>
        </div>
    </div>
<?php } ?>

<?php function drawDepartmentModal()
{ ?>
    <div id="department-modal" class="modal">
        <div class="modal-content" id="department-modal-content">
            <span class="modal-title"> Add new Department </span>
            <form action="../actions/action_add_new_department.php" method="post" enctype="multipart/form-data">
                <input type="text" name="new_category" required="required" placeholder="Department's name"
                    id="department-name">
                <img id="dep-image-preview" src="../images/departments/default.png" alt="">
                <input type="file" id="dep-image" name="departmentImage"><br>
                <input type="submit" value="Confirm" class="authentication-button">
            </form>
        </div>
    </div>
<?php } ?>
