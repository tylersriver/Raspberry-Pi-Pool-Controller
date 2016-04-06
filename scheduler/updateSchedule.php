<?php
/**

Raspberry Pi Pool Controller

updateSchedule.php

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 6 April 2016

 */

$db_host = "173.194.86.153";
$db_user = "pi";
$db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
$db_database = "equipment";
$con = new mysqli($db_host, $db_user, $db_password, $db_database);

    if(isset($_POST['value']))
    {

        $value=$_POST['value'];

        if($value == "F")
        {
            //   $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 0");
            echo "Set to F";
        }
        else if($value == "C")
        {
            //  $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 1");
            echo "Set to C";
        }
        else
        {
            $value = 'F';
        }
    }
    $sqlQuery = "UPDATE settings SET units ='{$value}' WHERE 1";
    echo $sqlQuery;
   // $sqlQuery = "UPDATE settings SET units = 'C'";
  //  $queryResult = mysqli_query($con,$sqlQuery);
    $qresult = $con->query($sqlQuery);
    //echo $exec;
    //changes
    mysqli_close($con);
?>