<!DOCTYPE html>
<?php include_once 'utils\utils.php'; ?>
<?php
$conn = get_mysql_conn();
if (mysqli_connect_errno($conn))
{
    echo "连接到 MySQL 失败: " . mysqli_connect_error();
}
?>
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

    <?php
    if (isset($_POST["mode"])) {
        if ($_POST["security_id"] == "" or $_POST["security_name"] == "") {
            $msg_str = "";
        } else {

            if ($_POST["mode"] == "create") {
               
                $table_name = "rawdata_" . $_POST["security_id"];
                $sqlstr_create = "CREATE TABLE `" . $table_name . "`(
                      `id` int(11) NOT NULL,
                      `security_id` bigint(11) NOT NULL,
                      `security_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
                      `broker_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
                      `broker_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
                      `shareholding` bigint(11) NOT NULL,
                      `holding_percent` varchar(10) NOT NULL,
                      `dyear` int(4) NOT NULL,
                      `dmonth` int(6) NOT NULL,
                      `dday` int(8) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
                    ALTER TABLE `" . $table_name . "`
                      ADD PRIMARY KEY (`id`),
                      ADD KEY `general` (`security_id`,`broker_name`,`dday`);
                    ALTER TABLE `" . $table_name . "`
                      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                    ALTER TABLE `" . $table_name . "` ADD INDEX( `broker_id`, `shareholding`, `dday`)";
                    
                
                //mysqli_query($conn, $sqlstr_create);
               // echo $sqlstr_create;
                $sqlstr = "select * from security where security_id=" . $_POST["security_id"];
                $result = mysqli_query($conn, $sqlstr);

                if ($result->num_rows == 1) {
                    //echo "AAAAAAAAA";
                    $sqlstr = "update security set security_name='" . $_POST["security_name"] . "' where security_id=" . $_POST["security_id"];
                    mysqli_query($conn, $sqlstr);
                } else {
                   // echo "BBBBBBBBB";
                    $sqlstr = "insert into security (security_id,security_name) values ('" . $_POST["security_id"] . "','" . $_POST["security_name"] . "')";
                   // echo $sqlstr;
                   mysqli_multi_query($conn, $sqlstr_create); 
                   mysqli_query($conn, $sqlstr);
                    
                }
            }

            if ($_POST["mode"] == "delete") {
                // echo "Modify";
            }
        }
    }
    ?>

    <body class="page-body  page-fade" data-url="http://neon.dev">

        <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

<?php
include_once 'menu.php';
?>

            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-primary" data-collapsed="0">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    创建股票信息
                                </div>

                                <div class="panel-options col-sm-1">
                                    <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                    <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <form role="form" id="form1" method="post" class="validate form-horizontal form-groups-bordered">
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label">请输入股票代码</label>

                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="field-1" name="security_id" data-validate="required,number" data-message-required="这不能为空" placeholder="直接输入数字，如876，不用输入00876。 如股票不存在，则创建股票信息。如存在，则修改股票名称">                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label">请输入股票名称</label>

                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="field-1" name="security_name"  data-validate="required" data-message-required="这不能为空" placeholder="请确保名字和港交所数据一致">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" class="btn btn-blue">Create / Modify</button>
                                        </div>
                                    </div>
                                    <input type='hidden' name='mode' value='create'>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>










                <!-- Footer -->
                <footer class="main">

<?PHP echo ""
?>

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
        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
        <script src="assets/js/jquery.sparkline.min.js"></script>
        <script src="assets/js/rickshaw/vendor/d3.v3.js"></script>

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