   var page = 1;
$(function () {
    showloading();
 
    var lock = true;
    //
	
    $(window).scroll(function () {
        if ($(document).height() - $(this).scrollTop() - $(this).height() < 10) {
            if (lock) {
                lock = false;
                page++;				
                if (getData(page)) {
                    lock = true;
                }
            }
        }
    });
});
function showloading() {

    if(document.querySelector(".isnowdataappending")) return;
    var isnowdataappending = document.createElement("div");
    isnowdataappending.className = "isnowdataappending";
    isnowdataappending.style.cssText = "background:#f1f1f1;width:100%;height:35px;line-height:35px;text-align:center;font-size:12px;color:#666;";
    isnowdataappending.innerHTML = "正在加载...";
    if(document.querySelector("#lists")) {
        document.querySelector("#lists").parentNode.appendChild(isnowdataappending)
    }
}
function getData(page) {
    
    var status = true;
    $.ajax({
        type: "get",
        url: $("#lists").attr("data-url"),
        data: { pageIndex: page },
        async: false,
        success: function (result) {
			//alert(result);
            if ($.trim(result) != "") {
                //$(".isnowdataappending").remove();
              //  $(result).appendTo('#lists');
            }
            else {
                $(".isnowdataappending").html("加载完毕,暂无商品~");
                status = false;
            }
        }
    });
    return status;

    
}