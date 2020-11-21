var app = getApp();

Page({
    data: {
        yuabn: [ {
            img: "../../resource/images/1803240850211_02.png",
            k: [ {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            }, {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            }, {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            } ]
        }, {
            img: "../../resource/images/1803240850211_02.png",
            k: [ {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            }, {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            }, {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            } ]
        }, {
            img: "../../resource/images/1803240850211_02.png",
            k: [ {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            }, {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            }, {
                img: "../../resource/images/1803240850211_02.png",
                text: "商品名称",
                jia: "￥99"
            } ]
        } ]
    },
    onLoad: function(e) {
        this.Newshenhe();
    },
    Newshenhe: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Newshenhe",
            method: "POST",
            success: function(e) {
                var t = e.data.data;
                a.setData({
                    list: t
                });
            }
        });
    },
    detail: function(e) {
        var t = e.currentTarget.dataset.goodspic, a = e.currentTarget.dataset.goodsname, i = e.currentTarget.dataset.goodsprice;
        wx.navigateTo({
            url: "../trialdetail/trialdetail?goodsprice=" + i + "&goodspic=" + t + "&goodsname=" + a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});