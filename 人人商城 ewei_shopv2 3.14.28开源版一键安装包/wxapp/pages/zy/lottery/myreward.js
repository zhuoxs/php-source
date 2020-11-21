var t = getApp(),
  e = t.requirejs("core");
Page({
  data: {
    awardsList: {},
    userInfo: {},
    searchLoading: !1,
    searchLoadingComplete: !1,
    ddd: [],
    page: 1
  },
  gotoLottery: function () {
    wx.redirectTo({
      url: "../Wheel/index"
    })
  },
  onShow: function (a) {
    var r = this;
    e.get("zy/lottery/myrewardpage", {}, function (t) {
      r.setData({
        ddd: t.list,
        page:2
      })
    });
    var s = wx.getStorageSync("winAwards") || {
      data: []
    };
    s = s && s.data && s.data.length > 0 ? s.data : [], t.getUserInfo(function (t) {
      r.setData({
        userInfo: t,
        awardsList: s || []
      })
    })
  },
  onReachBottom: function (t) {
    var a = this,
      r = a.data.page,
      s = a.data.ddd;
    e.get("zy/lottery/myrewardpage", {
      page: r
    }, function (t) {
      if (0 == t.list.length) a.setData({
        searchLoading: !1,
        searchLoadingComplete: !0
      });
      else {
        t.list.length > 0 && r++;
        for (var e = 0; e < t.list.length; e++) s.push(t.list[e]);
        a.setData({
          ddd: s,
          page: r
        }), t.list.length, a.setData({
          searchLoading: !0,
          searchLoadingComplete: !1
        })
      }
    })
  }
});