<?php

if(!defined('GRANTED')) die;

include '../include/mysql.php';
mysql_connect($db_host, $db_user, $db_pass) or die('<font color=red>Не удалось подключиться к базе!</font>');
mysql_select_db($db_name) or die('<font color=red>Не найдена база "'.$db_name.'"!</font>');

$from=intval($_GET['from']);
$answ = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM bots ORDER BY birthday ASC LIMIT $from, $num");
$records = mysql_fetch_array(mysql_query('SELECT FOUND_ROWS()'));

if ($bcoun = mysql_num_rows($answ)) {

	$pages = ($records[0]/$num);

	if ($pages>1) {

		$pagestr = '<table align=center width=900 class=table style="margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center>
	<td>';
		for ($i=0;$i<$pages;$i++) {
			$pagestr .= ($i*$num==$from)?(($i+1)):('<a href="?page=bots&from='.($i*$num).'">'.($i+1).'</a>');
			if ($i+1<$pages) $pagestr .= ' - ';
		}
		$pagestr .= '</td>
</tr>
</table>
';

	}

	echo $pagestr.'<table align=center width=900 class=table style="margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center>
	<td class=table1>ID бота</td>
	<td class=table1>Версия</td>
	<td class=table1>IP адрес</td>
	<td class=table1>[ISO] Страна</td>
	<td class=table1>Родился</td>
	<td class=table1>Отстук</td>
	<td class=table1>Бан до</td>
	<td class=table1>Выполнил задания</td>
	<td class=table1>Всего</td>
</tr>';

	$mtime = intval(filemtime('../data/update.dat'));
	while ($row = mysql_fetch_array($answ)) {

		echo '<tr align=center '.(($row['lastknock']+60*60*24*$dead<time() or $row['orders']=='deleted')?('style="color:firebrick;" '):(($row['lastknock']+$delay>time())?('style="color:green;" '):(''))).'onmouseover="this.className=\'string\';" onmouseout="this.className=\'\';">
	<td>'.$row['id'].'</td>
	<td>'.(($mtime==$row['version'])?('посл.'):(date('d.m.y', $row['version']))).'</td>
	<td>'.long2ip($row['ip']).'</td>
	<td nowrap>['.$COUNTRY_CODE[$row['country']].'] '.$COUNTRY_NAME[$row['country']].'</td>
	<td>'.date('d.m.y H:i:s', $row['birthday']).'</td>
	<td>'.date('d.m.y H:i:s', $row['lastknock']).'</td>
	<td>'.(($row['nextload']>time())?(date('d M Y H:i:s', $row['nextload'])):('-')).'</td>
	<td>'.(($row['orders'])?($row['orders']):('-')).'</td>
	<td>'.(($row['onboard'])?($row['onboard']):('-')).'</td>
</tr>';

	}

	echo '<tr align=center>
	<td class=table1>Итоги:</td>
	<td class=table1 colspan=4>В базе ботов: '.$records[0].' , показано: '.$bcoun.'</td>
	<td class=table1 style="color:green;">[*] - онлайн</td>
	<td class=table1>[*] - оффлайн</td>
	<td class=table1 style="color:firebrick;">[*] - мертв</td>
	<td class=table1>&nbsp;</td>
</tr>
</table>
'.$pagestr;

}

?>