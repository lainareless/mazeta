<?php
/*
name:black-key_action
mail:areless@gmail.com
QQ:8228680
*/
	define('ADMIN_USERNAME','admin'); 	// Admin Username
	define('ADMIN_PASSWORD','admin');  	// Admin Password
require_once('core/Smarty.class.php');
require_once('mysql_lib.php');
require_once('in_function.php');
	class base
	{
		public $url;
		public $path;
		public $params;
		public $views;
		public function base ()
		{
			if ( $_GET['sid'] )
			{
			session_name('sid');
			session_id($_GET['sid']);
			}
			session_start();
			$this->url=$_GET['url'];
			$this->path=explode('/',$this->url,2);
		}
		public function controllerPath()
		{
			return $this->path[0];
		}
		public function controllerParams()
		{
			$this->path=explode('/',$this->path[1]);
			return $this->path;
		}
	}
	class Action extends db{
		public $url;
		public $path;
		public $params;
		public $views;
	function kmail ($to,$title,$body,$name)
	{
	$bind = new Memcache();
	$bind->connect('localhost', 11211);
	$tomail=$bind->get('mail');
	$tomail['to'][]=$to;
	$tomail['body'][]=$body;
	$tomail['name'][]=$name;
	$tomail['title'][]=$title;
	$bind->set('kmail',$tomail);
	}
	function page ($item_count,$now_pg,$one_page_long,$deepurl)
	{
	if ( ($item_count/$one_page_long)>1 )
	{
	for ( $i=1; $i <= ceil($item_count/$one_page_long); $i++ )
	{
	if ( $i==$now_pg )
	{
	$this->views['page'].='<li><a class="va" href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}else
	{
	if ( $i==1 && !$now_pg )
	{
	$now_pg=1;
	$this->views['page'].='<li><a class="va"  href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}else
	{
	if ( $i < $now_pg+3 && $i > $now_pg-3)
	{
	if ( $boma )
	{
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a>'.$boma.'</li>
	';
	$boma=null;
	}else
	{
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}
	}else
	{
	if ( $now_pg-3 <= 1 )
	{
	if ( $i == ceil($item_count/$one_page_long) )
	{
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a>...</li>
	';
	}
	if ( $i==1 )
	{
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}
	}else
	{
	if ( $now_pg+3 >= ceil($item_count/$one_page_long) )
	{
	if ( $i==1 )
	{
	$boma='...';
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}
	if ( $i == ceil($item_count/$one_page_long) )
	{
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}
	}else
	{
	if ( $i == ceil($item_count/$one_page_long) )
	{
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a>...</li>
	';
	}
	if ( $i==1 )
	{
	$boma='...';
	$this->views['page'].='<li><a href="/'.$deepurl.'/page_'.$i.'">'.$i.'</a></li>
	';
	}
	}
	}
	}
	}
	}
	}
	}
	}
		function html ($o_p,$t_p)
		{
			$view = new Smarty;
			$view->left_delimiter = '{#';
			$view->right_delimiter = '#}';
			$view->template_dir = 'views/html/';
			$view->compile_dir = 'temp/compile/html/';
			if ( $this->views )
			{
			foreach( $this->views as $key => $value )
			{
			$view->assign($key,$value);
			}
			}
			$output = $view->fetch($o_p.'.html');
			mkdir('./'.$o_p.'/'.$t_p.'/');
			$fp = fopen($o_p.'/'.$t_p.'/index.html', "w");
			fwrite($fp, $output);
			fclose($fp);
		}
		function jump($o_o='/',$o_o_o=null)
		{
		if ( $o_o_o )
		{
			$_SESSION['fin']=$o_o_o;
		}
		header("Location:".$o_o);
		}
		public function controllerPath()
		{
			return $this->path[0];
		}
		public function controllerParams()
		{
			$this->path=explode('/',$this->path[1]);
			return $this->path;
		}
		function str_cut($str ,$start, $end) {
		$content = strstr( $str, $start );
		if ( strpos( $content, $end ) )
		{
		$content = substr( $content, strlen( $start ), strpos( $content, $end ) - strlen( $start ) );
		if ( $content )
		{
		return $content;
		}else
		{
		return false;
		}
		}else
		{
		return false;
		}
		}
		/*UBB turn*/
		function ubb($str) {  
		$str=ereg_replace("\r\n","",$str);
		$str=strip_tags($str,"<a>");
		return $str; 
		} 
		function viewset($var, $cacheid = NULL, $compileid = NULL)
		{
		global $view;
		$output = $view->fetch($var, $cacheid, $compileid);
		
		echo $output;
		}
		function timecut_s( $loadtime )
		{
		date_default_timezone_set('UTC');
			if ((time()-$loadtime)<86400) {
			$h=date("G", time()-$loadtime);
			$i=date("i", time()-$loadtime);
			$s=date("s", time()-$loadtime);
			if ($h==0) {
				$mytime=(int)$i.'分钟';
				if ($i==0) {
				$mytime=(int)$s.'秒';
				}
			}else {
				if (!($mytime)) {
				$mytime=$h.'时'.(int)$i.'分钟';
				}
			}
			}else{
			$m=date("n", time()-$loadtime);
			$j=date("j", time()-$loadtime);
			if (($m-1)==0) {
			$h=date("G", time()-$loadtime);
			$mytime=($j-1).'天'.$h.'小时';
			}else {
			$mytime=$m.'月'.($j-1).'天';
			}
			if ((time()-$loadtime)>31536000) {
			$y=date("Y", time()-$loadtime);
			$y=$y-1970;
			$mytime=$y.'年'.$m.'月';
			}
			}
	date_default_timezone_set('Asia/Shanghai');
			return $mytime;
		}
		function timecut( $loadtime )
		{
		date_default_timezone_set('UTC');
			if ((time()-$loadtime)<86400) {
			$h=date("G", time()-$loadtime);
			$i=date("i", time()-$loadtime);
			$s=date("s", time()-$loadtime);
			if ($h==0) {
				$mytime=(int)$i.'分钟前';
				if ($i==0) {
				$mytime=(int)$s.'秒前';
				}
			}else {
				if (!($mytime)) {
				$mytime=$h.'时'.(int)$i.'分钟前';
				}
			}
			}else{
			$m=date("n", time()-$loadtime);
			$j=date("j", time()-$loadtime);
			if (($m-1)==0) {
			$h=date("G", time()-$loadtime);
			$mytime=($j-1).'天'.$h.'小时前';
			}else {
			$mytime=$m.'月'.($j-1).'天前';
			}
			if ((time()-$loadtime)>31536000) {
			$y=date("Y", time()-$loadtime);
			$y=$y-1970;
			$mytime=$y.'年'.$m.'月前';
			}
			}
	date_default_timezone_set('Asia/Shanghai');
			return $mytime;
		}
		public function Action ()
		{
		$this->db(my_user,my_pass,my_dbname,my_host);
			if ( $_SESSION['fin'] )
			{
				if ( $_SESSION['fin']=='exit' )
				{
					if ( session_destroy() )
					{
					$this->views['fin']='你已经安全退出！';
					}
				}else
				{
				$this->views['fin']=$_SESSION['fin'];
				unset($_SESSION['fin']);
				}
			}
			$this->url=$_GET['url'];
			$this->path=explode('/',$this->url,2);
		}
	}
	$Action =& new base();
	$Path=( $Action->controllerPath() )?( $Action->controllerPath() ):'index';
	$controllerName=$Path;
	$Path.='Controller';
	if ( is_file ( 'controllers/'.$Path.'.php' ) )
	{
		include( 'controllers/'.$Path.'.php' );
		$controller=& new $Path;
		$controller->Action();
		$Path=$Action->controllerParams();
		$controller->params=$Path;
		$Path=($Path[0])?( $Path[0] ):'index';
		if ( method_exists($controllerName.'Controller', $Path) )
		{
			$controller->$Path();
			if ( is_array($controller->views['fin']) )
			{
				$Path='fin';
				$controller->$Path();
			}
			$view = new Smarty;
			$view->debugging = FALSE;
			$view->template_dir = 'views/'.$controllerName.'/';
			$view->compile_dir = 'temp/compile/'.$controllerName;
			$view->cache_dir = 'temp/cache/'.$controllerName;
			$view->cache_lifetime = 0;
			$view->caching = FALSE;
			if ($controllerName=='index' && !$controller->views['fin'])
			{
			$view->cache_lifetime = 0;
			$view->caching = true;
			}
			$view->left_delimiter = '{#';
			$view->right_delimiter = '#}';
			if ( $controller->views )
			{
			foreach( $controller->views as $key => $value )
			{
			$view->assign($key,$value);
			}
			}
			$controller->viewset($Path.'.html');
		}else{
		include( 'controllers/indexController.php' );
		if ( method_exists('indexController',$controllerName) )
		{
			$controller=& new indexController;
			$view = new Smarty;
			$view->debugging = FALSE;
			$view->template_dir = 'views/index/';
			$view->compile_dir = 'temp/compile/index';
			$view->cache_dir = 'temp/cache/index';
			$view->left_delimiter = '{#';
			$view->right_delimiter = '#}';
			$controller->Action();
			if ( $_SESSION['id'] || $controller->views['fin'] )
			{
			$view->cache_lifetime = 0;
			$view->caching = FALSE;
			}else
			{
			$view->cache_lifetime = 0;
			$view->caching = true;
			}
			$controller->controllerParams();
			$controller->params=$controller->path;
			$controller->$controllerName();
			if ( is_array($controller->views['fin']) )
			{
				$controllerName='fin';
				$controller->$controllerName();
			}
			if ( $controller->views )
			{
				foreach( $controller->views as $key => $value )
				{
				$view->assign($key,$value);
				}
			}
				$controller->viewset($controllerName.'.html');
		}else
		{
			include( 'controllers/404Controller.php' );
		}
		}
	}else
	{
		include( 'controllers/indexController.php' );
		if ( method_exists('indexController', $controllerName) )
		{
			$controller=& new indexController;
			$view = new Smarty;
			$view->debugging = FALSE;
			$view->template_dir = 'views/index/';
			$view->compile_dir = 'temp/compile/index';
			$view->cache_dir = 'temp/cache/index';
			$view->left_delimiter = '{#';
			$view->right_delimiter = '#}';
			$controller->Action();
			if ( $_SESSION['id'] || $controller->views['fin'] ||  $controllerName=='followers' ||  $controllerName=='friends' )
			{
			$view->cache_lifetime = 0;
			$view->caching = FALSE;
			}else
			{
			$view->cache_lifetime = 0;
			$view->caching = true;
			}
			if ($controllerName=='login' || $controllerName=='about' || $controllerName=='dev' ||  $controllerName=='help' )
			{
			if ( !$controller->views['fin'] )
			{
			$view->cache_lifetime = 0;
			$view->caching = true;
			}
			}
			$controller->controllerParams();
			$controller->params=$controller->path;
			$controller->$controllerName();
			if ( is_array($controller->views['fin']) )
			{
				$controllerName='fin';
				$controller->$controllerName();
			}
			if ( $controller->views )
			{
				foreach( $controller->views as $key => $value )
				{
				$view->assign($key,$value);
				}
			}
				$controller->viewset($controllerName.'.html');
		}else{
		include( 'controllers/404Controller.php' );
		}
	}
?>