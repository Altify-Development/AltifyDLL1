<?php

if(!defined('GRANTED')) die;

echo '<table align=center width=900 class=table style="border:1px solid #425B6A;margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center><td class=table1 colspan=2>Общие</td></tr>
<form method=post action="?page=options&act=opt">
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
	<td align=right width=450px>Логин:</td>
	<td><input type=text class=text name="login" value="'.$login.'" maxlength=12></td>
</tr>
<tr>
	<td width=160 align=right>Пароль:</td>
	<td><input type=password class=text name="passw" maxlength=12></td>
</tr>
<tr>
	<td width=160 align=right>Новый пароль:</td>
	<td><input type=password class=text name="newpassw" maxlength=12></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
	<td align=right>Считать бота оффлайн после</td>
	<td><input type=text class=text name="delay" maxlength=4 value="'.$delay.'" style="width:30px;text-align:center;"> секунд неактивности</td>
</tr>
<tr>
	<td align=right>Считать бота мертвым после</td>
	<td><input type=text class=text name="dead" value="'.$dead.'" maxlength=3 style="width:30px;text-align:center;"> дней неактивности</td>
</tr>
<tr>
	<td align=right>В разделе \'Боты\' показывать</td>
	<td><input type=text class=text name="num" value="'.$num.'" maxlength=4 style="width:30px;text-align:center;"> записей на страницу</td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2 align=center>&nbsp;'.((!$info and $_GET['a'])?('<font color=green>Настройки успешно сохранены</font>'):($info)).'</td></tr>
<tr><td colspan=2 align=center><input class=button type=submit value="Сохранить"></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</form>

</table>';

?>