var app = getApp();

Page({
    data: {
        allcourse: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "增肌增重课程"
        } ]
    },
    onLoad: function(t) {
        var a = this, e = t.mid;
        a.setData({
            mid: e
        }), console.log(a.data.mid), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CourseType",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), a.setData({
                    allcourse: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goBay: function(t) {
        var a = t.currentTarget.dataset.course_type, e = this.data.mid;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/course/course?course_type=" + a + "&mid=" + e
        });
    }
});