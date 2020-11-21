var app = getApp();

Page({
    data: {
        curIndex: 0,
        sale: [ {
            img: "../../images/list/phone.png",
            text: "手机"
        }, {
            img: "../../images/list/pad.png",
            text: "平板"
        }, {
            img: "../../images/list/protect.png",
            text: "手机保护"
        }, {
            img: "../../images/list/laptop.png",
            text: "笔记本"
        }, {
            img: "../../images/list/TV.png",
            text: "液晶电视"
        }, {
            img: "../../images/list/case.png",
            text: "台式主机"
        }, {
            img: "../../images/list/phone.png",
            text: "手机"
        }, {
            img: "../../images/list/pad.png",
            text: "平板"
        }, {
            img: "../../images/list/protect.png",
            text: "手机保护"
        }, {
            img: "../../images/list/laptop.png",
            text: "笔记本"
        }, {
            img: "../../images/list/TV.png",
            text: "液晶电视"
        }, {
            img: "../../images/list/case.png",
            text: "台式主机"
        } ]
    },
    bindFocus: function() {
        wx.navigateTo({
            url: "./search/search"
        });
    },
    bindTap: function(t) {
        var i = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: i
        });
    },
    onLoad: function(t) {
        app.util.footer(this);
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});