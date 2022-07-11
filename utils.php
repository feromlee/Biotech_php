<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function print_rr($data_raw) {
    echo "<pre>";
    print_r($data_raw);
    echo "</pre>";
}

function get_line_data($conn, $security_id, $date_start, $date_end, $broker_list,$limit_number) {
    $table_name = "rawdata_" . $security_id;
    $sqlstr = "select DISTINCT dday FROM `" . $table_name . "` WHERE dday>=" . $date_start . " and dday<=" . $date_end . " order by dday";

    $result = mysqli_query($conn, $sqlstr);
    $day_table = mysqli_fetch_all($result);

    // print_rr($day_table);
    $broker_list_w = "";
    $result_overall['data'] = "";
    $result_overall['ykeys'] = "";
    $result_overall['labels'] = "";

    if ($broker_list != "") {
        $broker_list = str_replace("；", ";", $broker_list);
        $broker_list = trim($broker_list, ";");
        $broker_list = explode(";", $broker_list);

        foreach ($broker_list as $b_id) {
            $broker_list_w = $broker_list_w . ",'" . $b_id . "'";
        }
        $broker_list_w = trim($broker_list_w, ",");
        $broker_list_w = " and (broker_name in (" . $broker_list_w . ") or broker_id in (" . $broker_list_w . "))";
    }
    
    $limit_str="";
    if ($limit_number>0){
        $limit_str=" limit ".$limit_number." ";
    }

    //$broker_list_w = "";
    $sqlstr = "SELECT DISTINCT broker_id,broker_name FROM `" . $table_name . "` WHERE dday>=" . $date_start . " and dday<=" . $date_end.$broker_list_w." order by shareholding desc ".$limit_str;
    //echo $sqlstr;
    $result = mysqli_query($conn, $sqlstr);
    //print_rr($result);

    if ($result->num_rows > 0) {
        $broker_table = mysqli_fetch_all($result);        
        //print_rr($broker_table);
        $result_data = "";
        foreach ($day_table as $day) {
            //$day_f=substr($day[0],0,4)."-".substr($day[0],5,2)."-".substr($day[0],7,2);

            $result_data = $result_data . "{y:'" . $day[0] . "'";
            foreach ($broker_table as $broker) {
                //print_rr($broker);
                $sqlstr = "select shareholding from `" . $table_name . "` where dday=" . $day[0] . " and broker_id='" . $broker[0] . "'";
                // echo $sqlstr."<br>";
                $result = mysqli_query($conn, $sqlstr);
                // print_rr($result);
                if ($result->num_rows > 0) {
                    $volumn_table = mysqli_fetch_all($result);
                    $result_data = $result_data . ",'" . $broker[0] . "':" . $volumn_table[0][0];
                } else {
                    $result_data = $result_data . ",'" . $broker[0] . "':0";
                }
            }
            $result_data = $result_data . "},";
        }
        $result_overall['data'] = $result_data;
        foreach ($broker_table as $key) {
           // print_rr($key);
            $result_overall['ykeys'] = $result_overall['ykeys'] . ",'" . $key[0] . "'";
            $result_overall['labels'] = $result_overall['labels'] . ",'" . $key[1] . "'";
        }
        $result_overall['ykeys'] = trim($result_overall['ykeys'], ",");
        $result_overall['labels'] = trim($result_overall['labels'], ",");
    }




    //print_rr($result_overall);
    return $result_overall;
}

function get_mysql_conn() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biotech";

// 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_query($conn, "set character set 'utf8'");
    //$conn->query("set character set 'utf8'");
// 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    return $conn;
}

?>