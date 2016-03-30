/**
 * Created on 3/2/16
 * This file fetches the last data points the database and generates the gauges using the Google Charts API
 *
 */
    // Load the Visualization API and the piechart package.
google.charts.load('current', {'packages':['gauge', 'line']});
google.charts.setOnLoadCallback(drawGauge);

function drawGauge() {
    var gaugeData = $.ajax({
        url: "graph/getTemperature.php",
        dataType: "json",
        async: false
    }).responseText;


    //parse the json array
    gaugeData=JSON.parse(gaugeData);
    gaugeData=JSON.parse(gaugeData);

    //get the values we need
    var airTemp = gaugeData[0].temp;
    var waterTemp = gaugeData[1].temp;

    var gData = new google.visualization.DataTable();
    gData.addColumn('string', 'Label');
    gData.addColumn('number', 'Value');
    gData.addRows(2);
    gData.setValue(0, 0, 'Air');
    gData.setValue(0, 1, airTemp);
    gData.setValue(1, 0, 'Water');
    gData.setValue(1, 1, waterTemp);
    var gOptions = {
        width: 400, height: 250,
        redFrom: 90, redTo: 100,
        yellowFrom:85, yellowTo: 100,
        minorTicks: 5
    };

    var gChart = new google.visualization.Gauge(document.getElementById('tempGauges'));
    gChart.draw(gData, gOptions);

    setInterval(function()
    {
        var gaugeData = $.ajax({
            url: "graph/getTemperature.php",
            dataType: "json",
            async: false
        }).responseText;
        gaugeData=JSON.parse(gaugeData);
        gaugeData=JSON.parse(gaugeData);

        //get the values we need
        var airTemp = gaugeData[0].temp;
        var waterTemp = gaugeData[1].temp;
        gData.setValue(0, 1, airTemp);
        gData.setValue(1, 1, waterTemp);
        gChart.draw(gData, gOptions);
    }, 10000)
}

