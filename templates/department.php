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
            <form action="add_department.php" method="post" enctype="multipart/form-data">
                <label for="name">Department Name:</label>
                <input type="text" id="name" name="name"><br><br>
                <label for="image">Department Image:</label>
                <input type="file" id="image" name="image"><br><br>
                <input type="submit" value="Add Department">
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