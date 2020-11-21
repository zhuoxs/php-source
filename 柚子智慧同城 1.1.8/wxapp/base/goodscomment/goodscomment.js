/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        pageType: 0,
        anonymous: !0
    },
    onLoad: function(t) {
        var a = this;
        this.setData({
            pageType: t.page,
            oid: t.id
        });
        var i = "/base/goodscomment/goodscomment?page=" + t.page + "&id=" + t.id;
        this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, i)
    },
    onLoadData: function() {
        var a = this;
        if (0 == this.data.pageType) {
            var i = {
                order_id: this.data.oid
            };
            t.api.apiOrderGetOrderDetail(i).then(function(t) {
                a.setData({
                    imgRoot: t.other.img_root,
                    pic: t.data.detail[0].pic,
                    order: t.data
                })
            }).
            catch (function(a) {
                a.code, t.tips(a.msg)
            })
        }
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
            i = this.data.order,
            e = {
                order_id: this.data.oid,
                order_detail_id: i.detail[0].id,
                user_id: this.data.user.id,
                stars: this.data.star,
                content: this.data.txt,
                imgs: this.data.images,
                anonymous: this.data.anonymous ? 0 : 1
            };
        !e.content || e.content.length < 10 ? t.tips("亲，服务评价至少10个字哦！") : this.data.ajax || (this.setData({
            ajax: !0
        }), t.api.apiCommentComment(e).then(function(a) {
            t.alert("谢谢您的评价", function() {
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