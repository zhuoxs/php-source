$(document).ready(function(){
	//列表下拉 v3-b12
	$('img[nc_type="flex"]').click(function(){
		var status = $(this).attr('status');
		if(status == 'open'){
			var pr = $(this).parent('td').parent('tr');
			var id = $(this).attr('fieldid');
			var obj = $(this);
			$(this).attr('status','none');
			//ajax
			$.ajax({
				url: 'index.php?act=area&op=area&ajax=1&area_parent_id='+id,
				dataType: 'json',
				success: function(data){
					var src='';
					for(var i = 0; i < data.length; i++){
						var tmp_vertline = "<img class='preimg' src='"+ADMIN_TEMPLATES_URL+"/images/vertline.gif'/>";
						src += "<tr class='"+pr.attr('class')+" row"+id+"'>";
						src += "<td class='w36'><input type='checkbox' name='check_area_id[]' value='"+data[i].area_id+"' class='checkitem'>";
						//图片
						if(data[i].have_child == 1){
							src += " <img fieldid='"+data[i].area_id+"' status='open' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-expandable.gif' />";
						}else{
							src += " <img fieldid='"+data[i].area_id+"' status='none' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-item.gif' />";
						}
						src += "</td><td class='w48 sort'>";
						//排序
						src += " <span title='可编辑下级分类排序' ajax_branch='area_sort' datatype='number' fieldid='"+data[i].area_id+"' fieldname='area_sort' nc_type='inline_edit' class='editable tooltip'>"+data[i].area_sort+"</span></td>";
						//名称
						src += "<td class='w50pre name'>";
						
						for(var tmp_i=1; tmp_i < (data[i].area_deep-1); tmp_i++){
							src += tmp_vertline;
						}
						if(data[i].have_child == 1){
							src += " <img fieldid='"+data[i].area_id+"' status='open' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-item1.gif' />";
						}else{
							src += " <img fieldid='"+data[i].area_id+"' status='none' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-expandable1.gif' />";
						}
						src += " <span title='可编辑下级分类名称' required='1' fieldid='"+data[i].area_id+"' ajax_branch='area_name' fieldname='area_name' nc_type='inline_edit' class='editable tooltip'>"+data[i].area_name+"</span>";
						
						src += "</td>";

						//大区名称
						src += "<td class='w25pre name'>";
						
						for(var tmp_i=1; tmp_i < (data[i].deep-1); tmp_i++){
							src += tmp_vertline;
						}
						src += " <span title='可编辑下级分类名称' required='1' fieldid='"+data[i].area_id+"' ajax_branch='area_region' fieldname='area_region' nc_type='inline_edit' class='editable tooltip'>"+data[i].area_region+"</span>";
						src += "</td>";
						//操作
						src += "<td class='w96'>";
						src += "<a href='index.php?act=area&op=area_add&area_parent_id="+data[i].area_id+"'>新增下级</a>";
						src += " | <a href='index.php?act=area&op=area_edit&area_id="+data[i].area_id+"'>编辑</a>";
						src += " | <a href=\"javascript:if(confirm('删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗'))window.location = 'index.php?act=area&op=area_del&area_id="+data[i].area_id+"';\">删除</a>";
						src += "</td>";
						src += "</tr>";
					}
					//插入
					pr.after(src);
					obj.attr('status','close');
					obj.attr('src',obj.attr('src').replace("tv-expandable","tv-collapsable"));
					$('img[nc_type="flex"]').unbind('click');
					$('span[nc_type="inline_edit"]').unbind('click');
					//重现初始化页面
                    $.getScript(RESOURCE_SITE_URL+"/js/jquery.edit.js");
					$.getScript(RESOURCE_SITE_URL+"/js/jquery.area.js");
					$.getScript(RESOURCE_SITE_URL+"/js/admincp.js");
				},
				error: function(){
					alert('获取信息失败');
				}
			});
		}
		if(status == 'close'){
			$(".row"+$(this).attr('fieldid')).remove();
			$(this).attr('src',$(this).attr('src').replace("tv-collapsable","tv-expandable"));
			$(this).attr('status','open');
		}
	})
});