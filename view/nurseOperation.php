<?php


session_start();

if(isset($_SESSION['userName']) && $_SESSION['job']=='Nurse') {


    if (isset($_POST['insert'])) {
//the comment


        if (!empty($_POST['comments_list'])) {
            $comment = implode('-', $_POST['comments_list']);
        } else {
            $comment = "other";
        }

//insert data of blood
        include '../model/NurseModel.php';
        $result = NurseModel::insert($_POST['ID_Blood'], $_POST['NID'], $_POST['bagWeight'],
            $_POST['bloodGroup'], $_POST['time'], $comment,$_POST['performed'],
            $_POST['approved'],$_POST['signature']);

        $_SESSION['operation']=$result;
        header("location:nurse.php");

    }




    elseif (isset($_POST['edit'])) {
//the comment
        if (!empty($_POST['comments_list'])) {
            $comment = implode('-', $_POST['comments_list']);
        } else {
            $comment = "other";
        }

//update data of blood
        include '../model/NurseModel.php';
        $result = NurseModel::update($_POST['ID_Blood'], $_POST['NID'], $_POST['bagWeight'],
            $_POST['bloodGroup'], $_POST['time'], $comment,$_POST['performed'],
            $_POST['approved'],$_POST['signature']);

        $_SESSION['operation']=$result;
        header("location:nurse.php");

    }



    else {


        ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
            <meta charset="UTF-8">
            <title>Clinic</title>
        </head>


    <body>


        <div class="w3-bar w3-light-grey">
            <a href="nurse.php" class="w3-bar-item w3-button">Nurse Home</a>     <!-- nurse home button -->
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
        if($_GET['do']=='insert'){
        //is already inserted
        include '../model/NurseModel.php';
        $check = NurseModel::search($_GET['nid']);
        if ($check) {
        echo "Blood is already inserted";
           die();

        }}

        else {
            include '../model/NurseModel.php';
            $edits = NurseModel::search($_GET['nid']);
            $edit=$edits[0];



            }

            ?>

            <h3>Blood sample of <?php echo $_GET['nid']; ?></h3>
            <!--form of blood information-->
            <form action="" method="post">

                <input type="radio" name="NID" required <?php if(isset($edit)){ echo"checked" ;}?>>Checked ID<br>
                Start time <i class="glyphicon glyphicon-time" id="start"></i> &nbsp; &nbsp; &nbsp;
                Stop time <i class="glyphicon glyphicon-time" id="time"></i><br>
                Sealed by ID<input type="number" name="ID_Blood" <?php if(isset($edit)){ echo "value='".$edit['ID']."'" ;}?>><br>
                Bag Weight <input type="number" name="bagWeight"<?php if(isset($edit)){ echo "value='".$edit['bagWeight']."'" ;}?>><br>
                Time of collections<input type="time" name="time"<?php if(isset($edit)){ echo "value='".$edit['timeCollection']."'" ;}?>><br>
                Performed By<input type="text" name="performed"<?php if(isset($edit)){ echo "value='".$edit['performed']."'" ;}?>><br>
                Approved By<input type="text" name="approved"<?php if(isset($edit)){ echo "value='".$edit['approved']."'" ;}?>><br>
                Signature<input type="text" name="signature"<?php if(isset($edit)){ echo "value='".$edit['signature']."'" ;}?>><br>
                Confirmed Blood Group

             <select required name="bloodGroup">
                 <?php if(isset($edit)) {echo '<option value="'.$edit['bloodGroup'].'">'.$edit['bloodGroup'].'</option>';}?>
                    <option value="A−"> A−</option>
                    <option value="A+">A+</option>
                    <option value="B−">B−</option>
                    <option value="B+">B+</option>
                    <option value="AB−">AB−</option>
                    <option value="AB+">AB+</option>
                    <option value="O−">O−</option>
                    <option value="O+">O+</option>

                </select><br>

                 <?php if (isset($edit)){$comments= explode('-', $edit['comment']);
                 } ?>
                <h5>Comments</h5>
                <input type="checkbox" name="comments_list[]" value="Slow bleed"> Slow bleed<br>
                <input type="checkbox" name="comments_list[]" value=" Aspirin"> Aspirin<br>
                <input type="checkbox" name="comments_list[]" value="Relative"> Relative<br>
                <input type="checkbox" name="comments_list[]" value="Other" > Other<br>
                <input type="hidden" name="NID" value="<?php echo $_GET['nid']; ?>">
                <input type="submit" value="Save" <?php if(isset($edit)){ echo "name='edit'" ;}
                else{echo "name='insert'" ;}?>>

            </form>


            <script>

                //timer
                function checkTime(i) {
                    if (i < 10) {
                        i = "0" + i;
                    }
                    return i;
                }

                function endTime() {
                    var today = new Date();
                    var h = today.getHours();
                    var m = today.getMinutes();
                    var s = today.getSeconds();
                    // add a zero in front of numbers<10
                    m = checkTime(m);
                    s = checkTime(s);
                    document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
                    t = setTimeout(function () {
                        endTime()
                    }, 500);
                }

                endTime();


                function startTime() {
                    var today = new Date();
                    var h = today.getHours();
                    var m = today.getMinutes();
                    var s = today.getSeconds();
                    // add a zero in front of numbers<10
                    m = checkTime(m);
                    s = checkTime(s);
                    document.getElementById('start').innerHTML = h + ":" + m + ":" + s;

                }

                startTime();


            </script>


            <?php


        }

        }





//no permission to access page
else{

    header('location:Login.php');

}