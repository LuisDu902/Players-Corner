<?php function drawTicketForm($departments_get,$tags_get){?>
    <head>
    <link rel="stylesheet" href="../css/create_ticket.css">
    <link rel="stylesheet" href="../css/style.css">
    </head>
    
    <div class="createTicket">
        <form action="../actions/action_ticket.php" method="post">
            <div class="title">
                <h2>Title</h2>
                <h6>Be as specific and clear as possible </h6>
                <input type="text" name="title" required="required" placeholder="e.g. Selling item x gives more gold than its supposed to" maxlength="50">
            </div>
            <div class="departments-choice">
                <h3> Department </h3>
                <select name="department">
                       <?php foreach($departments_get as $department){?>
                            <option value="<?php echo $department->category ?>"> <?php echo $department->category?> </option>
                       <?php } ?>
                </select>
            </div>
            <div class="tags-choice">
                <h3> Tags </h3>
                <input list="Tags" name="tags" id="tags" >
                <datalist id="Tags">
                    <?php foreach($tags_get as $tag){?>
                        <option value=<?php echo $tag?>></option>
                    <?php } ?>
                </datalist>
                
                
                
            </div>
            <div class="description">
                <h2> Description </h2>
                <h6> Tell us the details of your problem.</h6>
                <textarea id="description" name="description" required="required" rows="4" cols="40"></textarea><br>
            </div>
            
            
            <button type="submit" class="create-Ticket"><span>Create Ticket</span></button>
        </form>
    </div>
    <?php

  
} ?>
<?php function getTags($db) {
    $stmt = $db->prepare('SELECT  DISTINCT tag FROM TicketTag');
    $stmt->execute();
    return $stmt->fetchAll();
  }
?>
