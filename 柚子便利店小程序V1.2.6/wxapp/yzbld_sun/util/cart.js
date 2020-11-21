Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _md = require("./md5"), _md2 = _interopRequireDefault(_md);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function getKey(t) {
    return t.store_id + ":" + t.goods_type + ":" + t.id;
}

function pushCart(t, e, r) {
    var o = t[e];
    o.num += r, t[e] = o, wx.setStorageSync("carts", t);
}

function decNumCart(t, e, r) {
    var o = t[e];
    o.num -= r, t[e] = o, wx.setStorageSync("carts", t);
}

function delCartObj(t, e) {
    delete t[e], wx.setStorageSync("carts", t);
}

function createToCart(t, e, r) {
    t[e] = r, console.log(t), wx.setStorageSync("carts", t), console.log(wx.getStorageSync("carts"));
}

function addCart(t, e) {
    e || (e = 1), t.hasOwnProperty("store_id") || (t.store_id = getStoreId()), t.hasOwnProperty("goods_type") || (t.goods_type = 0), 
    t.hasOwnProperty("num") || (t.num = 1);
    var r = wx.getStorageSync("carts") || {}, o = getKey(t);
    return r.hasOwnProperty(o) ? (console.log("pushCart"), pushCart(r, o, e)) : (console.log("createToCart"), 
    console.log(r), createToCart(r, o, t)), !0;
}

function decCart(t, e, r) {
    e || (e = 1), t.hasOwnProperty("store_id") || (t.store_id = getStoreId()), t.hasOwnProperty("goods_type") || (t.goods_type = 0), 
    r || (r = !1);
    var o = wx.getStorageSync("carts") || {}, n = getKey(t);
    if (o.hasOwnProperty(n)) return o[n].num <= 1 ? r ? (console.log("delete cartObj"), 
    delCartObj(o, n), !0) : (console.log("return -1"), -1) : (console.log("decNumCart"), 
    decNumCart(o, n, e), !0);
}

function clearCart() {
    var t = wx.getStorageSync("carts") || {}, e = getStoreId();
    for (var r in t) t[r].store_id == e && delete t[r];
    return wx.setStorageSync("carts", t), !0;
}

function getCart() {
    var t = getStoreId(), e = [], r = wx.getStorageSync("carts") || {};
    for (var o in console.log("getCart"), console.log(r), r) r[o].store_id == t && e.push(r[o]);
    return e;
}

function totalPrice() {
    for (var t = getCart(), e = 0, r = 0; r < t.length; ++r) e += t[r].num * t[r].price;
    return new Number(e).toFixed(2);
}

function showSuccess() {
    wx.showToast({
        title: "加入购物车成功",
        icon: "success",
        duration: 2e3
    });
}

function showFail() {
    wx.showToast({
        title: "加入购物车失败",
        icon: "none",
        duration: 2e3
    });
}

function getStoreId() {
    var t = wx.getStorageSync("storeId") || 1;
    return parseInt(t);
}

function getNum(t) {
    t.hasOwnProperty("store_id") || (t.store_id = getStoreId()), t.hasOwnProperty("goods_type") || (t.goods_type = 0);
    var e = wx.getStorageSync("carts") || {}, r = getKey(t);
    return e.hasOwnProperty(r) ? e[r].num : 0;
}

function getAllNum() {
    for (var t = getCart(), e = 0, r = 0; r < t.length; ++r) e += t[r].num;
    return e;
}

exports.default = {
    add: addCart,
    dec: decCart,
    clear: clearCart,
    get: getCart,
    totalPrice: totalPrice,
    showSuccess: showSuccess,
    showFail: showFail,
    getStoreId: getStoreId,
    getNum: getNum,
    getAllNum: getAllNum
};