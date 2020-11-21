var app = getApp();

Component({
    properties: {},
    data: {
        reportArr: []
    },
    methods: {
        setListData: function() {
            var r = app.globalData.reportArr;
            this.setData({
                reportArr: r
            }), app.globalData.reportArr = [], this.calculationLeft(r);
        },
        calculationLeft: function(r) {
            console.log(r);
            for (var t = 0; t < r.length; t++) for (var e = 0; e < r[t].secArr1.length; e++) if (3 == r[t].secArr1[e].displaytype) {
                var a = Number(r[t].secArr1[e].highStandard) + (Number(r[t].secArr1[e].highStandard) - Number(r[t].secArr1[e].lowStandard)), o = Number(r[t].secArr1[e].lowStandard) - (Number(r[t].secArr1[e].highStandard) - Number(r[t].secArr1[e].lowStandard)), s = a - o, n = Number(r[t].secArr1[e].description), i = n - o;
                console.log(a, o, n, i), r[t].secArr1[e].left = i / s * 100;
            }
            this.setData({
                reportArr: r
            });
        },
        openClick: function(r) {
            var t = r.currentTarget.dataset.index, e = r.currentTarget.dataset.idx, a = this.data.reportArr;
            a[e].project[t].open = !0, this.setData({
                reportArr: a
            });
        },
        closeClick: function(r) {
            var t = r.currentTarget.dataset.index, e = r.currentTarget.dataset.idx, a = this.data.reportArr;
            a[e].project[t].open = !1, this.setData({
                reportArr: a
            });
        },
        abnormalClick: function() {
            this.triggerEvent("abnormal", {});
        },
        suggestion: function() {
            wx.navigateTo({
                url: "/hyb_yl/suggestion/suggestion"
            });
        }
    },
    ready: function() {
        this.setListData();
    }
});