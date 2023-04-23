<?php function drawTicketForm($departments,$tags){?>
    <head>
    <link rel="stylesheet" href="../css/ticket.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script>
        $(function() {
            var availableTags = [<?php foreach($tags as $tag){ echo '"' . $tag['tag'] . '",'; } ?>];
            $('#tags').autocomplete({
                source: availableTags,
                minLength: 0,
                select: function(event, ui) {
                    var terms = this.value.split(', ');
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push('');
                    this.value = terms.join(', ');
                    return false;
                }
            });
        });
    </script>
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
                       <?php foreach($departments as $department){?>
                            <option value="<?php echo $department['category'] ?>"> <?php echo $department['category'] ?> </option>
                       <?php } ?>
                </select>
            </div>
            <div class="tags-choice">
                <h3> Tags </h3>
                <input type="text" name="tags" id="tags" autocomplete="off">
            </div>
            <div class="description">
                <h2> Description </h2>
                <h6> Tell us the details of your problem.</h6>
                <textarea id="description" name="description" required="required" rows="5" cols="40"></textarea><br>
            </div>
            <button type="submit" class="create-Ticket"><span>Create Ticket</span></button>
        </form>
    </div>
<?php } ?>