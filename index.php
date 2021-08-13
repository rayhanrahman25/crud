<?php
require_once "inc/functions.php";
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';
if('seed' == $task){
    seed();
    $info = "Seeding is complete";
}
if('delete' == $task){
    $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_STRING);
    if($id>0){
        deleteStudent($id);
        header( 'location: /crud/index.php?task=report' );
    }
}
$fname = '';
$lname = '';
$roll = '';
if(isset($_POST['submit'])){
    $fname = filter_input(INPUT_POST,'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST,'lname', FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST,'roll', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    if($id){
        if($fname != '' && $lname != '' && $roll != ''){
           $result =  editNupdate($id, $fname,$lname,$roll);
           if($result){
            header( 'location: /crud/index.php?task=report' );
           }else{
            header( 'location: /crud/index.php?task=dulicate&error=1' );
           }
           
        }
    }else{
        if($fname != '' && $lname != '' && $roll != ''){
            $result =  addOneStudent($fname, $lname, $roll);
            if($result){
             header( 'location: /crud/index.php?task=report' );
            }else{
             header( 'location: /crud/index.php?task=dulicate&error=1' );
            }
         }
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Example</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="column column-60 column-offset-20">
            <h2> CRUD</h2>
            <p>A sample project to perform CRUD operations using plain files and PHP</p>
            <?php include_once ('inc/templates/nav.php'); ?>
            <hr/>
           <?php if($info != ''):?>
            <blockquote>
                <?php echo $info ?>
            </blockquote>
           <?php endif; ?>
           <?php if('1' == $error):?>
            <blockquote>
               <?php echo "This roll number exist already try someting different"; ?>
            </blockquote>
           <?php endif; ?>
           
        </div>
    </div>
    <?php if('report' == $task): ?>
    <div class="row">
        <div class="column column-60 column-offset-20">
           <?php 
           addStudent();
           ?>
        </div>
   <?php endif; ?>
<?php if('add'== $task): ?>
    <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="/crud/index.php?task=add" method="POST">
                <label for="fname">First Name</label>   
                <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">
                <label for="roll">Roll</label>
                <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>">
                <button type="submit" class="button-primary" name="submit">Save</button>
            </form>
            </div>
        </div>
<?php endif; ?>

<?php if('edit'== $task): 
 $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
 $student = editStudent($id);
if($student):
?>  
    <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="/crud/index.php?task=edit" method="POST">
                <input type="hidden" value="<?php echo $id ?>" name="id">
                <label for="fname">First Name</label>   
                <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" value="<?php echo $student['lname']; ?>">
                <label for="roll">Roll</label>
                <input type="number" name="roll" id="roll" value="<?php echo $student['roll'] ?>">
                <button type="submit" class="button-primary" name="submit">Update</button>
            </form>
            </div>
        </div>
<?php endif; endif;?>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>