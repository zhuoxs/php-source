/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, "/base/mycollect/mycollect")
    },
    onLoadData: function() {
        var a = this,
            e = this.data.page,
            o = this.data.length,
            i = this.data.olist;
        t.api.apiInfoGetMyInfobrowselike({
            user_id: this.data.user.id,
            page: e,
            length: o
        }).then(function(t) {
            var n = !(t.data.length < o);
            if (t.data.length < o && a.setData({
                nomore: !0,
                show: !0
            }), 1 == e) i = t.data;
            else for (var s in t.data) i.push(t.data[s]);
            e += 1, a.setData({
                imgRoot: t.other.img_root,
                show: !0,
                hasMore: n,
                page: e,
                olist: i
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
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        })
    },
    toInfoTap: function(a) {
        t.navTo("/base/circledetail/circledetail?id=" + a.currentTarget.dataset.id)
    },
    onLikeTap: function(a) {
        var e = this,
            o = a.currentTarget.dataset.id;
        console.log(o), t.api.apiInfoSetLike({
            user_id: this.data.user.id,
            id: o
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
        for (var a = this, e = t.currentTarget.dataset.index, o = t.currentTarget.dataset.idx, i = a.data.olist[e].pics, n = [], s = 0; s < i.length; s++) n[s] = a.data.imgRoot + i[s];
        wx.previewImage({
            urls: n,
            current: n[o]
        })
    }
});