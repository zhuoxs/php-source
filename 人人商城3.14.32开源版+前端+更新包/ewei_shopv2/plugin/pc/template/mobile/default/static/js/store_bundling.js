$(document).ready(function(){
	/* ajax添加商品  */
	$('#bundling_add_goods').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:SHOP_TEMPLATES_URL+"/images/loading.gif",
		target:'#bundling_add_goods_ajaxContent'
	}).click(function(){
	    $(this).hide();
	    $('#bundling_add_goods_delete').show();
	});
	
	$('#bundling_add_goods_delete').click(function(){
	    $(this).hide();
	    $('#bundling_add_goods_ajaxContent').html('');
	    $('#bundling_add_goods').show();
	});
	// 退拽效果
    $('tbody[nctype="bundling_data"]').sortable({ items: 'tr' });
    $('#goods_images').sortable({ items: 'li' });
});


/* 计算商品原价 */
function count_cost_price_sum(){
	data_price = $('td[nctype="bundling_data_price"]');
	if(typeof(data_price) != 'undefined'){
		var S_price = 0;
		data_price.each(function(){
			S_price += parseFloat($(this).html());
		});
		$('span[nctype="cost_price"]').html(S_price.toFixed(2));
	}else{
		$('span[nctype="cost_price"]').html('');
	}
}

/* 计算商品售价 */
function count_price_sum(){
    data_price = $('input[nctype="price"]');
    if(typeof(data_price) != 'undefined'){
        var S_price = 0;
        data_price.each(function(){
            S_price += parseFloat($(this).val());
        });
        $('#discount_price').val(S_price.toFixed(2));
    }else{
        $('#discount_price').val('');
    }
}