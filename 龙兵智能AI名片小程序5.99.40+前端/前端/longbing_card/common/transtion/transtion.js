var app = getApp();

Page({
    data: {
        src: ""
    },
    onLoad: function(a) {
        var s = this;
        console.log(a, "options transtion");
        var r = {};
        a.url && (r.url = a.url), a.id && (r.id = a.id), a.fromshare && (r.fromshare = a.fromshare), 
        a.name && (r.name = a.name), a.status && (r.status = a.status), a.to_uid && (r.to_uid = a.to_uid), 
        a.from_id && (r.from_id = a.from_id), a.report_id && (r.report_id = a.report_id), 
        a.shareimg && (r.shareimg = a.shareimg), s.setData({
            paramObj: r
        }, function() {
            wx.hideLoading();
            var a = s.data.paramObj, r = a.to_uid, o = a.from_id, t = a.status, i = a.name, e = "/longbing_card/common/webview/webview?id=" + a.id + "&to_uid=" + r + "&from_id=" + o + "&status=" + t + "&name=" + i + "&fromshare=true";
            console.log(e, "tmpUrl  transtion"), wx.navigateTo({
                url: e
            });
        });
    }
});