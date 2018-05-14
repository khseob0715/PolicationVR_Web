<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>Polication VR</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/business-frontpage.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <link href="css/searchbox.css" rel="stylesheet">
<script src="js/wow.min.js"></script>

        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/serial.js" type="text/javascript"></script>
        

        <style type="text/css">

            .amcharts-graph-g1 .amcharts-graph-stroke {
                stroke-dasharray: 3px 3px;
                stroke-linejoin: round;
                stroke-linecap: round;
                -webkit-animation: am-moving-dashes 1s linear infinite;
                animation: am-moving-dashes 1s linear infinite;
            }

            @-webkit-keyframes am-moving-dashes {
                100% {
                    stroke-dashoffset: -30px;
                }
            }
            @keyframes am-moving-dashes {
                100% {
                    stroke-dashoffset: -30px;
                }
            }


            .lastBullet {
                -webkit-animation: am-pulsating 1s ease-out infinite;
                animation: am-pulsating 1s ease-out infinite;
            }
            @-webkit-keyframes am-pulsating {
                0% {
                    stroke-opacity: 1;
                    stroke-width: 0px;
                }
                100% {
                    stroke-opacity: 0;
                    stroke-width: 50px;
                }
            }
            @keyframes am-pulsating {
                0% {
                    stroke-opacity: 1;
                    stroke-width: 0px;
                }
                100% {
                    stroke-opacity: 0;
                    stroke-width: 50px;
                }
            }

            .amcharts-graph-column-front {
                -webkit-transition: all .3s .3s ease-out;
                transition: all .3s .3s ease-out;
            }
            .amcharts-graph-column-front:hover {
                fill: #496375;
                stroke: #496375;
                -webkit-transition: all .3s ease-out;
                transition: all .3s ease-out;
            }


            .amcharts-graph-g2 {
              stroke-linejoin: round;
              stroke-linecap: round;
              stroke-dasharray: 500%;
              stroke-dasharray: 0 \0/;    /* fixes IE prob */
              stroke-dashoffset: 0 \0/;   /* fixes IE prob */
              -webkit-animation: am-draw 40s;
              animation: am-draw 40s;
            }
            @-webkit-keyframes am-draw {
                0% {
                    stroke-dashoffset: 500%;
                }
                100% {
                    stroke-dashoffset: 0px;
                }
            }
            @keyframes am-draw {
                0% {
                    stroke-dashoffset: 500%;
                }
                100% {
                    stroke-dashoffset: 0px;
                }
            }




        </style>

         <?php

            $hostname = "127.0.0.1";
            $username= "root";   
            $password = "q56125612";
            $dbname = "userinfo";

            $mysqli = new mysqli($hostname, $username, $password, $dbname); 

            $Uemail = $_REQUEST["schmail"];
  
            $user = "SELECT * FROM user WHERE User_email = '$Uemail'";
            $userresult = mysqli_query($mysqli, $user);
            $userrow = mysqli_fetch_array($userresult);

            $gradeseq = "SELECT * FROM grade WHERE User_sequence = '$userrow[0]' AND Test_Case = 1";
            $gradeseqresult = mysqli_query($mysqli, $gradeseq);
  
            $nsd1 = mysqli_num_rows($gradeseqresult);

            $n=0;

            while($gradeseqrow = mysqli_fetch_array($gradeseqresult)) {
                $Test_date1[$n] = $gradeseqrow['Test_date'];
                $sub_check1[$n] = $gradeseqrow['sub_check'];
                $sub_gather1[$n] = $gradeseqrow['sub_gather'];
                $sub_invest1[$n] = $gradeseqrow['sub_invest'];
                $n++;
            }

            $n = 0;

            $gradeseq = "SELECT * FROM grade WHERE User_sequence = '$userrow[0]' AND Test_Case = 2";
            $gradeseqresult = mysqli_query($mysqli, $gradeseq);
  
            $nsd2 = mysqli_num_rows($gradeseqresult);

            while($gradeseqrow = mysqli_fetch_array($gradeseqresult)) {
                $Test_date2[$n] = $gradeseqrow['Test_date'];
                $sub_check2[$n] = $gradeseqrow['sub_check'];
                $sub_gather2[$n] = $gradeseqrow['sub_gather'];
                $sub_invest2[$n] = $gradeseqrow['sub_invest'];
                $n++;
            }

            $n = 0;

            $gradeseq = "SELECT * FROM grade WHERE User_sequence = '$userrow[0]' AND Test_Case = 3";
            $gradeseqresult = mysqli_query($mysqli, $gradeseq);
  
            $nsd3 = mysqli_num_rows($gradeseqresult);

            while($gradeseqrow = mysqli_fetch_array($gradeseqresult)) {
                $Test_date3[$n] = $gradeseqrow['Test_date'];
                $sub_check3[$n] = $gradeseqrow['sub_check'];
                $sub_gather3[$n] = $gradeseqrow['sub_gather'];
                $sub_invest3[$n] = $gradeseqrow['sub_invest'];
                $n++;
            }

            mysqli_free_result($userresult);
            mysqli_free_result($gradeseqresult);
            mysqli_close($mysqli);
        
        ?>

        <script>
            // note, we have townName field with a name specified for each datapoint and townName2 with only some of the names specified.
            // we use townName2 to display town names next to the bullet. And as these names would overlap if displayed next to each bullet,
            // we created this townName2 field and set only some of the names for this purpse

            var Test_date = <?php echo json_encode($Test_date1)?>;

            var sub_check = <?php echo json_encode($sub_check1)?>;

            var sub_gather = <?php echo json_encode($sub_gather1)?>;

            var sub_invest = <?php echo json_encode($sub_invest1)?>;

            var n = <?php echo $nsd1 ?>*1;

            var chartData1 = [
                {
                    "date": Test_date[0],
                    "Check": sub_check[0]*1,
                    "Gather": sub_gather[0]*1,
                    "Invest": sub_invest[0]*1,
                    "Average": (sub_check[0]*1+sub_gather[0]*1+sub_invest[0]*1)/3
                }
            ];

            for(var i = 1; i<n; i++){
                var tmpdata1 = [
                    {
                    "date": Test_date[i],
                    "Check": sub_check[i]*1,
                    "Gather": sub_gather[i]*1,
                    "Invest": sub_invest[i]*1,
                    "Average": (sub_check[i]*1+sub_gather[i]*1+sub_invest[i]*1)/3
                    }
                ];

                chartData1 = chartData1.concat(tmpdata1);
            }

            var chart;

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.addTitle("Case 1", 24);
                chart.addClassNames = true;
                chart.dataProvider = chartData1;
                chart.categoryField = "date";
                chart.dataDateFormat = "YYYY-MM-DD";
                chart.startDuration = 1;
                chart.color = "#FFFFFF";
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
                categoryAxis.gridColor = "#FFFFFF";
                categoryAxis.axisColor = "#555555";
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
                chart.addValueAxis(scoreAxis);

                var averageAxis = new AmCharts.ValueAxis();
                averageAxis.title = "Average";
                averageAxis.gridAlpha = 0;
                averageAxis.axisAlpha = 0;
                averageAxis.inside = false;
                averageAxis.position = "right";
                chart.addValueAxis(averageAxis);


                // GRAPHS
                // distance graph
                var checkGraph = new AmCharts.AmGraph();
                checkGraph.valueField = "Check";
                checkGraph.title = "Check";
                checkGraph.type = "column";
                checkGraph.fillAlphas = 0.9;
                checkGraph.valueAxis = scoreAxis; // indicate which axis should be used
                checkGraph.balloonText = "[[value]]";
                checkGraph.legendValueText = ": [[value]]";
                checkGraph.legendPeriodValueText = "total: [[value.sum]]";
                checkGraph.lineColor = "#263138";
                checkGraph.alphaField = "alpha";
                chart.addGraph(checkGraph);

                // latitude graph
                var gatherGraph = new AmCharts.AmGraph();
                gatherGraph.valueField = "Gather";
                gatherGraph.title = "Gather";
                gatherGraph.type = "column";
                gatherGraph.fillAlphas = 0.9;
                //gatherGraph.valueAxis = latitudeAxis; // indicate which axis should be used
                gatherGraph.balloonText = "[[value]]";
                gatherGraph.legendValueText = ": [[value]]";
                gatherGraph.legendPeriodValueText = "total: [[value.sum]]";
                gatherGraph.lineColor = "#333520";
                gatherGraph.alphaField = "alpha";
                chart.addGraph(gatherGraph);

                // duration graph
                var investGraph = new AmCharts.AmGraph();
                investGraph.valueField = "Invest";
                investGraph.title = "Invest";
                investGraph.type = "column";
                investGraph.fillAlphas = 0.9;
                //investGraph.valueAxis = durationAxis; // indicate which axis should be used
                investGraph.balloonText = "[[value]]";
                investGraph.legendValueText = ": [[value]]";
                investGraph.legendPeriodValueText = "total: [[value.sum]]";
                investGraph.lineColor = "#382626";
                investGraph.alphaField = "alpha";
                chart.addGraph(investGraph);

                var averageGraph = new AmCharts.AmGraph();
                averageGraph.id = "g2";
                averageGraph.title = "Average";
                averageGraph.valueField = "Average";
                averageGraph.type = "line";
                averageGraph.valueAxis = averageAxis; // indicate which axis should be used
                averageGraph.lineColor = "#ff5755";
                averageGraph.balloonText = "[[value]]";
                averageGraph.lineThickness = 1;
                averageGraph.legendValueText = "[[value]]";
                averageGraph.bullet = "square";
                averageGraph.bulletBorderColor = "#ff5755";
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
                legend.color = "#FFFFFF";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartcase1div");
            });

            function zoomChart1() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(chartData1.length - 8, chartData1.length - 1);
            }
        </script>

        <script>
            // note, we have townName field with a name specified for each datapoint and townName2 with only some of the names specified.
            // we use townName2 to display town names next to the bullet. And as these names would overlap if displayed next to each bullet,
            // we created this townName2 field and set only some of the names for this purpse

            var Test_date = <?php echo json_encode($Test_date2)?>;

            var sub_check = <?php echo json_encode($sub_check2)?>;

            var sub_gather = <?php echo json_encode($sub_gather2)?>;

            var sub_invest = <?php echo json_encode($sub_invest2)?>;

            var n = <?php echo $nsd2 ?>*1;

            var chartData2 = [
                {
                    "date": Test_date[0],
                    "Check": sub_check[0]*1,
                    "Gather": sub_gather[0]*1,
                    "Invest": sub_invest[0]*1,
                    "Average": (sub_check[0]*1+sub_gather[0]*1+sub_invest[0]*1)/3
                }
            ];

            for(var i = 1; i<n; i++){
                var tmpdata2 = [
                    {
                    "date": Test_date[i],
                    "Check": sub_check[i]*1,
                    "Gather": sub_gather[i]*1,
                    "Invest": sub_invest[i]*1,
                    "Average": (sub_check[i]*1+sub_gather[i]*1+sub_invest[i]*1)/3
                    }
                ];

                chartData2 = chartData2.concat(tmpdata2);
            }

            var chart;

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.addTitle("Case 2", 24);
                chart.addClassNames = true;
                chart.dataProvider = chartData2;
                chart.categoryField = "date";
                chart.dataDateFormat = "YYYY-MM-DD";
                chart.startDuration = 1;
                chart.color = "#FFFFFF";
                chart.marginLeft = 0;
                chart.addListener("dataUpdated", zoomChart2);

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = false; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.autoGridCount = false;
                categoryAxis.gridCount = 8;
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.gridColor = "#FFFFFF";
                categoryAxis.axisColor = "#555555";
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
                chart.addValueAxis(scoreAxis);

                var averageAxis = new AmCharts.ValueAxis();
                averageAxis.title = "Average";
                averageAxis.gridAlpha = 0;
                averageAxis.axisAlpha = 0;
                averageAxis.inside = false;
                averageAxis.position = "right";
                chart.addValueAxis(averageAxis);


                // GRAPHS
                // distance graph
                var checkGraph = new AmCharts.AmGraph();
                checkGraph.valueField = "Check";
                checkGraph.title = "Check";
                checkGraph.type = "column";
                checkGraph.fillAlphas = 0.9;
                checkGraph.valueAxis = scoreAxis; // indicate which axis should be used
                checkGraph.balloonText = "[[value]]";
                checkGraph.legendValueText = ": [[value]]";
                checkGraph.legendPeriodValueText = "total: [[value.sum]]";
                checkGraph.lineColor = "#263138";
                checkGraph.alphaField = "alpha";
                chart.addGraph(checkGraph);

                // latitude graph
                var gatherGraph = new AmCharts.AmGraph();
                gatherGraph.valueField = "Gather";
                gatherGraph.title = "Gather";
                gatherGraph.type = "column";
                gatherGraph.fillAlphas = 0.9;
                //gatherGraph.valueAxis = latitudeAxis; // indicate which axis should be used
                gatherGraph.balloonText = "[[value]]";
                gatherGraph.legendValueText = ": [[value]]";
                gatherGraph.legendPeriodValueText = "total: [[value.sum]]";
                gatherGraph.lineColor = "#333520";
                gatherGraph.alphaField = "alpha";
                chart.addGraph(gatherGraph);

                // duration graph
                var investGraph = new AmCharts.AmGraph();
                investGraph.valueField = "Invest";
                investGraph.title = "Invest";
                investGraph.type = "column";
                investGraph.fillAlphas = 0.9;
                //investGraph.valueAxis = durationAxis; // indicate which axis should be used
                investGraph.balloonText = "[[value]]";
                investGraph.legendValueText = ": [[value]]";
                investGraph.legendPeriodValueText = "total: [[value.sum]]";
                investGraph.lineColor = "#382626";
                investGraph.alphaField = "alpha";
                chart.addGraph(investGraph);

                var averageGraph = new AmCharts.AmGraph();
                averageGraph.id = "g2";
                averageGraph.title = "Average";
                averageGraph.valueField = "Average";
                averageGraph.type = "line";
                averageGraph.valueAxis = averageAxis; // indicate which axis should be used
                averageGraph.lineColor = "#ff5755";
                averageGraph.balloonText = "[[value]]";
                averageGraph.lineThickness = 1;
                averageGraph.legendValueText = "[[value]]";
                averageGraph.bullet = "square";
                averageGraph.bulletBorderColor = "#ff5755";
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
                legend.color = "#FFFFFF";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartcase2div");
            });

            function zoomChart2() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(chartData2.length - 8, chartData2.length - 1);
            }
        </script>

        <script>
            // note, we have townName field with a name specified for each datapoint and townName2 with only some of the names specified.
            // we use townName2 to display town names next to the bullet. And as these names would overlap if displayed next to each bullet,
            // we created this townName2 field and set only some of the names for this purpse

            var Test_date = <?php echo json_encode($Test_date3)?>;

            var sub_check = <?php echo json_encode($sub_check3)?>;

            var sub_gather = <?php echo json_encode($sub_gather3)?>;

            var sub_invest = <?php echo json_encode($sub_invest3)?>;

            var n = <?php echo $nsd3 ?>*1;

            var chartData3 = [
                {
                    "date": Test_date[0],
                    "Check": sub_check[0]*1,
                    "Gather": sub_gather[0]*1,
                    "Invest": sub_invest[0]*1,
                    "Average": (sub_check[0]*1+sub_gather[0]*1+sub_invest[0]*1)/3
                }
            ];

            for(var i = 1; i<n; i++){
                var tmpdata3 = [
                    {
                    "date": Test_date[i],
                    "Check": sub_check[i]*1,
                    "Gather": sub_gather[i]*1,
                    "Invest": sub_invest[i]*1,
                    "Average": (sub_check[i]*1+sub_gather[i]*1+sub_invest[i]*1)/3
                    }
                ];

                chartData3 = chartData3.concat(tmpdata3);
            }

            var chart;

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.addTitle("Case 3", 24);
                chart.addClassNames = true;
                chart.dataProvider = chartData3;
                chart.categoryField = "date";
                chart.dataDateFormat = "YYYY-MM-DD";
                chart.startDuration = 1;
                chart.color = "#FFFFFF";
                chart.marginLeft = 0;
                chart.addListener("dataUpdated", zoomChart3);

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = false; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.autoGridCount = false;
                categoryAxis.gridCount = 8;
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.gridColor = "#FFFFFF";
                categoryAxis.axisColor = "#555555";
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
                chart.addValueAxis(scoreAxis);

                var averageAxis = new AmCharts.ValueAxis();
                averageAxis.title = "Average";
                averageAxis.gridAlpha = 0;
                averageAxis.axisAlpha = 0;
                averageAxis.inside = false;
                averageAxis.position = "right";
                chart.addValueAxis(averageAxis);


                // GRAPHS
                // distance graph
                var checkGraph = new AmCharts.AmGraph();
                checkGraph.valueField = "Check";
                checkGraph.title = "Check";
                checkGraph.type = "column";
                checkGraph.fillAlphas = 0.9;
                checkGraph.valueAxis = scoreAxis; // indicate which axis should be used
                checkGraph.balloonText = "[[value]]";
                checkGraph.legendValueText = ": [[value]]";
                checkGraph.legendPeriodValueText = "total: [[value.sum]]";
                checkGraph.lineColor = "#263138";
                checkGraph.alphaField = "alpha";
                chart.addGraph(checkGraph);

                // latitude graph
                var gatherGraph = new AmCharts.AmGraph();
                gatherGraph.valueField = "Gather";
                gatherGraph.title = "Gather";
                gatherGraph.type = "column";
                gatherGraph.fillAlphas = 0.9;
                //gatherGraph.valueAxis = latitudeAxis; // indicate which axis should be used
                gatherGraph.balloonText = "[[value]]";
                gatherGraph.legendValueText = ": [[value]]";
                gatherGraph.legendPeriodValueText = "total: [[value.sum]]";
                gatherGraph.lineColor = "#333520";
                gatherGraph.alphaField = "alpha";
                chart.addGraph(gatherGraph);

                // duration graph
                var investGraph = new AmCharts.AmGraph();
                investGraph.valueField = "Invest";
                investGraph.title = "Invest";
                investGraph.type = "column";
                investGraph.fillAlphas = 0.9;
                //investGraph.valueAxis = durationAxis; // indicate which axis should be used
                investGraph.balloonText = "[[value]]";
                investGraph.legendValueText = ": [[value]]";
                investGraph.legendPeriodValueText = "total: [[value.sum]]";
                investGraph.lineColor = "#382626";
                investGraph.alphaField = "alpha";
                chart.addGraph(investGraph);

                var averageGraph = new AmCharts.AmGraph();
                averageGraph.id = "g2";
                averageGraph.title = "Average";
                averageGraph.valueField = "Average";
                averageGraph.type = "line";
                averageGraph.valueAxis = averageAxis; // indicate which axis should be used
                averageGraph.lineColor = "#ff5755";
                averageGraph.balloonText = "[[value]]";
                averageGraph.lineThickness = 1;
                averageGraph.legendValueText = "[[value]]";
                averageGraph.bullet = "square";
                averageGraph.bulletBorderColor = "#ff5755";
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
                legend.color = "#FFFFFF";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartcase3div");
            });

            function zoomChart3() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(chartData3.length - 8, chartData3.length - 1);
            }

        </script>
    </head>

    <body style="background-color:#161616"  >
        <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="http://localhost/">Polication VR</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>

    <div class="container">
      <div class="flexsearch">
        <div class="flexsearch--wrapper">
          <form class="flexsearch--form" action="http://localhost/anisearch.php" method="post">
            <div class="flexsearch--input-wrapper">
              <input class="flexsearch--input" name="schmail" type="search" placeholder="E-mail 입력">
            </div>
            <input class="flexsearch--submit" type="submit" value="&#10140;"/>
          </form>
        </div>
      </div>
    </div>

    <p><div style="clear:both;"></div></p>
    <div class="container">
        <font class="wow fadeInRight" size="20" color="white"><?php echo $userrow[1] ?>     
        </font>
    </div>
    
    <p><div style="clear:both;"></div></p>


        <!-- Chart Insert -->
        
        <div class="container fadeInRight" id="chartcase1div" style="height:400px;"></div>
        <div class="container fadeInUp" id="chartcase2div" style="height:400px;"></div>
        <div class="container fadeInUp" id="chartcase3div" style="height:400px;"></div>

       
        
        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">
                    Copyright &copy; 2018 Team Kim
                </p>
            </div>
        <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>