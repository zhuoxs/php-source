/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t
}
var a = getApp();
a.Base({
    data: {
        navChoose: 0,
        showmodalstatus: !1
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData(t)
        }, "/base/myintegral/myintegral")
    },
    onLoadData: function() {
        var t = 0,
            i = this;
        a.api.apiIntegralMyInteral({
            user_id: this.data.user.id
        }).then(function(a) {
            i.setData({
                info: a.data
            }), 1 == ++t && i.setData({
                show: !0
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        });
        var s = {
            page: this.data.list.page,
            length: this.data.list.length,
            user_id: this.data.user.id,
            type: 1
        };
        a.api.apiIntegralIntegralRecord(s).then(function(a) {
            i.dealList(a.data, 0), 1 == ++t && i.setData({
                show: !0
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    loadList: function() {
        var i = this;
        if (!this.data.list.over) {
            this.setData(t({}, "list.load", !0));
            var s = {
                page: this.data.list.page,
                length: this.data.list.length,
                user_id: this.data.user.id,
                type: this.data.navChoose - 0 + 1
            };
            a.api.apiIntegralIntegralRecord(s).then(function(t) {
                i.dealList(t.data, s.page)
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        }
    },
    onReachBottom: function() {
        this.loadList()
    },
    onSwichNav: function(t) {
        var a = t.target.dataset.id;
        this.setData({
            navChoose: a,
            list: {
                page: 0,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), this.loadList()
    },
    warm: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a)
    },
    close: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a)
    },
    util: function(t) {
        "open" == t && this.setData({
            showmodalstatus: !0
        }), "close" == t && this.setData({
            showmodalstatus: !1
        })
    }
});