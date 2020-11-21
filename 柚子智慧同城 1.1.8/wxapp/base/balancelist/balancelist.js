/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function a(a, t, i) {
    return t in a ? Object.defineProperty(a, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = i, a
}
var t = getApp();
t.Base({
    data: {},
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData(a)
        }, "/base/balancelist/balancelist")
    },
    onLoadData: function() {
        var a = this,
            i = {
                user_id: this.data.user.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
        t.api.apiRechargeBalanceList(i).then(function(t) {
            a.setData({
                show: !0
            }), a.dealList(t.data, 0)
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    loadList: function() {
        var i = this;
        if (!this.data.list.over) {
            this.setData(a({}, "list.load", !0));
            var e = {
                user_id: this.data.user.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            t.api.apiRechargeBalanceList(e).then(function(a) {
                i.setData({
                    show: !0
                }), i.dealList(a.data, e.page)
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        }
    },
    onReachBottom: function() {
        this.loadList()
    },
    onInfoTap: function(a) {
        var i = a.currentTarget.dataset.idx,
            e = "/base/balanceinfo/balanceinfo?id=" + JSON.stringify(this.data.list.data[i]);
        t.navTo(e)
    }
});