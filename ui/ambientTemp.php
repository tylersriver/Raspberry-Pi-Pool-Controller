    <?php
    $servername = "173.194.86.153";
    $username = "pi";
    $password = "rn4R9EfAarJpY5VwY8rnBlL2";
    $dbname = "temp_db";
    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
  //  echo "Connected successfully";
//

    $query = "SELECT `tempLog`.`temperature`\n"
        . "FROM tempLog\n"
        . "ORDER BY `tempLog`.`datetime` DESC\n"
        . " LIMIT 1, 1 ";
    $qresult = $mysqli->query($query);
    $table = array();

    $query2 = "SELECT `waterTemp`.`temperature`\n"
        . "FROM waterTemp\n"
        . "ORDER BY `waterTemp`.`datetime` DESC\n"
        . " LIMIT 1, 1 ";

    $qresult2 = $mysqli->query($query2);

  //  $dataArray = array(array('temperature'));
    while($row = mysqli_fetch_array($qresult)) {
        // parse the "SpeciesA" and "SpeciesB" values as integer (int) or floating point (float), as appropriate
        $dataArray= (float) $row['temperature'];
    }
    while($row = mysqli_fetch_array($qresult2)) {
        // parse the "SpeciesA" and "SpeciesB" values as integer (int) or floating point (float), as appropriate
        $dataArray2 = (float) $row['temperature'];
    }


$advert = array(
        'airTemp' => $dataArray,
        'waterTemp' => $dataArray2,
     );
    echo json_encode($advert);
    
    //$mysqli_free_result($qresult);
    ?>