<!DOCTYPE html>
<html>
  <head>
    <title> Sigin </title>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default/style.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js"></script>
    <style>
#chartdiv {
  width: 900px;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = [{
    "year": "1950",
    "value": -0.307
}, {
    "year": "1951",
    "value": -0.168
}, {
    "year": "1952",
    "value": -0.073
}, {
    "year": "1953",
    "value": -0.027
}, {
    "year": "1954",
    "value": -0.251
}, {
    "year": "1955",
    "value": -0.281
}, {
    "year": "1956",
    "value": -0.348
}, {
    "year": "1957",
    "value": -0.074
}, {
    "year": "1958",
    "value": -0.011
}, {
    "year": "1959",
    "value": -0.074
}, {
    "year": "1960",
    "value": -0.124
}, {
    "year": "1961",
    "value": -0.024
}, {
    "year": "1962",
    "value": -0.022
}, {
    "year": "1963",
    "value": 0
}, {
    "year": "1964",
    "value": -0.296
}, {
    "year": "1965",
    "value": -0.217
}, {
    "year": "1966",
    "value": -0.147
}, {
    "year": "1967"
}, {
    "year": "1971",
    "value": -0.19
}, {
    "year": "1972",
    "value": -0.056
}, {
    "year": "1973",
    "value": 0.077
}, {
    "year": "1974",
    "value": -0.213
}, {
    "year": "1975",
    "value": -0.17
}, {
    "year": "1976",
    "value": -0.254
}, {
    "year": "1977",
    "value": 0.019
}, {
    "year": "1978",
    "value": -0.063
}, {
    "year": "1979",
    "value": 0.05
}, {
    "year": "1980",
    "value": 0.077
}, {
    "year": "1981",
    "value": 0.12
}, {
    "year": "1982",
    "value": 0.011
}, {
    "year": "1983",
    "value": 0.177
}, {
    "year": "1984"
}, {
    "year": "1989",
    "value": 0.104
}, {
    "year": "1990",
    "value": 0.255
}, {
    "year": "1991",
    "value": 0.21
}, {
    "year": "1992",
    "value": 0.065
}, {
    "year": "1993",
    "value": 0.11
}, {
    "year": "1994",
    "value": 0.172
}, {
    "year": "1995",
    "value": 0.269
}, {
    "year": "1996",
    "value": 0.141
}, {
    "year": "1997",
    "value": 0.353
}, {
    "year": "1998",
    "value": 0.548
}, {
    "year": "1999",
    "value": 0.298
}, {
    "year": "2000",
    "value": 0.267
}, {
    "year": "2001",
    "value": 0.411
}, {
    "year": "2002",
    "value": 0.462
}, {
    "year": "2003",
    "value": 0.47
}, {
    "year": "2004",
    "value": 0.445
}, {
    "year": "2005",
    "value": 0.47
}];

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.minGridDistance = 50;
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.baseInterval = {
  count: 1,
  timeUnit: "year"
}

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "year";
series.strokeWidth = 3;
series.stroke = "red";
series.fill = "red";
series.connect = false;
//series.tensionX = 0.8;
series.fillOpacity = 0.2;

var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.stroke = am4core.color("#fff");
bullet.strokeWidth = 3;

var range = valueAxis.createSeriesRange(series);
range.value = -0.2;
range.endValue = -0.1;
range.contents.stroke = "green";
range.contents.fill = range.contents.stroke;
range.contents.fillOpacity = 0.2;

chart.scrollbarX = new am4core.Scrollbar();

chart.events.on("inited", function(ev) {
  dateAxis.zoomToDates(new Date(1970, 0), new Date(1995, 0));
});

}); // end am4core.ready()
</script>
  </head>
  <body  style="position:relative; margin: 0px;">
    <?php
      include "connect.php";
      include "taskbar.php";
      include "sidebar.php";
    ?>
    <div id="page-content" style="float:left;height:1000px;color: #18699F;margin: 70px 0px 0px 200px;">
    <div id="chartdiv"></div>
    </div>
  </body>
</html>



<!-- HTML -->

