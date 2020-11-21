var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var n = arguments[t];
        for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (a[i] = n[i]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(a) {
        this.onloadData();
    },
    onloadData: function() {
        var t = this, n = wx.getStorageSync("userInfo");
        this.setData({
            avatar: n.wxInfo.headimg,
            name: n.wxInfo.user_name,
            uid: n.wxInfo.id
        }), this.getUrl().then(function(a) {
            return (0, _api.NavsetData)();
        }).then(function(a) {
            return t.setData(_extends({}, a.mine)), (0, _api.UserAuthData)({
                uid: n.wxInfo.id
            });
        }).then(function(a) {
            t.setData({
                auth: a
            });
        }).catch(function(a) {
            -1 === a.code ? t.tips(a.msg) : t.tips("false");
        });
    },
    onMyClassTab: function() {
        this.navTo("../myclass/myclass");
    },
    onMyRecordTab: function() {
        this.navTo("../myrecord/myrecord");
    },
    onMyTeacherTab: function() {
        this.navTo("../myteacher/myteacher");
    },
    onMyCollectTab: function() {
        this.navTo("../mycollect/mycollect");
    },
    onMyCardTab: function() {
        this.navTo("../mycard/mycard");
    },
    onMyTicketTab: function() {
        this.navTo("../myticket/myticket");
    },
    onMyBargainsTab: function() {
        this.navTo("../mybargain/mybargain");
    },
    onManageTab: function() {
        if (1 == this.data.auth.isadmin) var a = 0, t = 0; else if (2 == this.data.auth.isadmin) a = this.data.auth.sid, 
        t = 0; else {
            if (3 != this.data.auth.isadmin) return void wx.showModal({
                title: "提示",
                content: "您不是管理员！",
                showCancel: !1,
                success: function(a) {}
            });
            a = -1, t = this.data.auth.tid;
        }
        this.navTo("../manage/manage?auth=" + this.data.auth.isadmin + "&sid=" + a + "&tid=" + t + "&name=" + this.data.auth.name + "&logo=" + this.data.imgLink + this.data.auth.logo);
    }
}));