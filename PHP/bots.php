<?php

if(!defined('GRANTED')) die;

include '../include/mysql.php';
mysql_connect($db_host, $db_user, $db_pass) or die('<font color=red>�� ������� ������������ � ����!</font>');
mysql_select_db($db_name) or die('<font color=red>�� ������� ���� "'.$db_name.'"!</font>');

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
	<td class=table1>ID ����</td>
	<td class=table1>������</td>
	<td class=table1>IP �����</td>
	<td class=table1>[ISO] ������</td>
	<td class=table1>�������</td>
	<td class=table1>������</td>
	<td class=table1>��� ��</td>
	<td class=table1>�������� �������</td>
	<td class=table1>�����</td>
</tr>';

	$mtime = intval(filemtime('../data/update.dat'));
	while ($row = mysql_fetch_array($answ)) {

		echo '<tr align=center '.(($row['lastknock']+60*60*24*$dead<time() or $row['orders']=='deleted')?('style="color:firebrick;" '):(($row['lastknock']+$delay>time())?('style="color:green;" '):(''))).'onmouseover="this.className=\'string\';" onmouseout="this.className=\'\';">
	<td>'.$row['id'].'</td>
	<td>'.(($mtime==$row['version'])?('����.'):(date('d.m.y', $row['version']))).'</td>
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
	<td class=table1>�����:</td>
	<td class=table1 colspan=4>� ���� �����: '.$records[0].' , ��������: '.$bcoun.'</td>
	<td class=table1 style="color:green;">[*] - ������</td>
	<td class=table1>[*] - �������</td>
	<td class=table1 style="color:firebrick;">[*] - �����</td>
	<td class=table1>&nbsp;</td>
</tr>
</table>
'.$pagestr;

}

?>