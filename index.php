<?php
$stime=microtime(true); 
	define('IN_ET', TRUE);
	date_default_timezone_set('UTC');
	header("Content-type: text/html; charset=utf-8");
	include( 'models/Action.php' );
$etime=microtime(true);//��ȡ����ִ�н�����ʱ��
$total=$etime-$stime;   //�����ֵ
echo "<br />{$total} times";
?>