var app = getApp();

Page({
    data: {
        navTile: "打卡日记",
        babyname: "",
        target: "",
        dynamic: [],
        curPage: 1,
        pagesize: 5
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.get_user_info().then(function(t) {
            a.setData({
                user: t
            });
        }), a.setData({
            task_id: t.id
        });
    },
    get_record: function() {
        var o = this, n = o.data.curPage, r = o.data.dynamic;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getMyPunchRecord",
                cachetime: "0",
                data: {
                    openid: t,
                    task_id: o.data.task_id,
                    page: n,
                    pagesize: o.data.pagesize
                },
                success: function(t) {
                    var a = t.data.record.length == o.data.pagesize;
                    if (1 == n) r = t.data.record; else for (var e in t.data.record) r.push(t.data.record[e]);
                    n += 1, console.log(r), o.setData({
                        task: t.data,
                        dynamic: r,
                        curPage: n,
                        hasMore: a
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            }), a.get_record();
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.get_record() : wx.showToast({
            title: "没有更多日记啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    toPunchdet: function(t) {
        if (this.data.task.wc_num != this.data.task.task_num) {
            var a = t.currentTarget.dataset.id;
            wx.navigateTo({
                url: "../subdiary/subdiary?id=" + a
            });
        } else wx.showToast({
            title: "该打卡任务已完成",
            icon: "none",
            duration: 3e3
        });
    },
    previewImg: function(t) {
        for (var a = this.data.dynamic, e = this.data.imgroot, o = t.currentTarget.dataset.index, n = t.currentTarget.dataset.idx, r = e + "" + a[o].punch_pic_arr[n], i = [], c = 0; c < a[o].punch_pic_arr.length; c++) i[c] = e + "" + a[o].punch_pic_arr[c];
        wx.previewImage({
            current: r,
            urls: i
        });
    }
});