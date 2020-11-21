<?php $this->load->view('header');?>
 

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
//ctrl+F5 增加版本号来清空iframe的缓存的
$(document).keydown(function(event) {
	/* Act on the event */
	if(event.keyCode === 116 && event.ctrlKey){
		var defaultPage = Public.getDefaultPage();
		var href = defaultPage.location.href.split('?')[0] + '?';
		var params = Public.urlParam();
		params['version'] = Date.parse((new Date()));
		for(i in params){
			if(i && typeof i != 'function'){
				href += i + '=' + params[i] + '&';
			}
		}
		defaultPage.location.href = href;
		event.preventDefault();
	}
});
</script>

<style>
#matchCon { width: 165px; }
#tab{margin-bottom: 20px;}
.ui-tab{border-left:none;border-bottom: 1px solid #EBEBEB; position: absolute;   background-color: #fff;  top: 0;  left: 0;  width: 100%;}
.ui-tab li {border-top:none;border-bottom:none;border-color:#EBEBEB;}
.container{margin:0 auto; width:760px;padding-top: 50px;}
.mod-search .ui-icon-ellipsis{right: 3px;}
.ul-inline .mod-choose-input{position: relative;}
.grid-wrap{position:relative;}
.ztreeDefault{position: absolute;right: 0;top: 0;background-color: #fff;border: 1px solid #D6D5D5;width: 140px;height: 292px;overflow-y: auto;}
</style>
</head>

<body style="background: #FFF;">
<ul class="ui-tab" id="tab">
	<li class="cur">商品库存预警</li>
	<!--<li>保质期预警</li>-->
</ul>
<div class="container">
	<ul>
		<li class="tabItem">
			<div class="mod-search cf">
			    <div class="l">
				    <ul class="ul-inline">
				    	<li>
				    		<label>仓库:</label>
          					<span class="mod-choose-input" id="filter-storage"></span>
				    	</li>
				    	<li>
				    		<label>预警类型:</label>
          					<span class="mod-choose-input" id="filter-warnType"></span>
				    	</li>
				    	<li>
				         	<input type="text" id="matchCon" class="ui-input ui-input-ph matchCon" value="请输入商品编号/名称/规格/属性">
				        </li>
				        <li><a class="ui-btn mrb" id="search">查询</a><a href="#" class="ui-btn mrb" id="export">导出</a><a href="#" class="ui-btn" id="toPur">生成购货单</a></li>
				    </ul>
			    </div>
			</div>
			<div class="grid-wrap">
				<table id="grid">
				</table>
				<div id="page"></div>
			</div>
		</li>
		<li class="tabItem dn">
			<div class="grid-wrap">
				<table id="grid_batch">
				</table>
				<div id="page_batch"></div>
			</div>
		</li>
	</ul>
  
</div>
<script>
$(function(){
	var queryConditions = {},SYSTEM = system = parent.parent.SYSTEM;
	var THISPAGE = {
		init:function(){
			this.initDom();
			this.initEvent();
		},
		initCombo:function(){
			Business.storageCombo($('#filter-storage'),{
				trigger: true,
				addOptions : {
					text : '(全部)',
					value : 0
				},
				width:80,
				defaultFlag: false,
				callback: {
					onChange: function(data){
						if(data){
							queryConditions.locationId = data.id;
							THISPAGE.reloadGrid();
						}else{
							queryConditions.locationId = 0;
							THISPAGE.reloadGrid();
						}
					}
				}
			});
			$('#filter-warnType').combo({
				data:[
					{id:0,name:'(全部)'},
					{id:1,name:'低库存预警'},
					{id:2,name:'高库存预警'}
				],
				text: 'name',
				value: 'id',
				width:80,
				defaultSelected: 0,
				cache: false,
				trigger: true,
				defaultFlag: false,
				callback: {
					onChange: function(data){
						if(data){
							queryConditions.warnType = data.id;
							THISPAGE.reloadGrid();
						}
					}
				}
			}).getCombo();
		},
		initDom:function(){
			this.initCombo();
			this.initGrid();
			//生成树
			zTree = Public.zTree.init($('.grid-wrap:eq(0)'), {defaultClass:'ztreeDefault',showRoot:true}, {callback:{
				beforeClick: function(treeId, treeNode) {
					//alert(treeNode.id+'_'+treeNode.name);
					queryConditions.assistId = treeNode.id;
					$('#search').trigger('click');
				}
			}});
			//搜索框效果
			$('#matchCon').placeholder();
		},
		initEvent:function(){
			//页签切换
			$('#tab').find('li').each(function(i){
				var $this = $(this);
				var wrapperList = $('.container').find('.tabItem');
				$this.click(function(e){
					$this.addClass('cur').siblings().removeClass('cur');
					$(wrapperList[i]).show().siblings().hide();
				});
			});
			//查询
			$('#search').click(function(){
				queryConditions.skey = $('#matchCon').val() === '请输入商品编号/名称/规格/属性' ? '' : $('#matchCon').val();
				THISPAGE.reloadGrid();
			});
			//导出
			$('#export').on('click',function(e){
				if (!Business.verifyRight('InvBalanceReport_EXPORT')) {
					e.preventDefault();
					return ;
				};
				var arr_ids = $('#grid').jqGrid('getGridParam','selarrrow')
				var ids = arr_ids.join();
				var params = ids ? '&id='+ ids : '';
				for(var item in queryConditions){
					if(queryConditions[item]){
						params += '&' + item +'='+ queryConditions[item];
					}
				}
				var url = '../basedata/inventory/warningExporter?action=warningExporter&isDelete=2'+params;
				$(this).attr('href', url);
			});
			//生成采购单
			$('#toPur').on('click',function(e){
				if (!Business.verifyRight('PU_ADD')) {
					e.preventDefault();
					return ;
				};
				var arr_ids = $('#grid').jqGrid('getGridParam','selarrrow')
				var rowList = [];
				for (var i = 0; i < arr_ids.length; i++) {
					var rowid = arr_ids[i];
					if(!rowid) continue;
					row = $('#grid').jqGrid('getRowData',rowid);
					if(row.warning > 0){
						parent.parent.Public.tips({type:2, content:'商品【'+row.name+'】未低于最低库存！'});
						return;
					}
					if(row){
						var jsonData = {
							id: row.id,
							qty: -row.warning,
							skuId: row.skuId,
							skuName : row.skuName,
							locationName: row.locationName,
							locationId: row.locationId
						}
					}
					rowList.push(jsonData);
				};
				if(rowList.length){
					var title = '购货单';
					var tabid = 'purchase-purchase';
					var transType = '150501';
					parent.parent.tab.addTabItem({tabid: tabid, text: title, url: '../scm/invPu?action=initPur&id=-1&goodsIds=' + JSON.stringify(rowList) + '&flag=list&turnBygoodList&transType='+ transType});
					parent.parent.tab.reload(tabid);
				}else{
					parent.parent.Public.tips({type:2, content:'请先选择商品！'});
				}
			});
		},
		reloadGrid:function(){
			$("#grid").jqGrid('setGridParam',{postData:queryConditions, page:1}).trigger('reloadGrid');
		},
		initGrid:function(){
			$("#grid").jqGrid({
				url:'../basedata/inventory/listInventoryQtyWarning?action=listInventoryQtyWarning',
				datatype: "json",
				width: 600,
				height: 240,
				gridview: true,
				colModel:[
					{name: 'id', label: '商品ID',hidden: true},
					{name: 'number', label: '商品编码', width: 60, title: false},
			    	{name: 'name', label: '商品名称', width: 160, classes: 'ui-ellipsis'},
			    	{name: 'categoryName', label: '商品类别', width: 60, classes: 'ui-ellipsis'},
			    	{name: 'spec', label: '规格型号', width: 60, classes: 'ui-ellipsis'},
			    	{name: 'skuId', label: '属性Id', width: 60, classes: 'ui-ellipsis',hidden:true},
			    	{name: 'skuName', label: '属性', width: 60, classes: 'ui-ellipsis',hidden:!SYSTEM.enableAssistingProp},
			    	{name: 'unitName', label: '单位', width: 40, align: 'center', title: false},
			    	{name: 'locationId', label: '仓库ID',hidden: true},
			    	{name: 'locationName', label: '仓库', width: 60, classes: 'ui-ellipsis'},
			    	{name: 'lowQty', label: '最低库存', width: 60, align: 'center', title: false},
			    	{name: 'highQty', label: '最高库存', width: 60, align: 'center', title: false},
			    	{name: 'qty', label: '结存数量', width: 60, align: 'center', title: false},
			    	{name: 'warning', label: '超限数量', width: 60, align: 'center', title: false}
				],
				cmTemplate: {sortable: false},
				page: 1, 
				sortname: 'number',    
				sortorder: "desc", 
				pager: "#page",  
				rowNum: 20,
				rowList:[20,50,100],   
				multiselect: true,
				//scroll: 1,
				//loadonce: true,
				viewrecords: true,
				shrinkToFit: false,
				forceFit: true,
				jsonReader: {
				  root: "data.rows", 
				  records: "data.records", 
			  	  total: "data.total", 
				  repeatitems : false,
				  id: ''
				}
			});
			$("#grid_batch").jqGrid({
				url:'../basedata/warranty/getAdvancedList?action=getAdvancedList',
				datatype: "json",
				width: 758,
				height: 280,
				gridview: true,
				colModel:[
				{
					name: 'number',
					label: '商品编码',
					width: 60,
					title: false
				}, {
					name: 'name',
					label: '商品名称',
					width: 160,
					classes: 'ui-ellipsis'
				}, {
					name: 'spec',
					label: '规格型号',
					width: 60,
					classes: 'ui-ellipsis'
				}, {
					name: 'unitName',
					label: '单位',
					width: 40,
					align: 'center',
					title: false
				}, {
					name: 'locationName',
					label: '仓库',
					width: 80,
					align: 'center',
					title: false,
					classes: 'ui-ellipsis'
				}, {
					name: 'qty',
					label: '数量',
					width: 40,
					align: 'center',
					title: false
				}, {
					name: "batch",
					label: "批次",
					width: 100,
					classes: "ui-ellipsis",
					title: true
				}, {
					name: "prodDate",
					label: "生产日期",
					width: 80,
					fixed: true,
					align: "center"
				}, {
					name: "safeDays",
					label: "保质期天数",
					width: 70,
					fixed: true,
					align: "center"
				}, {
					name: "validDate",
					label: "有效期至",
					width: 80
				}, {
					name: "surplusDays",
					label: "剩余天数",
					width: 60
				}],
				cmTemplate: {sortable: false},
				page: 1, 
				sortname: 'number',    
				sortorder: "desc", 
				pager: "#page_batch",  
				rowNum: 2000,
				rowList:[300,500,1000],     
				scroll: 1,
				loadonce: true,
				viewrecords: true,
				shrinkToFit: false,
				forceFit: true,
				jsonReader: {
				  root: "data.rows", 
				  records: "data.records", 
			  	  total: "data.total", 
				  repeatitems : false,
				  id: 0
				}
			});
		}
	}
	THISPAGE.init();
})

</script>
</body>
</html>
 