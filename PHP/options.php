<?php

if(!defined('GRANTED')) die;

echo '<table align=center width=900 class=table style="border:1px solid #425B6A;margin-bottom:5px;" cellpadding=1 cellspacing=1>
<tr align=center><td class=table1 colspan=2>�����</td></tr>
<form method=post action="?page=options&act=opt">
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
	<td align=right width=450px>�����:</td>
	<td><input type=text class=text name="login" value="'.$login.'" maxlength=12></td>
</tr>
<tr>
	<td width=160 align=right>������:</td>
	<td><input type=password class=text name="passw" maxlength=12></td>
</tr>
<tr>
	<td width=160 align=right>����� ������:</td>
	<td><input type=password class=text name="newpassw" maxlength=12></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
	<td align=right>������� ���� ������� �����</td>
	<td><input type=text class=text name="delay" maxlength=4 value="'.$delay.'" style="width:30px;text-align:center;"> ������ ������������</td>
</tr>
<tr>
	<td align=right>������� ���� ������� �����</td>
	<td><input type=text class=text name="dead" value="'.$dead.'" maxlength=3 style="width:30px;text-align:center;"> ���� ������������</td>
</tr>
<tr>
	<td align=right>� ������� \'����\' ����������</td>
	<td><input type=text class=text name="num" value="'.$num.'" maxlength=4 style="width:30px;text-align:center;"> ������� �� ��������</td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2 align=center>&nbsp;'.((!$info and $_GET['a'])?('<font color=green>��������� ������� ���������</font>'):($info)).'</td></tr>
<tr><td colspan=2 align=center><input class=button type=submit value="���������"></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</form>

</table>';

?>