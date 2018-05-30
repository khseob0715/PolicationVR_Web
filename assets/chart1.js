document.write("<script src='https://www.gstatic.com/firebasejs/5.0.3/firebase.js'></script>");
document.write("<script src='assets/amcharts/amcharts.js' type='text/javascript'></script>");
document.write("<script src='assets/amcharts/serial.js' type='text/javascript'></script>");

  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCN6l967RBpskZU3s8oqyGa1lnNsoYUaXc",
    authDomain: "policationvrweb.firebaseapp.com",
    databaseURL: "https://policationvrweb.firebaseio.com",
    projectId: "policationvrweb",
    storageBucket: "policationvrweb.appspot.com",
    messagingSenderId: "642203863012"
};
firebase.initializeApp(config);

var rootRef = firebase.database().ref();

var schMail = "exam01@naver.com";

            var case1 = "1_";

            var case1_mail = case1.concat(schMail);

            console.log(case1_mail);

            rootRef.child('Users').orderByChild('case_mail').equalTo(case1_mail).once('value').then(snap => {
                var chartData1 = Object.values(snap.val());
            });

            console.log(chartData1);

            var chart;

                AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.addTitle("CrimeScene 01", 24);
                chart.addClassNames = true;
                chart.dataProvider = chartData1;
                chart.categoryField = "date";
                chart.dataDateFormat = "YYYY-MM-DD";
                chart.startDuration = 1;
                chart.color = "#161616";
                chart.marginLeft = 0;
                chart.addListener("dataUpdated", zoomChart1);

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = false; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.autoGridCount = false;
                categoryAxis.gridCount = 8;
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.gridColor = "#161616";
                categoryAxis.axisColor = "#555555";
                categoryAxis.fillColor = "#161616";
                // we want custom date formatting, so we change it in next line
                categoryAxis.dateFormats = [{
                    period: 'DD',
                    format: 'DD'
                }, {
                    period: 'WW',
                    format: 'MMM DD'
                }, {
                    period: 'MM',
                    format: 'MMM'
                }, {
                    period: 'YYYY',
                    format: 'YYYY'
                }];


                // as we have data of different units, we create three different value axes
                // Distance value axis
                var scoreAxis = new AmCharts.ValueAxis();
                scoreAxis.title = "Score";
                scoreAxis.gridAlpha = 0;
                scoreAxis.axisAlpha = 0;
                scoreAxis.color = "#161616";
                chart.addValueAxis(scoreAxis);

                var averageAxis = new AmCharts.ValueAxis();
                averageAxis.title = "Average";
                averageAxis.gridAlpha = 0;
                averageAxis.axisAlpha = 0;
                averageAxis.inside = false;
                averageAxis.color = "#161616";
                averageAxis.position = "right";
                chart.addValueAxis(averageAxis);


                // GRAPHS
                // distance graph
                var evidenceGraph = new AmCharts.AmGraph();
                evidenceGraph.valueField = "evidence";
                evidenceGraph.title = "evidence";
                evidenceGraph.type = "column";
                evidenceGraph.fillAlphas = 0.9;
                evidenceGraph.valueAxis = scoreAxis; // indicate which axis should be used
                evidenceGraph.balloonText = "[[value]]";
                evidenceGraph.legendValueText = ": [[value]]";
                evidenceGraph.legendPeriodValueText = "total: [[value.sum]]";
                evidenceGraph.lineColor = "#ED5565";
                evidenceGraph.alphaField = "alpha";
                chart.addGraph(evidenceGraph);

                // latitude graph
                var witnessGraph = new AmCharts.AmGraph();
                witnessGraph.valueField = "witness";
                witnessGraph.title = "witness";
                witnessGraph.type = "column";
                witnessGraph.fillAlphas = 0.9;
                //witnessGraph.valueAxis = latitudeAxis; // indicate which axis should be used
                witnessGraph.balloonText = "[[value]]";
                witnessGraph.legendValueText = ": [[value]]";
                witnessGraph.legendPeriodValueText = "total: [[value.sum]]";
                witnessGraph.lineColor = "#4FC1E9";
                witnessGraph.alphaField = "alpha";
                chart.addGraph(witnessGraph);

                var averageGraph = new AmCharts.AmGraph();
                averageGraph.id = "g2";
                averageGraph.title = "Average";
                averageGraph.valueField = "Average";
                averageGraph.type = "line";
                averageGraph.valueAxis = averageAxis; // indicate which axis should be used
                averageGraph.lineColor = "#34495E";
                averageGraph.balloonText = "[[value]]";
                averageGraph.lineThickness = 1;
                averageGraph.legendValueText = "[[value]]";
                averageGraph.bullet = "square";
                averageGraph.bulletBorderColor = "#34495E";
                averageGraph.bulletBorderThickness = 1;
                averageGraph.bulletBorderAlpha = 1;
                averageGraph.dashLengthField = "dashLength";
                averageGraph.animationPlayed = true;
                chart.addGraph(averageGraph);

                // SCROLL
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.color = "#FFFFFF"
                chartScrollbar.autoGridCount = false;
                chartScrollbar.gridCount = 0;
                chartScrollbar.hideResizeGrips = true;
                chartScrollbar.gridAlpha = 1;
                //chartScrollbar.categoryAxis = new AmCharts.categoryAxis();
                //chartScrollbar.maximum = 8;
                //chartScrollbar.minimum = 8;
                chartScrollbar.dragIcon = "dragIconRectSmall";
                chartScrollbar.dragIconHeight = 25;
                chartScrollbar.dragIconWidth = 25;
                chart.addChartScrollbar(chartScrollbar);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonDateFormat = undefined;
                chartCursor.cursorAlpha = 0;
                chartCursor.valueBalloonsEnabled = false;
                chartCursor.valueLineBalloonEnabled = true;
                chartCursor.valueLineEnabled = true;
                chartCursor.valueLineAlpha = 0.5;
                chart.addChartCursor(chartCursor);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                legend.bulletType = "round";
                legend.equalWidths = false;
                legend.valueWidth = 120;
                legend.useGraphSettings = true;
                legend.color = "#161616";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartcase1div");
            });

function zoomChart1() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(chartData1.length - 8, chartData1.length - 1);
            }
