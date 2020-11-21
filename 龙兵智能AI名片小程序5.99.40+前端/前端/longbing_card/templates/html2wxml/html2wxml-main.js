function _defineProperty(e, a, i) {
    return a in e ? Object.defineProperty(e, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = i, e;
}

var realWindowWidth = 0, realWindowHeight = 0;

function html2wxml(e, a, i) {
    var t = a, r = [];
    null != t.data.images && (r = t.data.images), void ((e = {
        nodes: e,
        images: r,
        view: {}
    }).view.imagePadding = 0) !== i && (e.view.imagePadding = i), t.setData(e), t.wxmlImgLoad = wxmlImgLoad, 
    t.wxmlImgTap = wxmlImgTap, t.wxmlVideoTap = wxmlVideoTap;
}

function wxmlVideoTap(e) {
    var a = e.currentTarget.dataset.src;
    wx.navigateTo({
        url: a
    });
}

function wxmlImgTap(e) {
    var a = e.target.dataset.src, i = this.data.imageUrls, t = [];
    for (var r in i) void 0 !== i[r] && t.push(i[r]);
    0 < t.length && 1 == getApp().globalData.configInfo.config.preview_switch && wx.previewImage({
        current: a,
        urls: t
    });
}

function wxmlImgLoad(e) {
    calMoreImageInfo(e, e.target.dataset.idx, this);
}

function calMoreImageInfo(e, a, i) {
    var t, r = wxAutoImageCal(e.detail.width, e.detail.height, i);
    i.setData((_defineProperty(t = {}, "images[" + a + "]", {
        width: r.imageWidth,
        height: r.imageHeight
    }), _defineProperty(t, "imageUrls[" + a + "]", e.currentTarget.dataset.src), t));
}

function wxAutoImageCal(e, a, i) {
    var t, r = 0, g = 0, n = {}, d = i.data.view.imagePadding;
    return realWindowHeight, (t = realWindowWidth - 2 * d) < e ? (g = (r = t) * a / e, 
    n.imageWidth = r, n.imageHeight = g) : (n.imageWidth = e, n.imageHeight = a), n;
}

wx.getSystemInfo({
    success: function(e) {
        realWindowWidth = e.windowWidth, realWindowHeight = e.windowHeight;
    }
}), module.exports = {
    html2wxml: html2wxml
};