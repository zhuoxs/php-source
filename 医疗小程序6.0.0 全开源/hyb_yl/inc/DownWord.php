<?php
/**
* 
*/
class DownWord 
{
     protected $data;
          function __construct($row,$u_thumb) {
            $this->data = $row;
            $this->u_thumb =$u_thumb;
        }
        public function Word(){
        	$row = $this->data;
        	$title=array();
        	$html='';
        	foreach ($row as $key => $value) {
        	   $info = $value['info'];
        	   foreach ($info as $val) {
        	   	$title= $val['title'];
        	   	$name = $val['description'];
        	   	$displaytype = $val['displaytype'];
					$html.="<body>
					<h1 style='text-align: center'>患者病程</h1>
					<table border='1' cellpadding='3' cellspacing='0'>
					<tr {if $displaytype == '' || $displaytype =='0'}>
					<td width='93' valign='center' colspan='2'>".$title."</td>
					<td width='160' valign='center' colspan='4' >".$name."</td>
					<td width='89' valign='center' colspan='2' >学历</td>
					<td width='156' valign='center' colspan='3' >xxx</td>
					<td width='125' colspan='2' rowspan='4' align='center' valign='middle' ><img src=$this->u_thumb width='120' height='120' /></td>
					</tr>
					<tr >
					<td width='93' valign='center' colspan='2'>性别</td>
					<td width='72' valign='center' colspan='2' >xxx</td>
					<td width='88' valign='center' colspan='2' >出生年月</td>
					<td width='89' valign='center' colspan='2' >xxx</td>
					<td width='68' valign='center' >户籍地</td>
					<td width='87' valign='center' colspan='2' >xxx</td>
					</tr>
					<tr >
					<td width='93' valign='center' colspan='2' >身高</td>
					<td width='72' valign='center' colspan='2' >xxxcm</td>
					<td width='88' valign='center' colspan='2' >体重</td>
					<td width='89' valign='center' colspan='2' >xxxkg</td>
					<td width='68' valign='center' >婚姻状况</td>
					<td width='87' valign='center' colspan='2' >xxx</td>
					</tr>
					<tr >
					<td width='93' valign='center' colspan='2' >手机</td>
					<td width='160' valign='center' colspan='4' >xxx</td>
					<td width='89' valign='center' colspan='2' >Email</td>
					<td width='156' valign='center' colspan='3' >xxx</td>
					</tr>
					<tr >
					<td width='93' valign='center' colspan='2'  style='width:93px;'>家庭住址</td>
					<td width='530' valign='center' colspan='11' >xxx</td>
					</tr>
					<tr >
					<td width='93' valign='center' colspan='2' rowspan='3'>求职意向</td>
					<td width='93' valign='center' colspan='2'>希望从事职业</td>
					<td width='200' valign='center' colspan='2'>xxx</td>
					<td width='93' valign='center' colspan='2'>希望薪资</td>
					<td width='200' valign='center' colspan='5'>xxx元/月</td>
					</tr>
					<tr>
					<td width='93' valign='center' colspan='2' >希望工作地区</td>
					<td width='200' valign='center' colspan='2' >xxx</td>
					<td width='93' valign='center' colspan='2' >食宿要求</td>
					<td width='200' valign='center' colspan='5' >xxx</td>
					</tr>
					<tr>
					<td width='93' valign='center' colspan='2' >目前状况</td>
					<td width='200' valign='center' colspan='9' >xxx</td>
					</tr>
					<tr>
					<td width='93' valign='center' >自我评价</td>
					<td width='570' valign='center' colspan='12' >xxx</td>
					</tr>
					<tr>
					<td width='93' valign='center' >工作经历</td>
					<td width='570' valign='center' colspan='12' >xxx</td>
					</tr>
					<tr>
					<td width='93' valign='center' >教育经历</td>
					<td width='570' valign='center' colspan='12'>xxx</td>
					</tr>
					<tr>
					<td width='93' valign='center' >培训经历</td>
					<td width='570' valign='center' colspan='12' >xxx</td>
					</tr>
					</table>
					</body>";
					//exit;
					
        	   }
			   
        	}
			header("Content-type: application/octet-stream"); 
header("Accept-Ranges: bytes"); 
header("Accept-Length: ".strlen($html2));
header('Content-Disposition: attachment; filename=test.doc'); 
header("Pragma:no-cache"); 
header("Expires:0"); 
echo $html;

        }
}
