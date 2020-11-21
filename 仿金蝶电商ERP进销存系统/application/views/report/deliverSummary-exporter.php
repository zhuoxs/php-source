<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<table width="1440px" class="list">
  			<tr><td class='H' colspan="20" align="center"><h3>商品收发汇总表<h3></td></tr>
  			<tr><td colspan="20">日期：<?php echo $beginDate;?>至<?php echo $endDate;?></td></tr>
</table>
  		<table width="1440px" class="list" border="1">

  				<tr>
  				<th width="216" rowspan="2">商品编号</th>
  				<th width="216" rowspan="2">商品名称</th>
  				<th width="216" rowspan="2">规格型号</th>
  				<th width="114" rowspan="2">单位</th>
  				<th width="24" rowspan="2">仓库</th>
				<th>期初</th>
				<th>调拨入库</th>
				<th>普通采购</th>
				<th>销售退回</th>
				<th>盘盈</th>
				<th>其他入库</th>
				<th>成本调整</th>
				<th>入库合计</th>
				<th>调拨出库</th>
				<th>采购退回</th>
				<th>普通销售</th>
				<th>盘亏</th>
				<th>其他出库</th>
				<th>出库合计</th>
				<th>结存</th> 
  				</tr>
				
				<tr>
				<?php for ($i=0;$i<15;$i++) {?>
  				<td align="center">数量</td>
				<?php }?>
  				</tr>
				
				<?php 
				for ($i=0;$i<15;$i++) {
				    $sum['qty_'.$i]  = 0;  
 
					$sum['qty'.$i]   = 0;  
  
				}
				$qty7   = $qty_7   = $qty13  = $qty_13 = 0; 
		       
				foreach($list as $arr=>$row){
				    //期初数量
					$qty_0      = $row['qty0']; 
				 
					
					//结存数量
					$qty_14    = $row['qty14'];             //结存数量
					 
		      
					
					$sum['qty14']   +=  str_money($qty_14,$this->systems['qtyPlaces']); 
				 
					
					for ($i=1;$i<7;$i++) {
						if ($i==1) {                          //调拨  成本另计算
							$qty_7  += abs($row['qty1']);   
						 
						} else {
							$qty_7  += abs($row['qty'.$i]);   
							 
						}
					}
					for ($i=8;$i<13;$i++) {
						if ($i==10 || $i==11 || $i==12 || $i==8) {       //销售、盘亏、其他出库  成本另计算
							$qty_13  += abs($row['qty'.$i]);   
							 
						} else {
							$qty_13  += abs($row['qty'.$i]);   
							 
						}
					}
					
                    for ($i=0; $i<15; $i++) {
						if ($i==0) {
							$sum['qty0']   += $sum['qty_'.$i]   = $qty_0;    //期初数量
							  
						} elseif($i==7) {
							$sum['qty7']   += $sum['qty_'.$i]   = $qty_7;    //入库合计 
							 
						} elseif($i==13) {
							$sum['qty13']  += $sum['qty_'.$i]   = $qty_13;   //出库合计 
							 
						} elseif($i==14) {                                   
							$sum['qty_'.$i]    = $qty_14;                    //结存合计 
							 
						} else {
							if ($i==10 || $i==11 || $i==12 || $i==1 || $i==8) {  //销售、盘亏、其他出库、入库调拨、出库调拨  成本另计算
								$sum['qty'.$i]  += $sum['qty_'.$i]   = abs($row['qty'.$i]);  
								 
							} else { 
								$sum['qty'.$i]  += $sum['qty_'.$i]   = abs($row['qty'.$i]);   
								 
							}
						}
					}
					$qty_7 = $qty_13 = 0;         //停止累加 初始化值
				?>
				<tr>
  				   <td><?php echo $row['invNumber']?></td>
  				   <td><?php echo $row['invName']?></td>
  				   <td><?php echo $row['invSpec']?></td>
  				   <td><?php echo $row['mainUnit']?></td>
				   <td><?php echo $row['locationName']?></td>
				   <?php for ($i=0;$i<15;$i++) {?>
				   <td><?php echo str_money($sum['qty_'.$i],$this->systems['qtyPlaces'])?> </td>
				   <?php }?>
  				</tr>
  			   <?php }?>
				<tr>
  				   <td colspan="5">合计:</td>
				   <?php for ($i=0;$i<15;$i++) {?>
				   <td><?php echo str_money($sum['qty'.$i],$this->systems['qtyPlaces'])?></td>
				   <?php }?>
  				</tr>
  		</table>
