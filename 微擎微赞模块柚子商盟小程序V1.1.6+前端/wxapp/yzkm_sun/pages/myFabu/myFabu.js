function _defineProperty(t, o, n) {
    return o in t ? Object.defineProperty(t, o, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[o] = n, t;
}

var app = getApp();

Page({
    data: {
        yh_id: "",
        fabuData: [ {
            headerImg: "http://oydnzfrbv.bkt.clouddn.com/touxiang.png",
            name: "那棵树看起来真生气了",
            contents: "厦门市有什么好吃的吗可以推荐给我推荐给我？求推荐求介绍求推荐求介绍...",
            contentImgs: [ "http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png", "http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png" ],
            address: "厦门市集美区杏林湾营运中心9号楼正面",
            date: "2018-04-09 18:00",
            see: "2018",
            zan: "04",
            conmm: "24"
        }, {
            headerImg: "http://oydnzfrbv.bkt.clouddn.com/touxiang.png",
            name: "那棵树看起来真生气了",
            contents: "厦门市有什么好吃的吗可以推荐给我推荐给我？求推荐求介绍求推荐求介绍...",
            contentImgs: [ "http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png", "http://oydnzfrbv.bkt.clouddn.com/quanzitupian.png" ],
            address: "厦门市集美区杏林湾营运中心9号楼正面",
            date: "2018-04-20 18:00",
            see: "2018",
            zan: "04",
            conmm: "24"
        } ]
    },
    onLoad: function(t) {
        var o = this;
        console.log(t), console.log(o.data.fabuData), app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), console.log(t), wx.getStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        });
        var n = wx.getStorageSync("openid");
        console.log(n), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: n
            },
            success: function(t) {
                console.log("查看用户id"), console.log(t.data), o.setData({
                    yh_id: t.data.id
                }), wx.setStorageSync("user_id", t.data.id);
            }
        }), o.diyWinColor();
    },
    toCircleDetails: function(t) {
        console.log("跳转我的发布详情页id"), console.log(t);
        var o = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Quan_sc",
            data: {
                fabu_yh_id: o
            },
            success: function(t) {
                if (console.log("判断收藏的圈子是否已删除"), console.log(t), 2 == t.data.dele_sta) return wx.showToast({
                    title: "该收藏已被删除或下架",
                    icon: "none"
                }), !1;
                wx.navigateTo({
                    url: "../circle/details/details?id=" + o
                });
            }
        });
    },
    praise: function(t) {
        var o = this;
        console.log("圈子说说id"), console.log(t.currentTarget.dataset.id);
        var n = t.currentTarget.dataset.idx, e = o.data.list[n].id, a = wx.getStorageSync("user_id");
        o.diyWinColor(), app.util.request({
            url: "entry/wxapp/Tickle_qz",
            data: {
                openid: a,
                fabu_id: e
            },
            success: function(t) {
                console.log("圈子点赞数据信息"), console.log(t), 1 == t.data && o.setData(_defineProperty({}, "list[" + n + "].praise", o.data.list[n].praise - 0 + 1));
            }
        });
    },
    delete: function(t) {
        var o = this;
        console.log("删除评论内容"), console.log(t), app.util.request({
            url: "entry/wxapp/Delete_myfabu",
            data: {
                zx_id: t.currentTarget.dataset.id
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: "确定要删除该内容？",
                    success: function(t) {
                        t.confirm ? (console.log("用户点击确定"), console.log("删除返回数据"), console.log(t.data), 
                        wx.showToast({
                            title: "删除成功"
                        }), setTimeout(function() {
                            o.onShow();
                        }, 2e3)) : t.cancel && console.log("用户点击取消");
                    }
                });
            },
            fail: function(t) {
                wx.showToast({
                    title: "删除失败"
                });
            }
        });
    },
    onReady: function() {},
    onShow: function(t) {
        var o = this;
        console.log("11111111111111");
        var n = wx.getStorageSync("user_id");
        app.util.request({
            url: "entry/wxapp/Publish_mine",
            data: {
                yh_id: n
            },
            success: function(t) {
                console.log("查看我的发布信息"), console.log(t.data), o.setData({
                    list: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "我的发布"
        });
    }
});