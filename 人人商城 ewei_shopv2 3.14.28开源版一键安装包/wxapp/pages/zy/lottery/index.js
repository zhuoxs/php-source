
function t(t, e, a) {
  return e in t ? Object.defineProperty(t, e, {
    value: a,
    enumerable: !0,
    configurable: !0,
    writable: !0
  }) : t[e] = a, t
}
var e, a = getApp().requirejs("core");
Page((e = {
  data: {banner:'',list:[]},
  onShow: function (t) {
  }
}, t(e, "onShow", function (t) {
  var e = this;
  a.get("zy/lottery/get_list", {}, function (t) {
    e.setData({
      banner: t.banner,
      list: t.list
    })
  })
  }), t(e, "togame", function (t) {
  var e = t.currentTarget.dataset.id;
  0 == t.currentTarget.dataset.total ? a.alert(t.currentTarget.dataset.tips) : wx.navigateTo({
    url: "/pages/zy/lottery/lottery?id=" + e
  })
}), e));