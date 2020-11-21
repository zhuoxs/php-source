/*www.lanrenzhijia.com   time:2019-06-01 22:11:55*/
var e = getApp(),
    t = 0;
e.Base({
    data: {
        timer: 5,
        hey: !1
    },
    onLoad: function(e) {},
    onShow: function(o) {
        var n = this,
            a = this,
            i = a.data.timer;
        e.api.apiIndexSystemSet().then(function(e) {
            n.setData({
                pic: e.other.img_root + e.data.jszc_img
            })
        }).
        catch (function(t) {
            t.code, e.tips(t.msg)
        }), t = setInterval(function() {
            0 == i && (clearInterval(t), a.setData({
                hey: !a.data.hey
            })), a.setData({
                timer: i--
            })
        }, 1e3)
    },
    onHide: function() {
        clearInterval(t)
    },
    onUnload: function() {
        this.onHide()
    },
    toMyorder: function() {
        e.reTo("/base/myreserveorder/myreserveorder?id=0")
    },
    onTohomeTap: function() {
        e.lunchTo("/pages/home/home")
    }
});