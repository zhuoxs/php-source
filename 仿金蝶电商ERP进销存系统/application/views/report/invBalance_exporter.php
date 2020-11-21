<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr><td class='H' align="center" colspan="<?php echo 6 + count($storage)*2?>"><h3>商品库存余额表<h3></td></tr>
  			<tr><td colspan="<?php echo 6 + count($storage)*2?>">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td></tr>
</table>
  		<table width="1440px" class="list" border="1">
  				<tr>
  				<th width="216" rowspan="2">商品编号</th>
  				<th width="216" rowspan="2">商品名称</th>
  				<th width="216" rowspan="2">规格型号</th>
  				<th width="114" rowspan="2">单位</th>
  				<th colspan="2">所有仓库</th>
				<?php 
				$i = 2;
				$qty_1  = $cost_1 = $cost1 = 0;
				foreach($storage as $arr=>$row) {
				    $qty['qty'.$i]  = $qty['cost'.$i] = 0;
				?>
  				<th width="50" colspan="2"><?php echo $row['name']?></th>
				<?php $i++;}?>
  				</tr>
  				<tr class="link" data-id="0" data-type="BAL">
  				   <td align="center">数量</td>
				   <td align="center">成本</td>
				   <?php foreach($storage as $arr=>$row){?>
				   <td align="center">数量</td>
				   <td align="center">成本</td>
				   <?php }?>
  				</tr>
				
				<?php foreach($list as $arr=>$row) {
				          $i = 2;
						  foreach($storage as $arr1=>$row1) {
							  $price = isset($profit['inprice'][$row['invId']][$row1['id']]) ? $profit['inprice'][$row['invId']][$row1['id']] : 0;   //单位成本  
							  $cost1 += $row['qty'.$i] * $price;
							  $i++;
						  }
						  $qty_1   += $row['qty'];  
						  $cost_1  += $cost1; 
				?>
				<tr class="link" data-id="0" data-type="BAL">
  				   <td><?php echo $row['invNumber']?></td>
  				   <td><?php echo $row['invName']?></td>
  				   <td><?php echo $row['invSpec']?></td>
  				   <td><?php echo $row['mainUnit']?></td>
				   <td align="center"><?php echo str_money($row['qty'],$this->systems['qtyPlaces'])?> </td>
				   <td align="center"><?php echo str_money($cost1,2)?> </td>
				   <?php 
				   $i = 2;
				   foreach($storage as $arr1=>$row1){
				       $price = isset($profit['inprice'][$row['invId']][$row1['id']]) ? $profit['inprice'][$row['invId']][$row1['id']] : 0;   //单位成本
				       $qty['qty'.$i]  += $row['qty'.$i];
					   $qty['cost'.$i] += $row['qty'.$i] * $price;
				   ?>
				   <td align="center"><?php echo str_money($row['qty'.$i],$this->systems['qtyPlaces'])?></td>
				   <td align="center"><?php echo str_money($row['qty'.$i]*$price,2)?></td>
				  <?php $i++;}?>
  				</tr>
  			   <?php }?>
			   
			   <tr class="link" data-id="0" data-type="BAL">
  				   <td colspan="4" align="right">合计：</td>
  				   <td align="center"><?php echo str_money($qty_1,$this->systems['qtyPlaces'])?> </td>
				   <td align="center"><?php echo str_money($cost_1,2)?> </td>
				   <?php 
				   $i = 2;
				   foreach($storage as $arr1=>$row1){?>
				   <td align="center"><?php echo str_money($qty['qty'.$i],$this->systems['qtyPlaces'])?></td>
				   <td align="center"><?php echo str_money($qty['cost'.$i],2)?></td>
				  <?php $i++;}?>
  				</tr>
  		</table>
