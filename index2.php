<!-- Created by:
Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 1 March 2016
-->
<html>

<head>
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
    // $dataArray= json_encode($dataArray);
    /*print $dataArray2;*/
    //$mysqli_free_result($qresult);
    ?>
    <title>RPi Pool Controller</title>
    <link rel="stylesheet" href="styles.css">
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="graph/tempGauges.js"></script>
    <script type="text/javascript" src="graph/hourTempGraph.js"></script>



    <script type="text/javascript">
        $(document).ready(function(){
            $('#myonoffswitch').click(function(){
                var myonoffswitch=$('#myonoffswitch').val();
                if ($("#myonoffswitch:checked").length == 0) {
                    var a="off";
                }
                else {
                    var a="on";
                }
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: "value="+a ,
                    success: function(html){
                        $("#display").html(html).show();
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#myonoffswitch2').click(function(){
                var myonoffswitch=$('#myonoffswitch2').val();
                if ($("#myonoffswitch2:checked").length == 0) {
                    var a="off";
                }
                else {
                    var a="on";
                }

                $.ajax({
                    type: "POST",
                    url: "ledcontrol2.php",
                    data: "value="+a ,
                    success: function(html){
                        $("#display").html(html).show();
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready( function(){
            $(".cb-enable").click(function(){
                var parent = $(this).parents('.switch');
                $('.cb-disable',parent).removeClass('selected');
                $(this).addClass('selected');
                $('.checkbox',parent).attr('checked', true);
            });
            $(".cb-disable").click(function(){
                var parent = $(this).parents('.switch');
                $('.cb-enable',parent).removeClass('selected');
                $(this).addClass('selected');
                $('.checkbox',parent).attr('checked', false);
            });
        });
    </script>
</head>

<body>

  <div id="dashboard">
        <div id="header">
            <h1>Raspberry Pi Pool Controller</h1>
            <h1>
                <iframe src="http://free.timeanddate.com/clock/i52vnyfd/n184/fcfff/tct/pct/ftb/tt0/tw1/tm1" frameborder="0" width="227" height="18" allowTransparency="true"></iframe>
            </h1>
    
        </div>
        <div id="widgets">
            <div class="tile">
                <h4>Temperature</h4>
                <div id="tempGauges">
                </div>
            </div>
            <div class="tile">
                <div class="buttonContainer">
                    <h4>Heater</h4>
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch"/>
                        <?php
                        $query3="select * from choice where id=1";
                        $qresult = $mysqli->query($query3);
                        if($qresult['choice']=="on") {
                            echo "checked";
                        }
                        ?>
    
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label></div>
                </div>
    
                <div class="buttonContainer">
                    <h4>Pump</h4>
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch2" class="onoffswitch-checkbox" id="myonoffswitch2"/>
                        <?php
                        $query3="select * from choice where id=2";
                        $qresult = $mysqli->query($query3);
                        if($qresult['choice']=="on") {
                            echo "checked";
                        }
                        ?>
                        <label class="onoffswitch-label" for="myonoffswitch2">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="doublewidthTile"><div id="tempChart"></div></div>
            <div class="doublewidthTile">Graph</div>
        </div>
    </div>
</body>
</html>
