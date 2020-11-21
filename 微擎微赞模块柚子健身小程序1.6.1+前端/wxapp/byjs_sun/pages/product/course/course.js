var app = getApp();

Page({
    data: {
        id: 1,
        productRecommend: [ {
            recommendImg: "http://img.zcool.cn/community/03879005798abdc0000018c1b07f124.jpg",
            recommendTitle: "怎鸡肉课程",
            recommendPic: "858",
            instructor: "小名",
            type: "私教课",
            time: "1月8日 19：00-20：00"
        } ]
    },
    onLoad: function(t) {
        var o = this, e = t.course_type, n = t.mid;
        console.log(t), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/TypeCourse",
            data: {
                course_type: e,
                mid: n
            },
            success: function(t) {
                console.log(t), o.setData({
                    productRecommend: t.data
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
    goCourseInfo: function(t) {
        var o = t.currentTarget.dataset.id, e = t.currentTarget.dataset.cid;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/courseGoInfo/courseGoInfo?id=" + o + "&cid=" + e
        });
    }
});