$(function () {
    //收藏
    $(document).delegate(".goodscollection", "click", function () {
        var $this = $(this);
        var id = $this.data("id");
        $.ajax({
            type: "post",
            url: "/Collect/Collect",
            dataType: "json",
            data: { commodityID: id },
            success: function (data) {
                if (data.statusCode == "200") {
                    $this.toggleClass("morecollection");
                    $this.html() == "收藏" ? $this.html("取消") : $this.html("收藏");
                }
            }
        });
    });
    //删除收藏
    $(document).delegate(".delcoll", "click", function () {
        var $this = $(this);
        var id = $this.data("id");
        $.ajax({
            type: "post",
            url: "/Collect/Collect",
            dataType: "json",
            data: { commodityID: id },
            success: function (data) {
                if (data.statusCode == "200") {
                    var _h = $this.parents("li").height(true);
                    $this.parents("li").addClass("liboxhidego");
                    setTimeout(function () {
                        $this.parents("li").remove();
                    }.bind(this), 300)
                }
            }
        });
    });
    

});
