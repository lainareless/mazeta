<?php
/*
name:ror_way
mail:areless@gmail.com
QQ:8228680
*/
require('db_mysql.class.php');
define('my_user', 'root'); /*input*/
define('my_pass', 'orz');
define('my_dbname', 'tuanse'); 
define('my_host', '127.0.0.1');
class db extends dbstuff
{
	public $table;
	public $where;
	public $where_value;
	public $savetemp;
	public $LIMIT;
	public $ORDER;
	public $hack;
	public $f;
	public $count_set;
	public function db($user,$pass,$dbname,$host)
	{
	$this->connect($host,$user,$pass,$dbname, $pconnect,true,"UTF8");
	}
	public function find_all ( $value='user' )
	{
			if ($this->LIMIT) {
				$myLIMIT=' limit '.$this->LIMIT;
			}
			if ( $this->count_set )
			{
			$r=$this->query("select count(*) from ".$value.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC'));
			if (!$r || empty($r)) {
				return false;
			}else
			{
			$num=$this->query($r);
			$backr['count']=$num['count(*)'];
			}
			}
			$query='select '.(($this->f)?($this->f):('*')).' from '.$value.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC').$myLIMIT;
			if ( $this->f!='nil' )
			{
			$r=$this->query($query);
			if (!$r || empty($r)) {
				return false;
			}
			$num=0;
			while ( $row=$this->fetch_array($r, MYSQL_ASSOC)) 
			{
			foreach ($row as $key => $value) 
			{
					$backr[$key][$num]=$value;
			}
			$num++;
			}
			}
			$this->free_result($r);
			return	$backr;
	}
	public function find_by ($value=null)
	{
			if ($this->LIMIT) {
				$myLIMIT=' limit '.$this->LIMIT;
			}
			if(! ereg("^(-{0,1}|\+{0,1})[0-9]+(\.{0,1}[0-9]+)$",str_replace(',','',$this->where_value))){
			$this->where_value='\''.$this->where_value;
			$this->where_value=str_replace(',','\',\'',$this->where_value);
			$this->where_value=$this->where_value.'\'';
			}
			if ( $this->hack )
			{
			if ( $this->count_set )
			{
			$r=$this->query("select count(*) from ".$this->table.' where '.$this->hack.($value?$value:$this->where).' in ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC'));
			}
			$query='select '.(($this->f)?($this->f):('*')).' from '.$this->table.' where '.$this->hack.($value?$value:$this->where).' in ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC').$myLIMIT;
			}else
			{
			if ( $this->count_set )
			{
			$r=$this->query("select count(*) from ".$this->table.' where '.($value?$value:$this->where).' in ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC'));
			}
			$query='select '.(($this->f)?($this->f):('*')).' from '.$this->table.' where '.($value?$value:$this->where).' in ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC').$myLIMIT;
			}
			if ( $this->count_set )
			{
			if (!$r || empty($r)) {
				return false;
			}else
			{
			$num=$this->fetch_array($r);
			if ( $num['count(*)']==0 )
			{
				return false;
			}else
			{
			$backr['count']=$num['count(*)'];
			}
			}
			}
			if ( $this->f!='nil' )
			{
			$r=$this->query($query);
			if (!$r || empty($r)) {
				return false;
			}
			$num=0;
			while ( $row=$this->fetch_array($r, MYSQL_ASSOC)) 
			{
			foreach ($row as $key => $value) 
			{
					$backr[$key][$num]=$value;
			}
			$num++;
			}
			if ( $num==1 )
			{
			foreach( $backr as $key => $value )
			{
			if ( $this->count_set!='open' )
			{
			$back_r[$key]=$value[0];
			}
			}
			}
			}
			$this->free_result($r);
			return	($back_r?$back_r:$backr);
	}
	public function squery($value=null){
			$r=$this->query($value);
			$num=0;
			while ( $row=$this->fetch_array($r, MYSQL_ASSOC)) 
			{
			foreach ($row as $key => $value) 
			{
					$backr[$key][$num]=$value;
			}
			$num++;
			}
			$this->free_result($r);
			return	($backr);
	}
	public function like_by ($value=null)
	{
			if ($this->LIMIT) {
				$myLIMIT=' limit '.$this->LIMIT;
			}
			if(! ereg("^(-{0,1}|\+{0,1})[0-9]+(\.{0,1}[0-9]+)$",str_replace(',','',$this->where_value))){
			$this->where_value='\''.$this->where_value;
			$this->where_value=str_replace(',','\',\'',$this->where_value);
			$this->where_value=$this->where_value.'\'';
			}
			if ( $this->hack )
			{
			$r=$this->query("select count(*) from ".$this->table.' where '.$this->hack.($value?$value:$this->where).' like ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC'));
			$query="select * from ".$this->table.' where '.$this->hack.($value?$value:$this->where).' like ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC').$myLIMIT;
			}else
			{
			$r=$this->query("select count(*)  from ".$this->table.' where '.($value?$value:$this->where).' like ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC'));
			$query="select * from ".$this->table.' where '.($value?$value:$this->where).' like ('.$this->where_value.')'.(($this->ORDER)?(' ORDER BY '.$this->ORDER):' ORDER BY id DESC').$myLIMIT;
			}
			if (!$r || empty($r)) {
				return false;
			}else
			{
			$num=$this->fetch_array($r);
			if ( $num['count(*)']==0 )
			{
				return false;
			}else
			{
			$backr['count']=$num['count(*)'];
			}
			}
			if ( $this->f!='nil' )
			{
			$r=$this->query($query);
			if (!$r || empty($r)) {
				return false;
			}
			$num=0;
			while ( $row=$this->fetch_array($r, MYSQL_ASSOC)) 
			{
			foreach ($row as $key => $value) 
			{
					$backr[$key][$num]=$value;
			}
			$num++;
			}
			if ( $num==1 )
			{
			foreach( $backr as $key => $value )
			{
			if ( $this->count_set!='open' )
			{
			$back_r[$key]=$value[0];
			}
			}
			}
			}
			$this->free_result($r);
			return	($back_r?$back_r:$backr);
	}
	public function save ()
	{
			$id=1;
			$query='UPDATE '.$this->table.' SET ';
			foreach ($this->savetemp as $key => $value) 
			{
			$value=eregi_replace("'","''",$value);
					if ( $id==1 )
					{
					$query.=$key.'=\''.$value.'\'';
					$savel=$key;
					$saver='\''.$value.'\'';
					}else{
					$query.=','.$key.'=\''.$value.'\'';
					$savel.=','.$key;
					$saver.=',\''.$value.'\'';
					}
					$id++;
			}
			$query.=' where '.$this->where.' in ('.$this->where_value.')';
			$this->savetemp=null;
			if ( $this->where )
			{
			$this->query($query);
			return	true;
			}else{
			$query='INSERT INTO '.$this->table.' ('.$savel.') VALUES ('.$saver.')';
			$this->query($query);
			return	$this->i_id();
			}
	}
	public function del ($value=null,$val=null)
	{
		$query='delete from '.$this->table.' where '.($val?$val:$this->where).'=\''.($value?$value:$this->where_value).'\'';
		$this->query($query);
		return	true;
	}
}
$db=new db(my_user,my_pass,my_dbname,my_host);
/*
=========find all
$db->LIMIT='0,10';
$aa=$db->find_all('albums');
//$aa['count'];
//$aa['more'][num];
echo '<br>';
print_r($aa);
=========find one;
$db->table='albums';
$db->where_value='1';
$bb=$db->find_by('id');
//$bb['count'];
//$bb['more'][num];
echo '<br>';
print_r($bb);
========like by;
$db->table='albums';
$db->where_value='\'%%%1%%%\'';
$cc=$db->like_by('id');
//$cc['count'];
//$cc['more'][num];
echo '<br>';
print_r($cc);
========insert;
$db->savetemp=array('artist'=>'a','title '=>'b');
//$db->savetemp['artist']='a';
//$db->savetemp['title']='b';
$db->save();
========update;
$db->where='id'; /if where input turn update/
$db->savetemp=array('artist'=>'a','title '=>'b');
//$db->savetemp['artist']='a';
//$db->savetemp['title']='b';
$db->save();
*/
?>
