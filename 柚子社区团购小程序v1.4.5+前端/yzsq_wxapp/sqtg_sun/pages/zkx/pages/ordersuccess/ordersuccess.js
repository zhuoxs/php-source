var app = getApp(), setIndex = 0;

Page({
    data: {
        timer: 5,
        hey: !1
    },
    onLoad: function() {},
    onShow: function(t) {
        var e = this, a = e.data.timer;
        app.ajax({
            url: "Csystem|getSetting",
            success: function(t) {
                e.setData({
                    pic: t.other.img_root + t.data.pt_pic
                });
            }
        }), setIndex = setInterval(function() {
            0 == a && (clearInterval(setIndex), e.setData({
                hey: !e.data.hey
            })), e.setData({
                timer: a--
            });
        }, 1e3);
    },
    onHide: function() {
        clearInterval(setIndex);
    },
    onUnload: function() {
        this.onHide();
    },
    toMyorder: function() {
        app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?id=0");
    }
});