var app = getApp();

Page({
    data: {
        staffs: "",
        list_style: 1
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: "员工名片列表"
        }), app.util.request({
            url: "entry/wxapp/getStaffs",
            success: function(t) {
                a.setData({
                    staffs: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getStaffset",
            success: function(t) {
                a.setData({
                    list_style: t.data.data.list_style
                });
            }
        });
        var s = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                wx.setNavigationBarColor({
                    frontColor: t.data.data.base_tcolor,
                    backgroundColor: t.data.data.base_color
                });
            },
            fail: function(t) {}
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getStaffs",
            success: function(t) {
                a.setData({
                    staffs: t.data.data
                });
            }
        });
    },
    onUnload: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getStaffs",
            success: function(t) {
                a.setData({
                    staffs: t.data.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getStaffs",
            success: function(t) {
                a.setData({
                    staffs: t.data.data
                });
            }
        }), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    staffcard: function(t) {
        var a = t.currentTarget.dataset.text;
        wx.navigateTo({
            url: "/sudu8_page/staff_card/staff_card?id=" + a
        });
    },
    sharestaffcard: function(t) {
        var a = t.currentTarget.dataset.text;
        wx.navigateTo({
            url: "/sudu8_page/staff_card/staff_card?id=" + a + "&share=1"
        });
    }
});