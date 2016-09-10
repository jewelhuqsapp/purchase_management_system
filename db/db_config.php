<?php
$username = "root";
$userpass = "";
$db = "pms";
$host ="localhost";
include "rb.php";
R::setup( "mysql:host=$host;dbname=$db","$username", "$userpass" ); //for both mysql or mariaDB

/***/

date_default_timezone_set('Asia/Dhaka');

$trdate = date("Y-m-d H:i:s", time());
$d = date("d", strtotime($trdate));
$m = date("m", strtotime($trdate));
$Y = date("Y", strtotime($trdate));
$H = date("H", strtotime($trdate));
$i = date("i", strtotime($trdate));
$s = date("s", strtotime($trdate));
$trdate = date("Y-m-d H:i:s", mktime($H, $i, $s, $m, $d, $Y));
$curdate = date("Y-m-d", mktime($m, $d, $Y));

$curyesterday = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$curweek = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 7, date("Y")));
$curmonth = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("Y")));


define("CURRENT_DT", $curdate);
define("CURRENT_DTT", $trdate);
define("CURRENT_YDT", $curyesterday);

$sitetime = date("Y-m-d h:i A ", mktime($H, $i, $s, $m, $d, $Y));
/***/

function jsonResponse($msg)
{
	header('Content-Type: application/json');
 if (isset($_GET['callback'])) {
        print $_GET['callback']."(";
    }

echo json_encode($msg,JSON_UNESCAPED_SLASHES);
 if (isset($_GET['callback'])) {
        print ")";
    }
    exit; 

	
}

function REQUEST($val)
{
$val = isset($_REQUEST["$val"])?$_REQUEST["$val"]:"";

return $val;
}

/*FORM*/

class Form
{
	public static function createColumn($name)
	{
		print("<td>$name</td>");
	}
	public static function createRow()
	{
		print("<tr>");
	}
	
	public static function endRow()
	{
		print("</tr>");
	}
	
	
	public static function input($name,$value='',$placeholder='',$id='',$type='text')
	{
		return ("<input type='$type' class='formclass' name='$name' placeholder='$placeholder' id='$id' value='$value'>");
	}


	public static function select($name,$label,$value,$value_id='id',$value_name='name',$id='',$type='text')
	{
		$options="<option value=''>$label</option>";
		foreach($value as $data)
		{
			$options.="<option value='$data[$value_id]'>$data[$value_name]</option>";
		}
		return ("<select class=\"selectpicker\" data-show-subtext=\"true\" data-live-search=\"true\" name='$name' id='$id'>$options</select> ");
	}

	public static function p($text)
	{
		print("$text");

	}
	


	
	
	public static function link($href,$text)
	{
		return ("<a href='$href'>$text</a>");
	}
	
	

	
	
	
	
	
}


function getStatus($id)
{
	switch ($id) {
    case 0: return "pending"; break;
	case 1: return "complete";break;
	case 2: return "processing"; break;
	case 3: return "cancelled"; break;
	case 4: return "Active"; break;
	case 4: return "Inactive"; break;

	 default:"test";break;
	}
	
}


/***/

?>