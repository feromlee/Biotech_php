<!DOCTYPE html>
<?php include_once 'utils\utils.php'; ?>
<?php $conn = get_mysql_conn(); ?>

<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Neon Admin Panel" />
        <meta name="author" content="" />

        <link rel="icon" href="assets/images/favicon.ico">

        <title>Raymond Investment</title>

        <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
        <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/neon-core.css">
        <link rel="stylesheet" href="assets/css/neon-theme.css">
        <link rel="stylesheet" href="assets/css/neon-forms.css">
        <link rel="stylesheet" href="assets/css/custom.css">

        <script src="assets/js/jquery-1.11.3.min.js"></script>




    </head>
    <div id="loadingbar">
        <div class="row">
            <br><br><br><br><br><br><br><br><br><br><br>
            <div class="col-md-offset-5 col-md-7">
                <img src = "assets/images/download.png"/>
            </div>
        </div>>
        <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4 progress progress-striped active">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%">                                                    </td></tr>
                </div>
            </div>
        </div>
    </div>







    <body class="page-body  page-fade" data-url="http://neon.dev">

        <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
            <?php
            include_once 'menu.php';
            ?>


            <div class="main-content">


                <?php
                if (isset($_POST["security_info"])) {
                    //print_rr($_POST);
                    $security_id = explode("-", $_POST["security_info"]);
                    $security_id = $security_id[0];
                    $start_day = $_POST["sdatetime"];
                    $start_day = str_replace("-", "", $start_day);                   
                }
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-primary" id="charts_env" data-collapsed="0">

                            <div class="panel-heading">
                                <div class="panel-title">统计
                                </div>

                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <!-- <li class=""><a href="#area-chart" data-toggle="tab">Area Chart</a></li>-->
                                        <li class="active"><a href="#line-chart" data-toggle="tab">对比图</a></li>
                                        <!-- <li class=""><a href="#pie-chart" data-toggle="tab">Pie Chart</a></li> -->
                                    </ul>
                                </div>
                            </div>



                            <div class="panel-body">
                                <form role="form" class="form-horizontal" action="" method="POST">

                                    <div class="form_group col-md-2">
                                        <div class="col-sm-12">
                                            <select class="form-control" name="security_info">

                                                <?php
                                                $sql = "SELECT * FROM security";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    // 输出数据
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row["security_id"] . "-" . $row["security_name"] . "'";
                                                        if (isset($_POST["security_info"])) {
                                                            if ($_POST["security_info"] == $row["security_id"] . "-" . $row["security_name"]) {
                                                                echo " Selected ";
                                                            }
                                                        }
                                                        echo ">" . $row["security_id"] . " " . $row["security_name"] . "</option>";
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="col-sm-4 control-label">Day </label>

                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="sdatetime" class="form-control datepicker" data-format="yyyy-mm-dd" value="<?php
                                                if (isset($_POST["sdatetime"])) {
                                                    echo $_POST["sdatetime"];
                                                } else {
                                                    echo date('Y-m-d', strtotime("-1 day"));
                                                }
                                                ?>">

                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   

                                    <div class="form_group col-md-1">
                                        <div class="col-sm-1">                                            
                                            <button type="submit" class="btn btn-blue">Search</button>
                                        </div>
                                    </div>  
                                </form>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="line-chart">
                                <!--内容显示区-->
                                <?php
                                ?>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>证商ID</th>
                                            <th>证商名</th>
                                            <th>持有量</th>                                            
                                            <th>持有 %</th>                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (isset($_POST["security_info"])) {
                                            $sql = "select distinct broker_name, broker_id ,shareholding,holding_percent from rawdata_" . $security_id . " where dday=" . $start_day ."  order by shareholding desc";
                                           //echo $sql;
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                // 输出数据
                                                while ($row = $result->fetch_assoc()) {
                                                                                                                                                
                                                    $shareholding1=$row["shareholding"];
                                                    $holdingpercent1 = $row["holding_percent"];
                                                    
                                                 
                                                    
                                                    echo "<tr>";
                                                    echo "<td>" . $row["broker_id"] . "</td>";
                                                    echo "<td>" . $row["broker_name"] . "</td>";
                                                    echo "<td>" . number_format($shareholding1) . "</td>";                                                    
                                                    echo "<td>" . $holdingpercent1 . "</td>";
                                                   
                                                    
                                                   
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                        ?>
                                       
                                       
                                       <?php
                                        if (isset($_POST["security_info"])) {
                                            $sql = "select distinct broker_name, broker_id from rawdata_" . $security_id . " where dday=" . $start_day ."  order by shareholding desc";
                                           //echo $sql;
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                // 输出数据
                                                while ($row = $result->fetch_assoc()) {

                                                    $substr = "select shareholding,holding_percent from rawdata_" . $security_id . " where broker_id='" . $row["broker_id"] . "' and dday=" . $start_day;
                                                    //echo "<br>".$substr;
                                                    $result1 = $conn->query($substr);
                                                    if ($result1->num_rows > 0) {
                                                        $row1 = $result1->fetch_assoc();
                                                        $shareholding1 = $row1["shareholding"];
                                                        $holdingpercent1 = $row1["holding_percent"];
                                                    } else {
                                                        $shareholding1 = 0;
                                                        $holdingpercent1 = '0 %';
                                                    }
                                                                                                                                      


                                                    
                                                 
                                                    
                                                    echo "<tr>";
                                                    echo "<td>" . $row["broker_id"] . "</td>";
                                                    echo "<td>" . $row["broker_name"] . "</td>";
                                                    echo "<td>" . number_format($shareholding1) . "</td>";                                                    
                                                    echo "<td>" . $holdingpercent1 . "</td>";
                                                   
                                                    
                                                   
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-sm-4">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>
                                Real Time Stats
                                <br />
                                <small>current server uptime</small>
                            </h4>
                        </div>

                        <div class="panel-options">
                            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>

                    <div class="panel-body no-padding">
                        <div id="rickshaw-chart-demo">
                            <div id="rickshaw-legend"></div>
                        </div>
                    </div>
                </div>

            </div>
            -->
        </div>


        <br />






        <!-- Footer -->
        <footer class="main">

            <?PHP echo "" ?>

        </footer>
    </div>
</div>


<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


<!-- Imported scripts on this page -->
<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>
<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>

<!--
<script src="assets/js/rickshaw/rickshaw.min.js"></script>
-->
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/neon-chat.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>

</body>
</html>
<?php
mysqli_close($conn);
?>


<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        // Line Charts


        var line_chart_demo = $("#line-chart-demo");
        var line_chart = new Morris.Line({
            element: 'line-chart-demo',
            data: [<?php echo $line_data['data']; ?>],
            xkey: 'y',
            ykeys: [<?php echo $line_data['ykeys']; ?>],
            labels: [<?php echo $line_data['labels']; ?>],
            parseTime: false,
            redraw: true,
            lineWidth: 3

        });

        line_chart_demo.parent().attr('style', '');
    });


    function getRandomInt(min, max)
    {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>

<script>
    $(document).ready(
            function () {
                $("#loadingbar").hide();
            });
</script>