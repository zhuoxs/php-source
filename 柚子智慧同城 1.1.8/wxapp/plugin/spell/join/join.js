/*www.lanrenzhijia.com   time:2019-06-01 22:11:50*/
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
    data: {
        downTime: 0
    },
    onLoad: function(a) {
        var t = this,
            i = a.id.split("-");
        this.checkLogin(function(a) {
            t.setData({
                user: a,
                param: {
                    heads_id: i[0],
                    goods_id: i[1],
                    user_id: a.id
                }
            }), t.onLoadData()
        }, "/plugin/spell/join/join?id=" + a.id)
    },
    onUnload: function() {
        clearInterval(this.timer)
    },
    onLoadData: function() {
        var i = this;
        t.api.apiPinJoinPage(this.data.param).then(function(t) {
            var n = (new Date).getTime() / 1e3,
                o = t.data.headinfo.expire_time - 0,
                e = 0;
            o - n - 10 > 0 && (e = o - n - 10), i.setData({
                downTime: e
            });
            var s = t.data.headinfo.groupnum,
                d = t.data.grouppaynum,
                r = t.data.groupnum;
            t.data.btn_status = 0, t.data.btn_status = s <= d ? 2 : o - n - 10 > 0 ? s <= r ? 1 : 0 : 3, clearInterval(i.timer), 0 != t.data.btn_status && 1 != t.data.btn_status || (i.timer = setInterval(function() {
                i.setData({
                    downTime: e
                }), --e <= 0 && (i.setData(a({}, "info.btn_status", 3)), clearInterval(i.timer))
            }, 1e3)), i.setData({
                info: t.data,
                imgRoot: t.other.img_root,
                show: !0
            })
        }).
        catch (function(a) {
            -1 == a.code && "该团过期" == a.msg ? wx.showModal({
                title: "提示",
                content: a.msg,
                showCancel: !1,
                success: function(a) {
                    wx.navigateBack({
                        delta: 1
                    })
                }
            }) : t.tips(a.msg)
        })
    },
    onBtnTab: function() {
        if (0 == this.data.info.btn_status) {
            var a = this.data.param.goods_id + "-" + this.data.param.heads_id;
            console.log(a), t.reTo("/plugin/spell/info/info?id=" + a)
        } else {
            var i = this.data.param.goods_id + "-0";
            t.reTo("/plugin/spell/info/info?id=" + i)
        }
    },
    onInfoTab: function() {
        var a = this.data.param.goods_id + "-0";
        t.reTo("/plugin/spell/info/info?id=" + a)
    },
    onRickTap: function() {
        t.navTo("/base/rich/rich?id=2")
    },
    onShareAppMessage: function() {
        var a = this.data.param.heads_id + "-" + this.data.param.goods_id;
        return {
            title: this.data.user.nickname + "邀请您参加“" + this.data.info.goodsinfo.name + "”的拼团活动",
            path: "/plugin/spell/join/join?id=" + a
        }
    }
});