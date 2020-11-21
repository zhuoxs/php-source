var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        console.log(t);
        this.setData({
            currSelDate: t.currSelDate,
            currSelTime: t.currSelTime,
            currNum: t.currNum,
            currSelWeizhi: t.currSelWeizhi,
            postLaterData: t.postLaterData,
            storeID: t.storeID
        }), this.diyWinColor();
    },
    inputTap: function(t) {
        console.log(t), this.setData({
            telLength: t.detail.cursor
        });
    },
    bindSubmit: function(t) {
        var e = this;
        console.log(t);
        var o = t.detail.value.name, n = t.detail.value.tel, a = t.detail.value.notes, r = wx.getStorageSync("openid");
        "" != o ? "" != n && 11 == this.data.telLength ? app.util.request({
            url: "entry/wxapp/Reservations",
            cachetime: "0",
            data: {
                person_num: e.data.currNum,
                meals_date: e.data.postLaterData,
                meals_pos: e.data.currSelWeizhi,
                bid: e.data.storeID,
                name: o,
                tel: n,
                mark: a,
                openid: r
            },
            success: function(t) {
                if (console.log(t), 0 == t.data.status) {
                    var a = [];
                    a.push(e.data.currNum), a.push(e.data.postLaterData), a.push(e.data.currSelWeizhi), 
                    a.push(e.data.storeID), a.push(o), a.push(n), a.push(r), console.log(a), wx.setStorageSync("reservateRecord", a), 
                    wx.navigateTo({
                        url: "../dingzuoDet/dingzuoDet?bid=" + e.data.storeID + "&&person_num=" + e.data.currNum + "&&meals_date=" + e.data.postLaterData + "&&meals_pos=" + e.data.currSelWeizhi + "&&name=" + o + "&&tel=" + n
                    });
                } else wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请输入正确手机号码",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入姓名",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        var a = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: a.color,
            backgroundColor: a.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "订座信息"
        });
    }
});