 <!--
/*
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★

	因为调用页面的编码是 <meta charset="UTF-8"> ，所以 JS文件保存的时候一定要选择 UTF-8 编码，否则页面调用时会出现乱码的情况

★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
*/

document.writeln('<div id="meizzDateLayer" style="display: none;" class="Calendar_Border" onselectstart="return false;">');
document.writeln('<span id="tmpSelectYearLayer"  style="z-index: 9999;position: absolute;top:2px;left:18px;display:none"></span>');
document.writeln('<span id="tmpSelectMonthLayer" style="z-index: 9999;position: absolute;top:2px; left:75px;display:none"></span>');
document.writeln('<table border="0" cellspacing="1" cellpadding="0" width="177px" height="160px" bgcolor="#ffffff" onselectstart="return false;">');
document.writeln('<tr><td width="170px" height="23px">');
document.writeln('<div class="Calendar_TopMenu">');
document.writeln('<table border="0px" cellspacing="0px" cellpadding="0px" width="175px" height="23px">');
document.writeln('<tr align="center">');
document.writeln(' <td class="Calendar_TopMenuButton" align="center" bgcolor="" style="font-size:10pt;" onclick="meizzPrevM()" title="向前翻　月" Author="meizz">');
document.writeln('<b Author="meizz">&#9664;&#9664;</b></td>');
document.writeln(' <td width="100px" align="center" class="Calendar_TopMenuText" Author="meizz">');
document.writeln('<b><label Author="meizz" id="TempCan" onclick="Calendar_TopMenu(this.innerHTML);" style="font-size:12px;padding:10px;cursor:pointer;"></label></b></td>');

//****************************************
//这两行代码可以删除了
//****************************************
document.writeln('<span Author="meizz" id="meizzYearHead" onclick="tmpSelectYearInnerHTML(this.innerHTML);" style="display:none;"></span><span id="meizzMonthHead"');
document.writeln(' Author="meizz" onclick="tmpSelectMonthInnerHTML(this.innerHTML);" style="display:none;"></span></td>');
//*************************************************
document.writeln(' <td class="Calendar_TopMenuButton" align="center" style="font-size:10pt;" onclick="meizzNextM();" title="往后翻　月" Author="meizz">');
document.writeln('<b Author="meizz">&#9654;&#9654;</b></td></tr></table></div></td></tr>');
document.writeln('<tr><td width="177px" height="18px" class="Calendar_Week_bg">');
document.writeln(' <table border="0px" cellspacing="0px" cellpadding="0px" width="175px" height="1px" style="cursor:default">');
document.writeln(' <tr align="center">');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">日</td>');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">一</td>');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">二</td>');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">三</td>');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">四</td>');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">五</td>');
document.writeln('  <td class="Calendar_Week_font" Author="meizz">六</td>');
document.writeln(' </tr></table></td></tr><!-- Author:F.R.Huang(meizz) http://www.meizz.com/ mail: meizz@hzcnc.com 2002-10-8 -->');
document.writeln(' <tr><td width="175px" height="120px">');
document.writeln('  <table border="0" cellspacing="1" cellpadding="0" width="175px" height="120px" bgcolor="#FFFFFF" style="cursor:default">');
var Calendar_n=0; 
	var arrCalendarYear = new Array([1900,1],[1910,2],[1920,3],[1930,4],
	[1940,5],[1950,6],[1960,7],[1970,8],[1980,9],[1990,10],[2000,11],
	[2010,12],[2020,13],[2030,14],[2040,15],[2050,16],[2060,17],
	[2070,18],[2080,19],[2090,20]);

for (j=0;j<5;j++){ 
	document.writeln (' <tr align="center">'); 
	for (i=0;i<7;i++){
		document.writeln('<td class="Calendar_Day" id="meizzDay'+Calendar_n+'" Author="meizz" onclick="meizzDayClick(this.innerHTML);"></td>');
		Calendar_n++;
	}
	document.writeln('</tr>');
}
document.writeln('  <tr align="center"><td width="20px" height="20px" class="Calendar_Day" id="meizzDay35" Author="meizz" onclick="meizzDayClick(this.innerHTML);"></td>');
document.writeln('   <td width="20px" height="20px" class="Calendar_Day" id="meizzDay36" Author="meizz" onclick="meizzDayClick(this.innerHTML);"></td>');
document.writeln('   <td Author="meizz" colspan="5">&nbsp;</td></tr></table></td></tr><tr><td>');
document.writeln('    <table border="0px" cellspacing="0px" cellpadding="0px" width="100%" bgcolor="#FFFFFF" style="cursor:default">');
document.writeln('    <tr><td Author="meizz" align="left" style="white-space:nowrap;">');
document.writeln('<div Author="meizz" id="but_BYear" title="向前翻　年" onclick="meizzPrevY();" onfocus="this.blur();" class="Calendar_Button1 Beautiful">&#9664;&#9664;</div>');
document.writeln('<div Author="meizz" id="but_BMonth" title="向前翻　月" onclick="meizzPrevM();" onfocus="this.blur();" class="Calendar_Button1 Beautiful">&#9664;</div></td>');
document.writeln('<td Author="meizz" align="center">');
document.writeln('<div Author="meizz" id="but_TDay" onclick="meizzToday();" onfocus="this.blur();" title="转到今天的日期" class="Calendar_Button2 Beautiful">今天</div>');
document.writeln('<td Author="meizz" align="right">');
document.writeln('<div Author="meizz" id="but_NMonth" onclick="meizzNextM();" onfocus="this.blur();" title="往后翻　月" class="Calendar_Button1 Beautiful">&#9654;</div>');
document.writeln('<div Author="meizz" id="but_NYear" title="往后翻　年" onclick="meizzNextY();" onfocus="this.blur();"  class="Calendar_Button1 Beautiful">&#9654;&#9654;</div>');
document.writeln('   </td></tr></table></td></tr></table>');

/* 年月选择面板 */
document.writeln('	<table Author="meizz" id="CalendarSelYM" border="0" cellspacing="0" cellpadding="0" class="Calendar_TableSelYM" bgcolor="" style="display:none;" tag="0">');
document.writeln('<tr><td height="23px"><div class="Calendar_TopMenu">');
document.writeln(' <table Author="meizz" border="0px" cellspacing="0px" cellpadding="0px" width="175px" height="23px"><tr align="center">');
document.writeln('   <td width="100px" align="center" class="Calendar_TopMenuText" Author="meizz">');
document.writeln('   &#9654;&#9654;<b><label Author="meizz" id="Calendar_labYearMonth" style="font-size:12px;cursor:pointer;padding:10px;" tag="0000Year0Month" ');
document.writeln('onclick="Calendar_TopMenu(this.innerHTML);"></label></b>&#9664;&#9664;');
document.writeln('   </td></tr></table></div></td></tr><tr><td style="height:1px;font-size:0px;"></td></tr>');
document.writeln('  <tr id="Calendar_tr_YY" style="display:none;" tag="0"><td width="177px" height="150px">');
document.writeln('    <table Author="meizz" cellpadding="0" cellspacing="1" border="0" style="font-size:12px;" width="100%"><tr>');
document.writeln('     <td Author="meizz" id="Td_YY1" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1900);">1900-<br>1909&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY2" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1910);">1910-<br>1919&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY3" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1920);">1920-<br>1929&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY4" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1930);">1930-<br>1939&nbsp;</td>');
document.writeln('    </tr><tr>');
document.writeln('     <td Author="meizz" id="Td_YY5" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1940);">1940-<br>1949&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY6" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1950);">1950-<br>1959&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY7" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1960);">1960-<br>1969&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY8" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1970);">1970-<br>1979&nbsp;</td>');
document.writeln('    </tr><tr>');
document.writeln('     <td Author="meizz" id="Td_YY9" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1980);">1980-<br>1989&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY10" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(1990);">1990-<br>1999&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY11" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2000);">2000-<br>2009&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY12" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2010);">2010-<br>2019&nbsp;</td>');
document.writeln('    </tr><tr>');
document.writeln('     <td Author="meizz" id="Td_YY13" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2020);">2020-<br>2029&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY14" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2030);">2030-<br>2039&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY15" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2040);">2040-<br>2049&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY16" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2050);">2050-<br>2059&nbsp;</td>');
document.writeln('    </tr><tr>');
document.writeln('     <td Author="meizz" id="Td_YY17" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2060);">2060-<br>2069&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY18" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2070);">2070-<br>2079&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY19" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2080);">2080-<br>2089&nbsp;</td>');
document.writeln('     <td Author="meizz" id="Td_YY20" class="Calendar_Table_Y_M1" onclick="Calendar_selYearInterval(2090);">2090-<br>2099&nbsp;</td>');
document.writeln('    </tr></table></td></tr>');

Calendar_n = 1900;

/* 循环生成年份 */
for (j=1;j<=20;j++){ 

	document.writeln (' <tr id="Calendar_tr_Year'+arrCalendarYear[j-1][0]+'" style="display:none;">'); 
	document.writeln('   <td width="177px" height="150px">');
	document.writeln('    <table Author="meizz" cellpadding="0" cellspacing="1" border="0" style="font-size:13px;" width="100%">');
	
	for(k=1;k<=3;k++){

		document.writeln('  <tr height="50">');
		
		if(Calendar_n == 1900){
			document.writeln('<td Author="meizz" class="Calendar_Table_Y_M2">&nbsp;</td>');
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;

		}else if(Calendar_n == 2097){
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			document.writeln('<td Author="meizz" class="Calendar_Table_Y_M2">&nbsp;</td>');
		}else{

			if(Calendar_n.toString().substring(3) == "9"){
				document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M2" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			}else{
				document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			}

			Calendar_n++;
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;
			document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			Calendar_n++;
			
			if(Calendar_n.toString().substring(3) == "0"){
				if(k==3){
					document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'T" class="Calendar_Table_Y_M2" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
				}else{
					document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M2" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
				}
			}else{
				document.writeln('<td Author="meizz" id="Td_Year'+Calendar_n+'" class="Calendar_Table_Y_M1" onclick="Calendar_selYear('+Calendar_n+');" style="font-size:13px;">'+Calendar_n+'</td>');
			}

			if(k==3){
				Calendar_n--;
			}else{
				Calendar_n++;
			}
			
		}

		document.writeln('</tr>');
	}
	document.writeln('</table></td></tr>');
}


document.writeln('  <tr id="Calendar_tr_Month" style="display:none;" tag="0"><td width="177px" height="150px">');
document.writeln('    <table Author="meizz" cellpadding="0" cellspacing="1" border="0" style="font-size:11px;" width="100%">');

Calendar_n = 1;
var Calendar_Num = new Array("","一","二","三","四","五","六","七","八","九","十","十一","十二");
/* 循环生成月 */
for (j=1;j<=3;j++){ 
	document.writeln (' <tr height="50">'); 
	for (i=1;i<=4;i++){
		
		document.writeln('<td Author="meizz" id="Calendar_Month'+Calendar_n+'" class="Calendar_Table_Y_M1" tag="1月" onclick="Calendar_selMonth('+Calendar_n+');" style="font-size:12px;">'+Calendar_Num[Calendar_n]+'月</td>');
		Calendar_n++;
	}
	document.writeln('</tr>');
}

document.writeln('</table></td></tr><tr><td style="height:1px;"></td></tr><tr><td></td></tr></table>');
document.writeln('</div>');


//==================================================== WEB 页面显示部分 ======================================================

	function $(id) {
		return document.getElementById(id);
	}
	function getEvent_(){

		if(document.all){

			return window.event;//如果是ie

		}

		func=getEvent_.caller;

		while(func!=null)

		{

		var arg0=func.arguments[0];

		if(arg0)

		{

		if((arg0.constructor==Event || arg0.constructor ==MouseEvent)

		||(typeof(arg0)=="object" && arg0.preventDefault && arg0.stopPropagation))

		{

		return arg0;

		}

		}

		func=func.caller;

		}

		return null;

	}
	/*
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">


		代码第一行 如果修改 成其他的 比如 
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		就可以实现<<圆角DIV>> ,但是控件 的 offsetTop 等相应属性会报错，
		最后改用
		<!doctype html>
        <html lang="en">
		这种形式，也就是 html5 规则，但有很多细节需要注意，比如 控件 的 width, height, top, left, bottom, right 等 和数字有关的都要标明 px  等
	*/

	var outObject;
	
	/*
	 *  自定义 模仿 VisualBasic 6.0 (VB)中的 Val() 方法
	*/
	String.prototype.Val = function(){

		var _strTemp = this;
		var _strString = "0123456789.-０１２３４５６７８９．－";
		var _ch;
		var _iNum = -1;
		var _strOut = "";
		for(_i = 0 ; _i < _strTemp.length ; _i++){
			_ch = _strTemp.charAt(_i);
			if(_ch == "." || _ch == "．"){
				if(_strOut.indexOf(".") >= 0){
					break;
				}
			}
			if(_ch == "-" || _ch == "－"){
				if(_strOut.length >0){
					break;
				}
			}

			_iNum = _strString.indexOf(_ch);
			if(_iNum >= 0){
				_ch =  _strString.charAt(_strString.indexOf(_ch) % 12);
				_strOut += _ch;
			}else{
				if(_strOut.length > 0){
					break;
				}
			}
		}

		if(_strOut.length == 0){
			_strOut = "0";
		}else if(_strOut == "-"){
			_strOut = "0";
		}else{

			_strOut = "" + Number(_strOut);

			if(_strOut.indexOf(".") == 0){
				_strOut = "0" + _strOut;
			}
		}
		
		/* 输出 */
		return Number(_strOut);
	}

/**********************************************************************************************/

	/*
	 *获得控件的 Tag 属性 
	*/
	function Calendar_getTag(obj){
		return obj.attributes["tag"].nodeValue;
	}
	
	/* 获得 某个年份 所在的区间 */
	function getIntervalYear(sYear){
		var i = 0;
		for(i=0;i<arrCalendarYear.length;i++){
			if(sYear - arrCalendarYear[i][0] < 10){
				return arrCalendarYear[i][0];
			}
		}
	}

	/* 获得某个 区间年 对应的编号，以便 区间年 面板 单元格样式 修改 */
	function getInterval(sYear){
		var i = 0;
		for(i=0;i<arrCalendarYear.length;i++){
			if(sYear - arrCalendarYear[i][0] < 10){
				return arrCalendarYear[i][1];
			}
		}
	}

	/* 设置  选择月 面板 单元格 样式  */
	function Calendar_MonthCss(logT){
		
		// 获得 对应 月 单元格
		var obj_td_Month = document.getElementById("Calendar_Month"+logT);
		
		// 获得 选择月 面板 的 Tag(记录了之前 选择的月，以便进行 单元格 样式改变 )
		var logTemp =  Calendar_getTag(document.getElementById("Calendar_tr_Month"));
		
		// 如果 相等，说明 选择的 和 之前 的一样 不需要改变 ，直接退出
		if(logTemp == logT){
			return;
		}
		
		// 如果 等于 0 ，说明 是第一次调用日历控件的选择月功能，直接改变后记录 Tag
		if(logTemp == 0){
			obj_td_Month.className = "Calendar_Table_Y_M3";	
			document.getElementById("Calendar_tr_Month").setAttribute("tag",logT);

		}else{
		// 如果不等于 0 则改变所选单元格 ，再把之前选择的单元格 恢复默认样式
			obj_td_Month.className = "Calendar_Table_Y_M3";
			obj_td_Month = document.getElementById("Calendar_Month"+logTemp);
			obj_td_Month.className = "Calendar_Table_Y_M1";
			document.getElementById("Calendar_tr_Month").setAttribute("tag",logT);
		}
	}
	
	/* 设置  选择年 面板 单元格 样式  */
	function Calendar_YearCss(logT){
		
		var obj_td_Year = document.getElementById("Td_Year"+logT);

		var logTemp =  Calendar_getTag(document.getElementById("CalendarSelYM"));

		if(logTemp == logT){
			return;
		}

		if(logTemp == 0){
			obj_td_Year.className = "Calendar_Table_Y_M3";	
			document.getElementById("CalendarSelYM").setAttribute("tag",logT);
		}else{
			obj_td_Year.className = "Calendar_Table_Y_M3";
			obj_td_Year = document.getElementById("Td_Year"+logTemp);
			obj_td_Year.className = "Calendar_Table_Y_M1";
			// 保存已选的 年
			document.getElementById("CalendarSelYM").setAttribute("tag",logT);
		}
		
	}
	
	/* 设置  选择区间年 面板 单元格 样式  */
	function Calendar_YearIntervalCss(logT){

		var logTemp =  Calendar_getTag(document.getElementById("Calendar_tr_YY"));

		if(logTemp == logT){
			return;
		}
		
		var obj_td_YY = document.getElementById("Td_YY"+logT);
		
		if(logTemp == 0){
			obj_td_YY.className = "Calendar_Table_Y_M3";	
			document.getElementById("Calendar_tr_YY").setAttribute("tag",logT);

		}else{
			obj_td_YY.className = "Calendar_Table_Y_M3";
			obj_td_YY = document.getElementById("Td_YY"+logTemp);
			obj_td_YY.className = "Calendar_Table_Y_M1";
			document.getElementById("Calendar_tr_YY").setAttribute("tag",logT);
		}
	}

	/* 选择月 */
	function Calendar_selMonth(logT){

		var strTemp = $("Calendar_labYearMonth").innerHTML;
		
		// 显示 日历的 5个 按钮
		ButtonHS(false);

		/*if(logT == Calendar_getTag(document.getElementById("Calendar_tr_Month"))){
			// 隐藏日期 年 月 选择 面板
			$("CalendarSelYM").style.display = "none";
			//************************************ 日历 TopMenu 显示所选 年月
			$("TempCan").innerHTML = strTemp + "年" + logT + "月";
			$("Calendar_labYearMonth").setAttribute("tag","0000Year0Month");

			return;
		}*/
		// 修改单元格样式
		Calendar_MonthCss(logT);
		
		
		$("Calendar_labYearMonth").innerHTML = "";
		// 年月显示面板的 TopMenu 也要 记录一下 xxxx年x月
		$("Calendar_labYearMonth").innerHTML = strTemp + "年" + logT + "月";
		//************************************ 日历 TopMenu 显示所选 年月
		$("TempCan").innerHTML = strTemp + "年" + logT + "月";
		meizzTheYear = strTemp;
	    meizzTheMonth = logT;
	
		meizzSetDay(meizzTheYear,meizzTheMonth);

		$("Calendar_labYearMonth").setAttribute("tag","0000Year0Month");

		// 隐藏日期 年 月 选择 面板
		$("CalendarSelYM").style.display = "none";
	}
	
	/* 选择年 */
	function Calendar_selYear(logT){

		var obj = document.getElementById("TempCan");

		$("Calendar_labYearMonth").innerHTML = logT;
		//暂时去掉，应该没有影响 obj.innerHTML = logT;
		
		// 关闭 选择年面板
		for(var i = 1900 ; i<=2090 ; i=i+10){
			obj = document.getElementById("Calendar_tr_Year" + i);
			obj.style.display = "none";
		}
		
		// 标记 TopMenu 显示 选择月面板
		obj = document.getElementById("Calendar_labYearMonth");
		obj.setAttribute("tag","Month");

		// 修改之前记录的 选择年 单元格样式
		Calendar_YearCss(logT);

		// 显示 选择月 面板
		$("Calendar_tr_Month").style.display = "";
	}
	
	/* 选择区间年 */
	function Calendar_selYearInterval(logT){
		
		// logT 保存的是 区间年的第一个年份
		var obj = document.getElementById("Calendar_labYearMonth");
		// 保存到 年月选择面板的 TopMenu 中
		obj.innerHTML = logT+"-"+(logT+9);
		// 改变 单元格样式
		Calendar_YearIntervalCss(getInterval(logT));
		//
		obj = document.getElementById("Calendar_labYearMonth");
		obj.setAttribute("tag","Year");

		// 隐藏 区间年选择 面板
		$("Calendar_tr_YY").style.display = "none";
		// 显示 年选择 面板
		obj = document.getElementById("Calendar_tr_Year" + logT);
		obj.style.display = "";
	}

	/* 显示 年 月 选择 面板  */
	function Calendar_TopMenu(sDate){
		
		var obj = document.getElementById("Calendar_labYearMonth");

		if(Calendar_getTag(obj) == "YearInterval"){

			
			return;
		}
		
		// 隐藏 日历 的 5个 按钮
		ButtonHS(true);

		$("CalendarSelYM").style.display = "";
		
		// 获得 年 月，以便 显示
		var strDate = sDate;
		var logYear = strDate.Val();
		var logMonth = strDate.substring(5).Val();
		var logTemp;

		// 显示 选择月
		if(Calendar_getTag(obj) == "0000Year0Month"){

			// 标记 Tag 当前显示 选择月 面板
			obj.setAttribute("tag","Month");

			// 将 年 显示到 TopMenu 上
			obj.innerHTML = logYear;

			Calendar_MonthCss(logMonth);
			// TopMenu 显示 年
			$("Calendar_labYearMonth").innerHTML = logYear;
			$("Calendar_tr_Month").style.display = "";

		// 显示 选择年 面板
		}else if(Calendar_getTag(obj) == "Month"){
			
			// 标记 Tag 当前显示 选择区间年 面板
			obj.setAttribute("tag","Year");
			
			// 获得标记 用于判断 之前所选 年 ，单元格样式修改
			var obj_tr_Temp = document.getElementById("CalendarSelYM");
			logTemp = Calendar_getTag(obj_tr_Temp).Val();
			var st;

			// 隐藏 选择月 面板
			$("Calendar_tr_Month").style.display = "none";
			obj_tr_Temp.style.display = "";
			logTemp = getIntervalYear(obj.innerHTML.Val());

			// 获得 所需要显示的 年 所在行
			obj_tr_Temp = document.getElementById("Calendar_tr_Year" + logTemp);
			obj_tr_Temp.style.display = "";

			// 修改单元格样式
			logTemp = obj.innerHTML.Val();
			Calendar_YearCss(logTemp);


		// 显示 选择区间年
		}else{
			
			// 标记 Tag 当前显示 选择 年 面板
			obj.setAttribute("tag","YearInterval");

			// 获得 TopMenu 中的年
			logTemp  = $("Calendar_labYearMonth").innerHTML.Val();
			logTemp = getIntervalYear(logTemp);
			// TopManu Label 显示 区间年
			$("Calendar_labYearMonth").innerHTML = logTemp + "-" + (logTemp +9);
			// 隐藏 选择年 面板
			obj = document.getElementById("Calendar_tr_Year" + logTemp);
			obj.style.display = "none";
			
			// 修改 选择区间年 面板单元格样式
			logTemp  = $("Calendar_labYearMonth").innerHTML.Val();
			logTemp = getInterval(logTemp);
			Calendar_YearIntervalCss(logTemp);
			
			// 显示 选择区间年 面板
			obj = document.getElementById("Calendar_tr_YY");
			obj.style.display = "";

		}
	}
/**********************************************************************************************/
	function setday(tt,obj)
	{ //主调函数
		/* 
			arguments 是自定义方法的一个内部参数值，用于标识 此方法实际传入的参数个数，比如这个 当前方法 setday(tt,obj) ，定义的时候是 2 个 参数，而在下面的实际调用中，我只传入了1个参数 ，所以此时的
			arguments.length 等于 1  ，此页面我是通过 文本框直接调用方法的,所以 参数 tt 就是输出控件，如果是通过点击其他控件调用日历，则 方法 第一个 tt 参数传入日历显示时所要定位的参照控件，第二个 obj 参数传入输出控件即可
		*/
	  if (arguments.length >  2){alert("对不起！传入本控件的参数太多！");return;}
	  if (arguments.length == 0){alert("对不起！您没有传回本控件任何参数！");return;}
	  var dads  = $("meizzDateLayer").style;
	  var th = tt;
	  var ttop  = tt.offsetTop;     //TT控件的定位点高
	  var thei  = tt.clientHeight;  //TT控件本身的高
	  var tleft = tt.offsetLeft;    //TT控件的定位点宽
	  var ttyp  = tt.type;          //TT控件的类型
	  while (tt = tt.offsetParent){ttop+=tt.offsetTop; tleft+=tt.offsetLeft;}
	  

	  /*
		两种表达方法都可以 
		dads.top = dads["top"]
		dads.left = dads["left"]
		
		在这里，指定控件位置必须加 px ,否则不识别

	  */
	  //dads.top  = (ttyp=="image")? ttop+thei+"px" : ttop+thei+6+"px";
	  dads["top"]  = (ttyp=="image")? ttop+thei+"px" : ttop+thei+4+"px";
	  //dads.left = tleft+"px";
	  dads["left"] = tleft+"px";
		
	  outObject = (arguments.length == 1) ? th : obj;
	  dads.display = "";

	  event.returnValue=false;
	}

	var MonHead = new Array(12);               //定义阳历中每个月的最大天数
		MonHead[0] = 31; MonHead[1] = 28; MonHead[2] = 31; MonHead[3] = 30; MonHead[4]  = 31; MonHead[5]  = 30;
		MonHead[6] = 31; MonHead[7] = 31; MonHead[8] = 30; MonHead[9] = 31; MonHead[10] = 30; MonHead[11] = 31;

	var meizzTheYear=new Date().getFullYear(); //定义年的变量的初始值
	var meizzTheMonth=new Date().getMonth()+1; //定义月的变量的初始值
	var meizzWDay=new Array(37);               //定义写日期的数组　

	document.onclick=function() //任意点击时关闭该控件
	{ 
		var evt=getEvent_();

		var element=evt.srcElement || evt.target;
		
	  with(element){ 
		if (tagName != "INPUT" && getAttribute("Author")==null){
			$("meizzDateLayer").style.display="none";
			ButtonHS(false);
			$("CalendarSelYM").style.display="none";
		}
	  }
	}

	function meizzWriteHead(yy,mm)  //往 head 中写入当前的年与月
	  { 
		//document.all.meizzYearHead.innerHTML  = yy;
		//document.all.meizzMonthHead.innerHTML = mm;
		$("TempCan").innerHTML = yy + "年" + mm + "月";
	  }

	function tmpSelectYearInnerHTML(strYear) //年份的下拉框
	{
	  if (strYear.match(/\D/)!=null){alert("年份输入参数不是数字！");return;}
	  var m = (strYear) ? strYear : new Date().getFullYear();
	  if (m < 1000 || m > 9999) {alert("年份值不在 1000 到 9999 之间！");return;}
	  var n = m - 10;
	  if (n < 1000) n = 1000;
	  if (n + 26 > 9999) n = 9974;
	  var s = "<select Author=meizz name=tmpSelectYear style='font-size:14px;' "
		 s += "onblur='$(\"tmpSelectYearLayer\").style.display=\"none\"' "
		 s += "onchange='$(\"tmpSelectYearLayer\").style.display=\"none\";"
		 s += "meizzTheYear = this.value; meizzSetDay(meizzTheYear,meizzTheMonth)'>\r\n";
	  var selectInnerHTML = s;
	  for (var i = n; i < n + 26; i++)
	  {
		if (i == m)
		   {selectInnerHTML += "<option value='" + i + "' selected>" + i + "年" + "</option>\r\n";}
		else {selectInnerHTML += "<option value='" + i + "'>" + i + "年" + "</option>\r\n";}
	  }
	  selectInnerHTML += "<option value='" + 1900 + "'>" + 1900 + "年" + "</option>\r\n";
	  selectInnerHTML += "<option value='" + 2099 + "'>" + 2099 + "年" + "</option>\r\n";
	  selectInnerHTML += "</select>";
	  $("tmpSelectYearLayer").style.display="";
	  $("tmpSelectYearLayer").style.top="2px";
	  $("tmpSelectYearLayer").style.left="35px";
	  $("tmpSelectYearLayer").innerHTML = selectInnerHTML;
	  $("tmpSelectYear").focus();
	}

	function tmpSelectMonthInnerHTML(strMonth) //月份的下拉框
	{
	  if (strMonth.match(/\D/)!=null){alert("月份输入参数不是数字！");return;}
	  var m = (strMonth) ? strMonth : new Date().getMonth() + 1;
	  var s = "<select Author=meizz name=tmpSelectMonth style='font-size:14px' "
		 s += "onblur='$(\"tmpSelectMonthLayer\").style.display=\"none\"' "
		 s += "onchange='$(\"tmpSelectMonthLayer\").style.display=\"none\";"
		 s += "meizzTheMonth = this.value; meizzSetDay(meizzTheYear,meizzTheMonth)'>\r\n";
	  var selectInnerHTML = s;
	  for (var i = 1; i < 13; i++)
	  {
		if (i == m)
		   {selectInnerHTML += "<option value='"+i+"' selected>"+i+"月"+"</option>\r\n";}
		else {selectInnerHTML += "<option value='"+i+"'>"+i+"月"+"</option>\r\n";}
	  }
	  selectInnerHTML += "</select>";
	  $("tmpSelectMonthLayer").style.display="";
	  $("tmpSelectMonthLayer").style.top="2px";
	  $("tmpSelectMonthLayer").style.left="68px";
	  $("tmpSelectMonthLayer").innerHTML = selectInnerHTML;
	  $("tmpSelectMonth").focus();
	}

	function closeLayer()               //这个层的关闭
	  {
		$("meizzDateLayer").style.display="none";
	  }

	document.onkeydown=function(e){
		var val;  
		if (!e){  
			var e = window.event;  
		}  

		if (e.keyCode){  
			val = e.keyCode;  
		}else if(e.which){  
			val = e.which;  
		} 
		if (val==27)$("meizzDateLayer").style.display="none";
	}

	function IsPinYear(year)            //判断是否闰平年
	  {
		if (0==year%4&&((year%100!=0)||(year%400==0))) return true;else return false;
	  }

	function GetMonthCount(year,month)  //闰年二月为29天
	  {
		var c=MonHead[month-1];if((month==2)&&IsPinYear(year)) c++;return c;
	  }

	function GetDOW(day,month,year)     //求某天的星期几
	  {
		var dt=new Date(year,month-1,day).getDay()/7; return dt;
	  }

	function meizzPrevY()  //往前翻 Year
	  {
		if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear--;}
		else{alert("年份超出范围（1000-9999）！");}
		meizzSetDay(meizzTheYear,meizzTheMonth);
	  }
	function meizzNextY()  //往后翻 Year
	  {
		if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear++;}
		else{alert("年份超出范围（1000-9999）！");}
		meizzSetDay(meizzTheYear,meizzTheMonth);
	  }
	function meizzToday()  //Today Button
	  {
		meizzTheYear = new Date().getFullYear();
		meizzTheMonth = new Date().getMonth()+1;
		meizzSetDay(meizzTheYear,meizzTheMonth);
	  }
	function meizzPrevM()  //往前翻月份
	  {
		if(meizzTheMonth>1){meizzTheMonth--}else{meizzTheYear--;meizzTheMonth=12;}
		meizzSetDay(meizzTheYear,meizzTheMonth);
	  }
	function meizzNextM()  //往后翻月份
	  {
		if(meizzTheMonth==12){meizzTheYear++;meizzTheMonth=1}else{meizzTheMonth++}
		meizzSetDay(meizzTheYear,meizzTheMonth);
	  }

	function meizzSetDay(yy,mm)   //主要的写程序**********
	{
	  meizzWriteHead(yy,mm);
	  for (var i = 0; i < 37; i++){meizzWDay[i]=""};  //将显示框的内容全部清空
	  var day1 = 1;
	  var firstday = new Date(yy,mm-1,1).getDay();  //某月第一天的星期几
	  for (var i = firstday; day1 < GetMonthCount(yy,mm)+1; i++){meizzWDay[i]=day1;day1++;}
	  for (var i = 0; i < 37; i++){ 
		
		/* 这2种定义方法都可以 */
		//var da = eval("document.all.meizzDay"+i);     //书写新的一个月的日期星期排列
		var da = document.getElementById("meizzDay"+i);

		if (meizzWDay[i]!=""){ 
			
			da.innerHTML = "" + meizzWDay[i] + "";
			
			// 判断是不是当日
			if(yy == new Date().getFullYear() && mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()){
				
				da.className = "Calendar_Today";
				/*da.style.backgroundColor = "#9bffff";
				da.style.color = "#ff00ff";*/
			}else{
				da.className = "Calendar_Day";
				/*da.style.backgroundColor = "#f0f0f0";
				da.style.color = "#000000";*/
			}
			/*da.style.backgroundColor = (yy == new Date().getFullYear() &&
			mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()) ? "#9bffff" : "#f0f0f0";*/

			da.style.cursor="hand";
		  }else{
			da.innerHTML ="";
			da.className ="Calendar_DayBlank";
			/*da.style.backgroundColor="#ffffff";
			da.style.cursor="default";*/
		  }
	  }
	}
	function meizzDayClick(n)  //点击显示框选取日期，主输入函数*************
	{
	  var yy = meizzTheYear;
	  var mm = meizzTheMonth;
	  if (mm < 10){mm = "0" + mm;}
	  if (outObject)
	  {
		if (!n) {outObject.value=""; return;}
		if ( n < 10){n = "0" + n;}
		// 判断 调用日立的控件是 文本框还是其他
		if(outObject.nodeName.toUpperCase() == "INPUT"){
			outObject.value= yy + "-" + mm + "-" + n ; //注：在这里你可以输出改成你想要的格式
		}else{
			outObject.innerHTML = yy + "-" + mm + "-" + n ;
		}
		
		closeLayer(); 
	  }
	  else {closeLayer(); alert("您所要输出的控件对象并不存在！");}
	}
	
	function ButtonHS(bln){
		if(bln){
			$("but_BYear").style.display = "none";
			$("but_BMonth").style.display = "none";
			$("but_TDay").style.display = "none";
			$("but_NMonth").style.display = "none";
			$("but_NYear").style.display = "none";

		}else{
			$("but_BYear").style.display = "";
			$("but_BMonth").style.display = "";
			$("but_TDay").style.display = "";
			$("but_NMonth").style.display = "";
			$("but_NYear").style.display = "";
			$("Calendar_labYearMonth").setAttribute("tag","0000Year0Month");
			// 关闭 年月选择的所有行
			var obj;
			for(var i = 1900 ; i<=2090 ; i=i+10){
				obj = document.getElementById("Calendar_tr_Year" + i);
				obj.style.display = "none";
			}
			obj = document.getElementById("Calendar_tr_Month");
			obj.style.display = "none";
			obj = document.getElementById("Calendar_tr_YY");
			obj.style.display = "none";
		}
	}

	meizzSetDay(meizzTheYear,meizzTheMonth);
 //-->