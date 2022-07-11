<!DOCTYPE html>
<?php include_once 'utils\utils.php'; ?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

    <script>
        function showbar() {
            $("#loadingbar").show();
        }
    </script>
    <?php
    $conn = get_mysql_conn();
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
                                    数据录入
                                </div>

                                <div class="panel-options col-sm-1">
                                    <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                    <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form role="form" class="form-horizontal form-groups-bordered" action="" method="POST" >
                                    
                                    <div class="col-sm-1 control-label"><button type="submit" class="btn btn-blue" onclick="go_webspider()" >运行 webspider.exe 进行原始数据获取</button></div>
                                    </div>
                                    <div class="form-group hide">
                                    
                                        <label class="col-sm-1 control-label">请选择操作的证券</label>

                                        <div class="col-sm-5">

                                            <select class="form-control" name="security_info">
                                                <?php
                                                $sql = "SELECT * FROM security";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    // 输出数据
                                                    while ($row = $result->fetch_assoc()) {
														if ($_POST["security_info"]==$row["security_id"] . "-" . $row["security_name"]){
															$select='selected=selected';															
														}else{
															$select='';															
														}
														echo "<option value='" . $row["security_id"] . "-" . $row["security_name"] . "' ".$select.">" . $row["security_id"] . " " . $row["security_name"] . "</option>";
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group hide">
                                        <label class="col-sm-1 control-label">选择输入日期</label>

                                        <div class="col-sm-3">
                                            <div class="input-group">
                                                <input type="text" name="ddatetime" class="form-control datepicker" data-format="yyyy-mm-dd" value="<?php
                                                if (isset($_POST["ddatetime"])) {
                                                    echo $_POST["ddatetime"];
                                                } else {
                                                    echo date('Y-m-d');
                                                }
                                                ?>">

                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group hide">
                                        <label for="field-ta" class="col-sm-1 control-label">数据粘帖区</label>

                                        <div class="col-sm-11">
                                            <textarea name="rawdata" class="form-control" rows="20" id="field-ta" placeholder="请把拷贝的港交所中央结算数据的数据直接粘贴到这里"><?php if (isset($_POST["rawdata"])) echo ""; //trim($_POST["rawdata"]); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group hide">
                                        <div class="col-sm-offset-1 col-sm-2s">
                                            <button type="submit" class="btn btn-blue">Save</button>
                                        </div><br>                                        
                                    </div>



                                </form>
                                

                            </div>

                        </div>
                    </div>
                </div>
                
                
                
                <?PHP
				
                $msg_str = "";
                $index = 0;
                if (isset($_POST) and isset($_POST["rawdata"])) {
                    $a = trim($_POST["rawdata"]);
                    
					$p=mb_strpos($a,"備註");
					$t1=mb_substr($a,0,$p);										
					$p=mb_strpos($t1,"地址");
					$t2=mb_substr($t1,$p+2);
					$p=mb_strpos($t2,"單位百分比");
					$t3=mb_substr($t2,$p+5);
					$t3=trim($t3);
					
					$a1 = explode("\n", $t3);
					
					$count=count($a1);
					//$count=15;
				
					while ($count % 5 != 0){						
						for ($i=4;$i<=$count;$i=$i+5){							
							if (strpos($a1[$i],'%')==FALSE) {
								array_splice($a1,$i-4,0,"");
								//echo $a1[$i]."<br>";							
								//echo $i."<br>";															
								break;
							}
						}
						$count=count($a1);
						break;
					}
				
					//}
					//print_rr($a1);
					
					$a1=array_chunk($a1,5);
					
					
					//echo "pppp=".$key;
					//print_rr($t3);
					//print_rr($a1);
				
	
				
					if (count($a1)>=5){
					foreach ($a1 as $data) {                        
                        if (isset($data[0])) {
                           // print_rr($a2);
                            $a3 = explode("-", $_POST['security_info']);
                            // print_rr($a3);
                            $target_security_id = $a3[0];
                            $target_security_name = $a3[1];
                            
							$target_percent = trim($data[4]);

                            $target_broker_id = trim($data[0]);
                            $target_broker_name = trim($data[1]);
                            $target_shareholding = str_replace(",", "", $data[3]);
                            $target_dday = str_replace("-", "", $_POST["ddatetime"]);
                            $table_name = "rawdata_" . $target_security_id;


                            $sql_select = "SELECT * FROM `" . $table_name . "` where security_id=" . $target_security_id . " and (broker_name='" . $target_broker_name . "' or broker_id='".$target_broker_id."') and dday=" . $target_dday;
                            //echo $sql_select."<br>";
                            $result = $conn->query($sql_select);

                            if ($result->num_rows > 0) {
                                $data = mysqli_fetch_array($result);
                                if ($data['security_name'] <> $target_security_name or $data['shareholding'] <> $target_shareholding) {
                                    //print_rr($data);
                                    $sql = "update `" . $table_name . "` set shareholding=" . $target_shareholding . ",holding_percent='" . $target_percent . "',security_name='" . $target_security_name . "' where security_id='" . $target_security_id . "' and broker_name='" . $target_broker_name . "' and dday=" . $target_dday;
                                   // echo $sql . "<br>";
                                    $conn->query($sql);
                                    $index = $index + 1;
                                    $msg_str = $msg_str . "<br>" . $index . ": 成功更新 【" . $target_broker_name . "】于日期【" . $target_dday . "】所持有【" . $target_security_name . "】的数据";
                                } else {
                                    $index = $index + 1;
                                    $msg_str = $msg_str . "<br><font color='red'>" . $index . ": 【" . $target_broker_name . "】于日期【" . $target_dday . "】所持有【" . $target_security_name . "】的数据无变化,因此不做更新</font>";
                                }
                            } else {
                               // echo $sql_select . "<br>";
                                $sql = "insert into `" . $table_name . "` (shareholding,holding_percent,security_id,security_name,broker_id,broker_name,dyear,dmonth,dday) values ('" .
                                        $target_shareholding . "','" .
                                        $target_percent . "','" .
                                        $target_security_id . "','" .
                                        $target_security_name . "','" .
                                        $target_broker_id . "','" .
                                        $target_broker_name . "','" .
                                        substr($target_dday, 0, 4) . "','" .
                                        substr($target_dday, 0, 6) . "','" .
                                        $target_dday .
                                        "')";
                               // echo $sql . "<br>";
                                $conn->query($sql);
                                $index = $index + 1;
                                $msg_str = $msg_str . "<br>" . $index . ": 成功新增 【" . $target_broker_name . "】于日期【" . $target_dday . "】所持有【" . $target_security_name . "】 的数据";
                            }
                        }
                    }
					}
                }
                ?>
                <?php if ($msg_str <> "") { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success"><strong><?php echo $msg_str; ?></strong></div>
                        </div>
                    </div>
                <?php } ?>
                <!-- Footer -->
                

                <footer class="main">


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
<script>
        $(document).ready(
                function () {
                    $("#loadingbar").hide();
                });

        
                
  function go_webspider(){
    var mywin=window.open("go_webspider.php",'_blank');    
    mywin.close();
  }
  

</script>