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


          $startTime = $_POST["startTime"] . ":00";
          $stopTime = $_POST["stopTime"] . ":00";

          $daysArray = $_POST["days"];

          foreach ($daysArray as &$day) {
              switch ($day) {
                  case "Monday":
                      $dayNum = "0";
                      break;
                  case "Tuesday":
                      $dayNum = "1";
                     break;
                  case "Wednesday":
                      $dayNum = "2";
                    break;
                  case "Thursday":
                      $dayNum = "3";
                      break;
                  case "Friday":
                      $dayNum = "4";
                      break;
                  case "Saturday":
                      $dayNum = "5";
                      break;
                  case "Sunday":
                      $dayNum = "6";
                      break;

                  default:
                      $dayNum = "6";
              }

              $sqlQuery = "INSERT INTO schedule (day, start, stop, interrupt) VALUES ('{$dayNum}', '{$startTime}', '{$stopTime}', '0')";
             //    $sqlQuery = "INSERT INTO schedule (day, start, stop) VALUES ('0', '10:15:00', '10:30:00')";

        //      echo $sqlQuery;
              // $sqlQuery = "UPDATE settings SET units = 'C'";
              $queryResult = mysqli_query($con, $sqlQuery);
         //     $qresult = $con->query($sqlQuery);
          //    echo $qresult;
           //   echo "run";


          }

          mysqli_close($con);





?>