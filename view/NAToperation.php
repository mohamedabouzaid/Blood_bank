<?php
/**
 * Created by PhpStorm.
 * User: abouzaid
 * Date: 2/13/2018
 * Time: 1:28 AM
 */
session_start();
if(isset($_SESSION['userName']) && $_SESSION['job']=='NAT')
{
    if(isset($_POST['save']))
    {
        include "../model/NATmodel.php";
    $result= NATmodel::insert($_POST['unitNo'],$_POST['HBV'],$_POST['HCV'],$_POST['HIV']);
     echo $result;
    }
    else {




        ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <meta charset="UTF-8">
            <title>NAT Department</title>
        </head>


    <body>


    <div class="w3-bar w3-light-grey">
        <a href="NAT.php" class="w3-bar-item w3-button">NAT Department Home</a>     <!-- NAT Department home button -->

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
    include "../model/NATmodel.php";
    $search=NATmodel::search($_GET['unit']);
    if($search){

        echo "Result already inserted";
        die();

    }

    ?>





    <h3><?php echo 'Unit NO:  ' . $_GET['unit'] ?> </h3>
    <h5>Enter the Result of Test: </h5>
    <form method="post" action="">
        HBV:<br>
        <input type="radio" name="HBV" value="Reactive"> Reactive<br>
        <input type="radio" name="HBV" value="Non_Reactive">Non Reactive<br><br>

        HCV:<br>
        <input type="radio" name="HCV" value="Reactive"> Reactive<br>
        <input type="radio" name="HCV" value="Non_Reactive">Non Reactive<br><br>

        HIV:<br>
        <input type="radio" name="HIV" value="Reactive"> Reactive<br>
        <input type="radio" name="HIV" value="Non_Reactive">Non Reactive<br><br>
        <input type="hidden" name="unitNo" value="<?php echo $_GET['unit'] ?> ">

        <input type="submit" value="Save" name="save">


    </form>



        <?php


    }
}

//no permission to access page
else{

    header('location:Login.php');

}