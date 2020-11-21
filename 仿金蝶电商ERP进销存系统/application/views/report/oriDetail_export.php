<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr><td class='H' align="center" colspan="8"><h3>其他收入支出明细表<h3></td></tr>
  			<tr><td colspan="8">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td></tr>
  		</table>
  		<table width="1440px" class="list" border="1">
  			<thead>
  				<tr>
  				<th>日期</th>
  				<th>单据编号</th>
  				<th>收支类别</th>
  				<th>收支项目</th>
  				<th>收入</th>
  				<th>支出</th>
  				<th>往来单位</th>
  				<th>摘要</th>
  				</tr>
  			</thead>
  			<tbody>
  			    <?php 
				$payment1 = $payment2 = $amountIn = $amountOut = 0;
				foreach($list as $arr=>$row){  
				    if ($row['transType']==153401) {
						$payment1 += $amountIn   = $row['payment'];        //收入
					} else {
						$payment2 += $amountOut  = abs($row['payment']);   //支出
					}
				?>
  				<tr>
  				   <td><?php echo $row['billDate']?></td>
  				   <td><?php echo $row['billNo']?></td>
  				   <td><?php echo $row['transTypeName']?></td>
  			       <td class="R"><?php echo $row['categoryName']?></td>
  			       <td class="R"><?php echo $amountIn?></td>
  			       <td class="R"><?php echo $amountOut?></td>
  			       <td class="R"><?php echo $row['contactName']?></td>
  			       <td class="R"><?php echo $row['remark']?></td>
  				</tr>
				<?php  }?>
  				<tr>
  				<td colspan="4" class="R B">合计：</td>
  				<td class="R B"><?php echo str_money($payment1,2)?></td>
  				<td class="R B"><?php echo str_money($payment2,2)?></td>
  				<td class="R B"></td>
  				<td class="R B"></td>
  				</tr> 
  			</tbody>
  		</table>