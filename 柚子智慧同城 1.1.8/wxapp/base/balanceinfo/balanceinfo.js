/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
getApp().Base({
    data: {},
    onLoad: function(a) {
        console.log(a);
        var o = JSON.parse(a.id);
        this.setData({
            show: !0,
            info: o
        })
    }
});