/**
 * Created by preston on 3/8/16.
 */

google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Day', 'Pump', 'Heater'],
        ['Sunday', 1.5, 2.3],
        ['Monday', 1000, 400],
        ['Tuesday', 1170, 460],
        ['Wednesday', 660, 1120],
        ['Thursday', 1030, 540],
        ['Friday', 1030, 540],
        ['Saturday', 1030, 540]
    ]);

    var options = {
        backgroundColor:'transparent',
        width:'880',
        height: '300',
        chart: {
            title: 'Equipment Usage',
            subtitle: 'Heater and Pump Usage',
        }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}