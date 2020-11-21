$(function () {
    //收藏
    $(document).delegate(".goodscollection", "click", function () {
        var $this = $(this);
        var id = $this.data("id");
        $.ajax({
            type: "post",
            url: "../app/index.php?i="+weid+"&c=entry&do=shoucang&m=tiger_taoke",
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
            url: "../app/index.php?i="+weid+"&c=entry&do=shoucang&m=tiger_taoke",
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
		var rxyjxs = $this.attr("data-rxyjxs");
		var openid=$this.attr("data-openid");
		var dluid=$this.attr("data-dluid");
		var url=$this.attr("data-url");
		var num_iid=$this.attr("data-numiid");
		var org_price=$this.attr("data-orgprice");
		var price=$this.attr("data-price");
		var coupons_price=$this.attr("coupons_price");
		var title=$this.attr("data-title");
		var pic_url=$this.attr("data-picurl");
		var tk_rate=$this.attr("data-tkrate");
		var pid=$this.attr("data-pid");
		//alert(pid);
		//alert(title);
		
        $.ajax({
            type: "post",
            url: "../app/index.php?i="+weid+"&c=entry&do=GetCoupon&m=tiger_taoke",
            dataType: "json",
            data: { id: id,openid:openid,dluid:dluid,pid:pid,url:url,num_iid:num_iid,org_price:org_price,price:price,coupons_price:coupons_price,title:title,pic_url:pic_url,tk_rate:tk_rate},
            success: function (data) {
                if (data.code == 1000) {
                    popTao($this.attr("data-img"), "淘口令", "领券之前您需要先完善个人信息！");
                    $(".taokaobox").html("<div class='popwcc'><a href='javascript:;' onclick='location.href=\"/Customer/ImproveInformation\"' class='popwcomfirm'>去完善</a></div>");
                }
                else {
                    popTao($this.attr("data-img"), "淘口令", data.url,'',data.iosmsg);
                    var tt = $(".taotip");
					if(rxyjxs==1){
					  tt.html("<span class='yjfx'>预计返</span><span class='yjfxq'>" + data.commission + "</span>").show();
					  tt.css({
                        display:"-webkit-box",
                        width: "180px",
                        marginLeft: "auto",
                        marginRight:"auto",
                        border:"1px solid #f54d23",
                        borderRadius:"5px"
                      })
					}else{
					  tt.html("").hide();
					   tt.css({
							display:"-webkit-box",
							width: "0",
							marginLeft: "auto",
							marginRight:"auto",
							border:"0",
							borderRadius:"5px"
						})
					}                    
                    
                }
                selection()
            }
        });
    })

});
