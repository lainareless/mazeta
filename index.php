<?php
$stime=microtime(true); 
	define('IN_ET', TRUE);
	date_default_timezone_set('UTC');
	header("Content-type: text/html; charset=utf-8");
	include( 'models/Action.php' );
$etime=microtime(true);//获取程序执行结束的时间
$total=$etime-$stime;   //计算差值
echo "<br />{$total} times";
?>