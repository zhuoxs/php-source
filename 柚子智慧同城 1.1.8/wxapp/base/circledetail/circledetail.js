/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
var t = getApp();
t.Base({
    data: {
        type2: 2,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(e) {
            a.setData({
                user: e,
                id: t.id
            }), a.onLoadData()
        }, "/base/circledetail/circledetail?id=" + t.id)
    },
    onLoadData: function() {
        var a = this,
            e = this.data.page,
            i = this.data.length,
            n = this.data.olist,
            o = wx.getStorageSync("setting");
        Promise.all([t.api.apiInfoGetInfoDetail({
            id: this.data.id,
            user_id: this.data.user.id
        }), t.api.apiInfoGetInfoCommentList({
            info_id: this.data.id,
            page: e,
            length: i
        })]).then(function(s) {
            s[0].data || t.alert("该帖子不存在,去首页逛逛~", function() {
                t.lunchTo("/pages/home/home")
            }, 0);
            s[1].data.length;
            if (s[1].data.length < i && a.setData({
                nomore: !0,
                show: !0
            }), 1 == e) n = s[1].data;
            else for (var r in s[1].data) n.push(s[1].data[r]);
            e += 1, a.setData({
                imgRoot: s[0].other.img_root,
                info: s[0].data,
                olist: n,
                projectName: o.config.pt_name
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
    },
    onCloseTap: function() {
        this.setData({
            comments: !1
        })
    },
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        })
    },
    onLikeTap: function(a) {
        var e = this,
            i = a.currentTarget.dataset.id;
        t.api.apiInfoSetLike({
            user_id: this.data.user.id,
            id: i
        }).then(function(t) {
            e.setData({
                page: 1
            }), e.onLoadData()
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    onPreviewTap: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, i = a.data.info.pics, n = [], o = 0; o < i.length; o++) n[o] = a.data.imgRoot + i[o];
        wx.previewImage({
            urls: n,
            current: n[e]
        })
    },
    onReleaseTap: function() {
        t.reTo("/pages/circle/circle")
    },
    onPopshowTap: function(t) {
        if (t) {
            var a = t.currentTarget.dataset.id || !1,
                e = t.currentTarget.dataset.replytype || !1;
            this.setData({
                replyId: a,
                replyType: e
            })
        }
        this.setData({
            comments: !0
        })
    },
    formSubmit: function(a) {
        var e = this,
            i = a.detail.value.commentTxt;
        if ("" != i) {
            var n = {
                user_id: this.data.user.id,
                content: i
            }, o = this.data.replyId;
            this.data.replyType ? (n.comment_type = 2, n.comment_id = o) : (n.comment_type = 1, n.info_id = this.data.id), t.api.apiInfoSetInfoComment(n).then(function(a) {
                e.setData({
                    comments: !1,
                    page: 1
                }), t.tips("评论成功！"), e.onLoadData()
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        } else t.tips("请输入评论内容")
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        })
    },
    onShareAppMessage: function() {
        return {
            title: "帖子详情",
            path: "/base/circledetail/circledetail?id=" + this.data.id
        }
    },
    toHomeTap: function() {
        t.lunchTo("/pages/home/home")
    }
});