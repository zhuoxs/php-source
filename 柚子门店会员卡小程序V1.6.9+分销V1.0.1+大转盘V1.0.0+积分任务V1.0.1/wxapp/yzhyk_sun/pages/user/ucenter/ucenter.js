var app = getApp();

Page({
    data: {
        navTile: "会员信息",
        phoneNumber: 18e8,
        gender: 1,
        end: "2018-1-01"
    },
    onLoad: function(e) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), console.log(new Date().toLocaleDateString().replace(/\//g, "-")), app.get_user_info().then(function(e) {
            a.setData({
                phoneNumber: e.tel,
                name: e.name,
                date: e.birthday,
                editable: !e.birthday,
                gender: e.gender,
                email: e.email,
                end: new Date().toLocaleDateString(),
                id: e.id
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindDateChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            date: e.detail.value
        });
    },
    radioChange: function(e) {
        var a = e.detail.value;
        this.setData({
            gender: a
        });
    },
    formSubmit: function(e) {
        var a = "", t = !0, n = this, i = e.detail.value.name, o = n.data.date, l = n.data.gender, d = e.detail.value.email;
        "" == i ? a = "昵称不得为空" : i.length < 2 || 6 < i.length ? a = "昵称不得小于2位或者大于6位" : null == o ? a = "请选择生日日期" : null == l ? a = "请选择性别" : "" == d || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(d) ? t = !1 : a = "请输入正确邮箱格式", 
        t ? wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        }) : app.util.request({
            url: "entry/wxapp/UpdateUser",
            cachetime: "0",
            data: {
                id: n.data.id,
                name: i,
                gender: l,
                date: o,
                email: d
            },
            success: function(e) {
                app.get_user_info(!1), app.get_user_coupons(!1), wx.navigateBack({});
            }
        });
    }
});