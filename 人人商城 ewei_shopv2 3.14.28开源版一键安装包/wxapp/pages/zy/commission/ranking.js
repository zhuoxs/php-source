
var t = getApp(),
  a = t.requirejs("core"),
  e = t.requirejs("jquery");
Page({
  data: {
    user:{},
    page: 1,
    maxnum:0,
    loading: false,
    loaded: false,
    list: []
  },
  onLoad: function (z) {
    var b = this;
    b.getMain();
    b.getList();
  },
  getMain: function () {
    var t = this;
    a.loading(),
      this.setData({
        loading: true
      }),
      a.get("zy/commission/rank", {
      }, function (b) {
        a.hideLoading();
        if (!b.user) {
          a.alert(b.error);
          return false;
        }
        t.setData({
          user: b.user,
          commission_title: b.commission_title,
          maxnum: b.maxnum,
          loading: false,
          show: true
        });
      })
  },
  getList: function () {
    var b = this;
    a.loading(),
      this.setData({
        loading: true
      }),
      a.get("zy/commission/rank_list", {
        page: this.data.page
      }, function (e) {
        var i = {
          loading: false,
          total: e.total,
          pagesize: e.pagesize
        };
        e.list.length > 0 && (i.page = b.data.page + 1, i.list = b.data.list.concat(e.list), e.list.length < e.pagesize && (i.loaded = true), b.setSpeed(e.list)),
          b.setData(i),
          a.hideLoading()
      })
  },
  setSpeed: function (t) {
    if (t && !(t.length < 1))
      for (var a in t) {
        var e = t[a];
        if (!isNaN(e.lastratio)) {
          var i = e.lastratio / 100 * 2.5,
            s = wx.createContext();
          s.beginPath(),
            s.arc(34, 35, 30, .5 * Math.PI, 2.5 * Math.PI),
            s.setFillStyle("rgba(0,0,0,0)"),
            s.setStrokeStyle("rgba(0,0,0,0.2)"),
            s.setLineWidth(4),
            s.stroke(),
            s.beginPath(),
            s.arc(34, 35, 30, .5 * Math.PI, i * Math.PI),
            s.setFillStyle("rgba(0,0,0,0)"),
            s.setStrokeStyle("#ffffff"),
            s.setLineWidth(4),
            s.setLineCap("round"),
            s.stroke();
          var o = "coupon-" + e.id;
          wx.drawCanvas({
            canvasId: o,
            actions: s.getActions()
          })
        }
      }
  },
  more: function () {
    if (this.data.list.length >= this.data.maxnum) a.alert('排名仅展示前'+this.data.maxnum+'名！');
    else if (this.data.list.length == this.data.total) a.alert('已加载完全部数据');
    else{
      this.data.loaded || this.getList()
    }
  }
})