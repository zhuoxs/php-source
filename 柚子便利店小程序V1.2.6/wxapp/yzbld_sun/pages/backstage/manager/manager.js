var app = getApp();

Page({
    data: {
        hxstaff: [ {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            name: "这是名字",
            user_id: 1234
        }, {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            name: "这是名字",
            user_id: 1234
        }, {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            name: "这是名字",
            user_id: 1234
        } ],
        id: "",
        searchFlag: !1
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    enterInput: function(t) {
        this.setData({
            id: t.detail.value
        });
    },
    submit: function(t) {
        var n = this.data.id;
        console.log(n), "" == n ? wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "id不得为空"
        }) : this.setData({
            searchFlag: !0
        });
    },
    toDelete: function(t) {
        t.currentTarget.dataset.name, t.currentTarget.dataset.id;
    },
    toAdd: function(t) {
        console.log(t);
    }
});