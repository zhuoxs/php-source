/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp(),
    e = 0;
t.Base({
    data: {
        timer: 5,
        hey: !1
    },
    onLoad: function(t) {},
    onShow: function(o) {
        var n = this,
            a = this,
            i = a.data.timer;
        t.api.apiIndexSystemSet().then(function(t) {
            n.setData({
                pic: t.other.img_root + t.data.jszc_img
            })
        }).
        catch (function(e) {
            e.code, t.tips(e.msg)
        }), e = setInterval(function() {
            0 == i && (clearInterval(e), a.setData({
                hey: !a.data.hey
            })), a.setData({
                timer: i--
            })
        }, 1e3)
    },
    onHide: function() {
        clearInterval(e)
    },
    onUnload: function() {
        this.onHide()
    },
    toMyorder: function() {
        t.reTo("/base/mygoodsorder/mygoodsorder?id=0")
    },
    onTohomeTap: function() {
        t.lunchTo("/pages/home/home")
    }
});