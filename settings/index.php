<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 8 March 2016
-->
<head>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1">
    -->
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Angular Libraries Added: 29 March, 2016 Author: Preston Kemp
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-aria.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-messages.min.js"></script>
    <script src="http://ngmaterial.assets.s3.amazonaws.com/svg-assets-cache.js"></script>
    <script src="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.0-rc1/angular-material.js"></script>
        <!--Angular Material Library-->
    <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.js"></script>

    <script>
        var now = new Date(<?php echo time() * 1000 ?>);
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today = mm + '/' + dd + '/' + yyyy;
        function startInterval() {
            setInterval('updateTime();', 1000);
        }
        startInterval();//start it right away
        function updateTime() {
            var nowMS = now.getTime();
            nowMS += 1000;
            now.setTime(nowMS);
            var clock = document.getElementById('clock');
            if (clock) {
                clock.innerHTML = 'System Time: ' + today + ' ' + (now.toTimeString()).split(' ', 1);
            }
        }
    </script>

</head>
<body>

<div id="dashboard">
    <div id="header">
        <div id="header_padding"></div>
        <h1>Settings</h1>
        <div id="widgets">
            <table>
                <td>
                    <div class="nav">
                        <ul><li><div id="clock"></div></li></ul>
                    </div>
                </td>
                <td> <div class="nav">
                        <div class="linkButtons">
                            <ul>

                                <li><a href="/scheduler/index.php" class="button">Scheduler</a></li>
                                <li><a href="/index.php" class="button">Dashboard</a></li>
                                <li><a href="/settings/index.php" class="button">Settings</a></li>
                                <li><a href="/stats/index.php" class="button">Stats</a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </table>
        </div>
    </div>

    <div id="widgets">
        <div class="tile">
            <h4>Temperature Units</h4>
            <ul>
                <li><input id="fahrenheit" type="radio" onClick="fahrenheit(this);" />Fahrenheit</li>
                <li><input id="celsius" type="radio" onClick="celsius(this);"/>Celsius</li>
            </ul>
            <script>
                $(function() {
                    var settings = $.ajax({
                        url: "getState.php",
                        dataType: "json",
                        async: false
                    }).responseText;
                    settings = JSON.parse(settings);
                    console.log(settings);
                    console.log(settings.units);
                    if(settings.units == "F") {
                        document.getElementById('celsius').checked = false;
                        document.getElementById('fahrenheit').checked = true;

                    }
                    else {
                        document.getElementById('fahrenheit').checked = false;
                        document.getElementById('celsius').checked = true;
                    }
                });
            </script>
            <script>
                function fahrenheit(obj) {
                    if (obj.checked == true) {
                        var a = 'F';
                        console.log("F selected");
                        document.getElementById("celsius").checked = false;
                        $.ajax({
                            type: "POST",
                            url: "updateState.php",
                            data: "value=" + a,
                            success: function (html) {
                                $("#display").html(html).show();
                            }
                        });
                    }
                }
                function celsius(obj) {
                    if (obj.checked == true) {
                        var a = 'C';
                        console.log("C selected");
                        document.getElementById("fahrenheit").checked = false;
                        $.ajax({
                            type: "POST",
                            url: "updateState.php",
                            data: "value=" + a,
                            success: function (html) {
                                $("#display").html(html).show();
                            }
                        });
                    }
                }
            </script>
        </div>
        <div class="tile">
            <h4>Manual Temperature Setting</h4>
            <select id="tempSetting">
                <option value="60">60</option>
                <option value="65">65</option>
                <option value="70">70</option>
                <option value="75">75</option>
                <option value="80">80</option>
                <option value="85">85</option>
            </select>
        </div>
        <div class="doublewidthTile">
            <h4>Automatic Water Circulation</h4>
        </div>
        <!--<div class="doublewidthTile">
            <div ng-controller="AppCtrl" ng-cloak="" class="sliderdemoBasicUsage" ng-app="MyApp">
                <md-content style="margin: 16px; padding:16px">

                    <h3>
                        RGB <span ng-attr-style="border: 1px solid #333; background: rgb({{color.red}},{{color.green}},{{color.blue}})">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </h3>

                    <md-slider-container>
                        <span>R</span>
                        <md-slider flex="" min="0" max="255" ng-model="color.red" aria-label="red" id="red-slider">
                        </md-slider>
                        <md-input-container>
                            <input flex="" type="number" ng-model="color.red" aria-label="red" aria-controls="red-slider">
                        </md-input-container>
                    </md-slider-container>

                    <md-slider-container>
                        <span>G</span>
                        <md-slider flex="" ng-model="color.green" min="0" max="255" aria-label="green" id="green-slider" class="md-accent">
                        </md-slider>
                        <md-input-container>
                            <input flex="" type="number" ng-model="color.green" aria-label="green" aria-controls="green-slider">
                        </md-input-container>
                    </md-slider-container>

                    <md-slider-container>
                        <span class="md-body-1">B</span>
                        <md-slider flex="" ng-model="color.blue" min="0" max="255" aria-label="blue" id="blue-slider" class="md-primary">
                        </md-slider>
                        <md-input-container>
                            <input flex="" type="number" ng-model="color.blue" aria-label="blue" aria-controls="blue-slider">
                        </md-input-container>
                    </md-slider-container>

                    <h3>Rating: {{rating}}/5 - demo of theming classes</h3>
                    <div layout="">
                        <div flex="10" layout="" layout-align="center center">
                            <span class="md-body-1">default</span>
                        </div>
                        <md-slider flex="" md-discrete="" ng-model="rating1" step="1" min="1" max="5" aria-label="rating">
                        </md-slider>
                    </div>
                    <div layout="">
                        <div flex="10" layout="" layout-align="center center">
                            <span class="md-body-1">md-warn</span>
                        </div>
                        <md-slider flex="" class="md-warn" md-discrete="" ng-model="rating2" step="1" min="1" max="5" aria-label="rating">
                        </md-slider>
                    </div>
                    <div layout="">
                        <div flex="10" layout="" layout-align="center center">
                            <span class="md-body-1">md-primary</span>
                        </div>
                        <md-slider flex="" class="md-primary" md-discrete="" ng-model="rating3" step="1" min="1" max="5" aria-label="rating">
                        </md-slider>
                    </div>

                    <h3>Disabled</h3>
                    <md-slider-container ng-disabled="isDisabled">
                        <md-icon md-svg-icon="device:brightness-low"></md-icon>
                        <md-slider ng-model="disabled1" aria-label="Disabled 1" flex="" md-discrete="" ng-readonly="readonly"></md-slider>

                        <md-input-container>
                            <input flex="" type="number" ng-model="disabled1" aria-label="green" aria-controls="green-slider">
                        </md-input-container>
                    </md-slider-container>
                    <md-checkbox ng-model="isDisabled">Is disabled</md-checkbox>
                    <md-slider ng-model="disabled2" ng-disabled="true" aria-label="Disabled 2"></md-slider>

                    <h3>Disabled, Discrete, Read Only</h3>
                    <md-slider ng-model="disabled2" ng-disabled="true" step="3" md-discrete="" min="0" max="10" aria-label="Disabled discrete 2"></md-slider>
                    <md-slider ng-model="disabled3" ng-disabled="true" step="10" md-discrete="" aria-label="Disabled discrete 3" ng-readonly="readonly"></md-slider>
                    <md-checkbox ng-model="readonly">Read only</md-checkbox>
                </md-content>
            </div>

            <!--
            Copyright 2016 Google Inc. All Rights Reserved.
            Use of this source code is governed by an MIT-style license that can be in foundin the LICENSE file at http://material.angularjs.org/license.
            -->
    </div>
</div>


</body>
</html>
