/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        pageType: 0,
        anonymous: !1,
        star: 3
    },
    onLoad: function(t) {
        var a = this;
        this.setData({
            pageType: t.page,
            oid: t.id
        }), 0 == t.page ? wx.setNavigationBarTitle({
            title: "抢购评价晒单"
        }) : 1 == t.page ? wx.setNavigationBarTitle({
            title: "拼团评价晒单"
        }) : 2 == t.page && wx.setNavigationBarTitle({
            title: "折扣评价晒单"
        });
        var i = "/base/comment/comment?page=" + t.page + "&id=" + t.id;
        this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, i)
    },
    onLoadData: function() {
        var a = this;
        0 == this.data.pageType ? t.api.apiPanicOrderInfo({
            oid: this.data.oid
        }).then(function(t) {
            a.setData({
                imgRoot: t.other.img_root,
                pic: t.data.panic.pic
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        }) : 1 == this.data.pageType ? t.api.apiPinOrderDetails({
            oid: this.data.oid
        }).then(function(i) {
            "订单不存在" != i.msg ? a.setData({
                imgRoot: i.other.img_root,
                pic: i.data.goodsinfo.pic
            }) : t.alert("订单不存在！", function() {
                a.reloadPrevious(), wx.navigateBack({
                    delta: 1
                })
            }, 0)
        }).
        catch (function(a) {
            t.tips(a.msg)
        }) : 2 == this.data.pageType && t.api.apiDiscountOrderInfo({
            oid: this.data.oid
        }).then(function(i) {
            "订单不存在" != i.msg ? a.setData({
                imgRoot: i.other.img_root,
                pic: i.data.storeinfo.logo
            }) : t.alert("订单不存在！", function() {
                a.reloadPrevious(), wx.navigateBack({
                    delta: 1
                })
            }, 0)
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    getImages: function(t) {
        this.setData({
            images: t.detail
        })
    },
    getStar: function(t) {
        this.setData({
            star: t.detail
        })
    },
    getTxt: function(t) {
        this.setData({
            txt: t.detail.value
        })
    },
    getAgree: function(t) {
        this.setData({
            anonymous: !this.data.anonymous
        })
    },
    onSendTab: function() {
        var a = this,
            i = {
                order_id: this.data.oid,
                user_id: this.data.user.id,
                stars: this.data.star,
                content: this.data.txt,
                imgs: this.data.images,
                anonymous: this.data.anonymous ? 1 : 0
            };
        i.content.length < 10 ? t.tips("亲，服务评价至少10个字哦！") : this.data.ajax || (this.setData({
            ajax: !0
        }), 0 == this.data.pageType ? t.api.apiPanicAddComment(i).then(function(i) {
            a.reloadPrevious(), t.alert("谢谢您的评价", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0)
        }).
        catch (function(i) {
            a.data.ajax = !1, t.tips(i.msg)
        }) : 1 == this.data.pageType ? t.api.apiPinAddComment(i).then(function(i) {
            a.reloadPrevious(), t.alert("谢谢您的评价", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0)
        }).
        catch (function(i) {
            a.data.ajax = !1, t.tips(i.msg)
        }) : 2 == this.data.pageType && t.api.apiDiscountComment(i).then(function(i) {
            a.reloadPrevious(), t.alert("谢谢您的评价", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0)
        }).
        catch (function(i) {
            a.data.ajax = !1, t.tips(i.msg)
        }))
    }
});