var app = getApp();

Component({
    properties: {
        currentPage: {
            type: Number
        },
        bg_id: {
            type: String
        },
        time: {
            type: String
        }
    },
    data: {},
    methods: {
        bloodClick: function(e) {
            console.log("picker发送选择改变，携带值为", e.detail.value);
            var t = this.data.secArr1, a = e.currentTarget.dataset.idx;
            e.currentTarget.dataset.indexs;
            t[a].picker.displayorder = e.detail.value, t[a].description = t[a].picker.items[e.detail.value], 
            this.setData({
                secArr1: t
            });
        },
        setListData: function() {
            this.setData({
                secArr1: app.globalData.secArr1
            }), app.globalData.secArr1 = [];
        },
        subClick: function(e) {
            console.log(e);
            var t = {
                value: e.detail.value
            };
            this.triggerEvent("sub", t);
        },
        lastClick: function(e) {
            this.triggerEvent("last");
        },
        chooseCheck: function(e) {
            for (var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.indexs, r = this.data.secArr1, s = 0; s < r.length; s++) 1 == r[s].displaytype && (r[s].items[t].checked = !r[s].items[t].checked, 
            console.log(r[s]), r[s].items[t].checked ? r[s].description += r[s].items[t].title + ";" : r[s].description = r[s].description.replace(secArr[a].secArr1[s].items[t].title + ";", ""));
            console.log(r), this.setData({
                secArr1: r
            });
        },
        choosePhoto: function(e) {
            var t = this, a = t.data.secArr1, r = (e.currentTarget.dataset.index, e.currentTarget.dataset.indexs, 
            e.currentTarget.dataset.idx);
            wx.chooseImage({
                count: 9,
                sizeType: [ "original", "compressed" ],
                sourceType: [ "album", "camera" ],
                success: function(e) {
                    a[r].items = a[r].items.concat(e.tempFilePaths), a[r].description = a[r].items, 
                    9 <= a[r].items.length && (a[r].items.length = 9), console.log(a), t.setData({
                        secArr1: a
                    });
                }
            });
        },
        radioChange: function(e) {
            console.log(e);
            var t = this.data.secArr1, a = e.currentTarget.dataset.idx;
            e.currentTarget.dataset.indexs;
            t[a].description = e.detail.value, this.setData({
                secArr1: t
            });
        },
        lineClick: function(e) {
            console.log(e);
            var t = this, a = t.data.secArr1, r = (e.currentTarget.dataset.indexs, e.currentTarget.dataset.idx);
            a[r].description = e.detail.value;
            var s = Number(e.detail.value), i = Number(e.currentTarget.dataset.highstandard), c = Number(e.currentTarget.dataset.lowstandard);
            a[r].time = t.data.time, a[r].abnormal = s < i && c < s ? 1 : 0, t.setData({
                secArr1: a
            });
        },
        duohangClick: function(e) {
            console.log(e);
            var t = this.data.secArr1;
            e.currentTarget.dataset.indexs;
            t[e.currentTarget.dataset.idx].description = e.detail.value, this.setData({
                secArr1: t
            });
        }
    },
    ready: function() {
        this.setListData();
    }
});