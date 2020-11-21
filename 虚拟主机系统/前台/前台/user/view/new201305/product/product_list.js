function go_product_form(product)
{
	if(product.substr(0,1)=='_'){
		return;
	}
	
	if(product.substr(0,1)=='*'){
		var len = product.indexOf('_');
		var id = product.substr(len+1);
		{{$target}}.window.location='?c=mproductorder&a=addMproductorderFrom&mproduct_id='+id;
	}else{
		{{$target}}.window.location='?c=product&a=sellForm&product='+product;
	}
}
document.write('<select name="product" class="product_list" onChange=go_product_form(this.value)>');
//document.write('<select name="product" >');
document.write('<option value="_">--产品服务快速导航--</option>');
{{foreach from=$products item=product}}
//document.write('<option value="{{$product.type}}_{{$product.id}}" onclick="go_product_form(this.value,{{$product.id}});">{{if $product.type!=''}}&nbsp;&nbsp;{{/if}}{{$product.name}}</option>');
document.write('<option value="{{$product.type}}_{{$product.id}}">{{if $product.type!=''}}&nbsp;&nbsp;{{/if}}{{$product.name}}</option>');
{{/foreach}}
document.write('</select>');