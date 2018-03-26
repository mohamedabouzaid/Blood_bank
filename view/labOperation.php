<?php

session_start();
if(isset($_SESSION['userName']) && $_SESSION['job']=='lab' || $_SESSION['job']=='admin')
{
    if(isset($_POST['save']))
    {
        include "../model/malaria.php";
        //insert
        if($_POST['do']=='insert'){
            $result= malaria::insert($_POST['unitNo'],$_POST['test'],$_POST['confirmation']);}
        //update
        else{ $result= malaria::update($_POST['unitNo'],$_POST['test'],$_POST['confirmation']);}
        $_SESSION['operation']= $result;
        header('location:NAT.php');
    }
    else {




        ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <meta charset="UTF-8">
            <title>lab Department</title>
        </head>


        <body>


        <div class="w3-bar w3-light-grey">
            <a href="lab.php" class="w3-bar-item w3-button">lab Department Home</a>     <!-- lab Department home button -->

            <div class="w3-dropdown-hover">
                <!-- user name -->
                <button class="w3-button"><?php echo $_SESSION['userName'] ?></button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a href="../controller/user/Logoutcontroller.php" class="w3-bar-item w3-button"> logout</a>
                    <!-- logout button -->
                </div>
            </div>


        </div>

        <?php
        // already inserted
        include "../model/malaria.php";
        $search=malaria::search($_GET['unit']);
        if($search){
            //update
            if($_GET['do']=='update') {

                $edit = $search[0];

            }
            //insert
            else{
                echo "Result already inserted";
                die();}

        }
        else{

            if($_GET['do']=='update'){

                echo "no data entered ";
                die();}

        }

    }

    ?>




<!--malaria-->
    <h3><?php echo 'Unit NO:  ' . $_GET['unit'] ?> </h3>
    <h5> Malaria: </h5>
    <form method="post" action="">
        test<br>
        Positive<input type="radio" name="test" value="Positive" <?php if(isset($edit)&&$edit['test']=='Positive')
        {echo 'checked';} ?>> <br>
        Negative<input type="radio" name="test" value="Negative" <?php if(isset($edit)&&$edit['test']=='Negative')
        {echo 'checked';} ?>><br>
        Confirmation<br>
        Think film<br>
        <input type="radio" name="confirmation" value="Seen" <?php if(isset($edit)&&$edit['confirmation']=='Seen')
        {echo 'checked';} ?>> Seen<br>
        <input type="radio" name="confirmation" value="Not Seen" <?php if(isset($edit)&&$edit['confirmation']=='Not Seen')
        {echo 'checked';} ?>>Not seen<br><br>







        <input type="hidden" name="do" value="<?php echo $_GET['do']; ?>">
        <input type="hidden" name="unitNo" value="<?php echo $_GET['unit'] ?> ">

        <input type="submit" value="Save" name="save">


    </form>



    <?php



}

//no permission to access page
else{

    header('location:Login.php');

}