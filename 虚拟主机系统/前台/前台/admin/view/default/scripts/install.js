function check_db()
{
	var url = '?c=install&a=checkdb&db_host=' + form1.db_host + '&db_name=' + form1.db_name + '&db_user=' + form1.db_user + '&db_passwd=' ;
	window.open(url,'','height=100,width=250,resize=no,scrollbars=no,toolsbar=no,top=200,left=200');
}
function pop_dzinput(status)
{
	var str="";
	if(status==1){
		 str=' <td class="td_bgc right_2">dz应用名：</td>';
		 str+='<td class="td_bgc right_2"><input name="dz_appname" type="text" id="tb_wid3" value="Discuz! Board" /></td>';
		 document.getElementById('input_dz').innerHTML=str;
	}
	if(status==0){
		 document.getElementById('input_dz').innerHTML=str;
	}
}