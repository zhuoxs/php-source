Page({
    data: {
        shopname: "柚子美发",
        branch: "湖里店",
        phone: "0592-666666",
        address: "福建省厦门市集美区杏林湾路厦门市集美区杏林湾路",
        shoplogo: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152686894621.png",
        unum: 5,
        hairUser: [ {
            hairName: "托尼",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg"
        }, {
            hairName: "马丁",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg"
        } ],
        openTime: "09:00-22:00",
        order: [ {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553528.png",
            title: "居家保洁-24小时",
            desc: "居家保洁、家电清洗",
            price: "259.00"
        }, {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553537.png",
            title: "日式精细擦窗",
            desc: "玻璃窗、百叶窗、卷帘窗、防盗窗",
            price: "259.00"
        }, {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553537.png",
            title: "居家保洁-24小时",
            desc: "居家保洁、家电清洗",
            price: "259.00"
        } ]
    },
    onLoad: function(o) {
        var t = this.data.shopname + " " + this.data.branch;
        wx.setNavigationBarTitle({
            title: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toBook: function(o) {
        wx.navigateTo({
            url: "../../index/book/book"
        });
    },
    toSerdesc: function(o) {
        wx.navigateTo({
            url: "../../index/serdesc/serdesc"
        });
    },
    toBranch: function(o) {
        wx.switchTab({
            url: "../branch"
        });
    }
});