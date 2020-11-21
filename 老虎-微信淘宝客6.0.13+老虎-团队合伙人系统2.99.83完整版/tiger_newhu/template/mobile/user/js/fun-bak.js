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
    //弹出领券
    $(document).delegate(".new-coupon,.goodsget", "click", function () {
        var $this = $(this);
        var id = $this.data("id");
        $.ajax({
            type: "post",
            url: "/Commodity/GetCoupon",
            dataType: "json",
            data: { commodityID: id },
            success: function (data) {
                if (data.msg == "申请失败") {
                    popTao($this.attr("data-img"), "淘口令", "您暂无权限领取该优惠券，请先升级会员");
                    $(".taokaobox").html("<div class='popwcc'><a href='javascript:;' onclick='location.href=\"/Customer/Upgrade\"' class='popwcomfirm'>去升级</a></div>");
                    //location.href = "/Customer/Upgrade";
                }
                else {
                    popTao($this.attr("data-img"), "淘口令", data.url);
                }
                selection()
            }
        });
    })

});
