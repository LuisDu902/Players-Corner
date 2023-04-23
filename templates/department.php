<?php function drawDepartments($departments)
{ ?>
    <div class="departments-bar">
        <span>Departments</span>
        <button id="myBtn">Add new department</button>
    </div>

    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="../actions/action_add_department.php" method="post" enctype="multipart/form-data">

                <input type="text" name="name" required="required" placeholder="Department's name" id="department-name">
                <img id="image-preview" src="../images/profiles/default.png" alt="">
                <input type="file" id="image" name="image" id="upload-dpt-img"><br>
                <input type="submit" value="Add Department" class="authentication-button">
            </form>
        </div>

    </div>

    <div class="departments">
        <?php foreach ($departments as $department): ?>

            <a href="../pages/index.php" class="department">
                <img src="../images/departments/image.png" alt="department image"></img>
                <span>
                    <?= $department->category ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

<?php } ?>