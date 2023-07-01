<?php

if(isset($_POST['roll_no'])){
    ?>
        <iframe src="pdf.php?roll_no=<?php echo $_POST['roll_no'] ?>" frameborder="0"></iframe>
    <?php
}

?>

<form action="#" method="POST">
    <input type="text" name="roll_no" placeholder="Enter Roll No">
    <input type="submit" value="Generate">
</form>