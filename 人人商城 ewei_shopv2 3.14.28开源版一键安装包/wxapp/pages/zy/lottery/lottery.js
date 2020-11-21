
var t = getApp().requirejs("core"),
  a = wx.createCanvasContext("myCanvas"), s = getApp().requirejs("wxParse/wxParse");
Page({
  data: {
    awardsList: {},
    animationData: {},
    btnDisabled: "",
    aas: [],
    bgul: {},
    ddd: [],
    bgul2: "",
    id: "",
    awardList: [],
    colorCircleFirst: "#FFDF2F",
    colorCircleSecond: "#FE4D32",
    colorAwardDefault: "#F5F0FC",
    colorAwardSelect: "#ffe400",
    indexSelect: 0,
    isRunning: !1,
    imageAward: [],
    lastDegs: 0,
    lastId: 0,
    showrules:0
  },
  startX: 0,
  startY: 0,
  showrule: function (t) {
    this.setData({ showrules: 1 });
  },
  hiderule: function (t) {
    this.setData({ showrules: 0 });
  },
  gotoList: function () {
    wx.redirectTo({
      url: "../choujiang/index"
    })
  },
  onLoad: function (a) {
    var e = this,
      i = a.id;
    e.setData({
      id: i
    }), t.get("zy/lottery/lottery_reward", {id:i}, function (t) {
      for (var a = [], i = [], n = 0; n < t.data.length; n++) {
        var r = t.data[n].icon,
          s = t.data[n].title;
        a.push(r), i.push(s)
      }
      e.setData({
        aas: t.data,
        imageAward: a
      });
      var o = e.data.aas,
        l = o.length,
        d = 360 / l / 2 + 90,
        c = [],
        u = 1 / l;
      e.setData({
        btnDisabled: ""
      });
      for (var g = wx.createContext(), n = 0; n < l; n++) g.save(), g.beginPath(), g.translate(150, 150), g.moveTo(0, 0), g.rotate((360 / l * n - d) * Math.PI / 180), g.arc(0, 0, 150, 0, 2 * Math.PI / l, !1), n % 2 == 0 ? g.setFillStyle("rgba(255,184,32,.1)") : g.setFillStyle("rgba(255,203,63,.1)"), g.fill(), g.setLineWidth(.5), g.setStrokeStyle("rgba(228,55,14,.1)"), g.stroke(), g.restore(), c.push({
        turn: n * u + "turn",
        lineTurn: n * u + u / 2 + "turn",
        award: o[n].title,
        url: o[n].icon
      });
      e.setData({
        awardsList: c
      });
      for (var f = 7.5, h = 7.5, w = [], n = 0; n < 24; n++) {
        if (0 == n) h = 15, f = 15;
        else if (n < 6) h = 7.5, f += 102.5;
        else if (6 == n) h = 15, f = 620;
        else if (n < 12) h += 94, f = 620;
        else if (12 == n) h = 565, f = 620;
        else if (n < 18) h = 570, f -= 102.5;
        else if (18 == n) h = 565, f = 15;
        else {
          if (!(n < 24)) return;
          h -= 94, f = 7.5
        }
        w.push({
          topCircle: h,
          leftCircle: f
        })
      }
      e.setData({
        circleList: w
      }), setInterval(function () {
        "#FFDF2F" == e.data.colorCircleFirst ? e.setData({
          colorCircleFirst: "#FE4D32",
          colorCircleSecond: "#FFDF2F"
        }) : e.setData({
          colorCircleFirst: "#FFDF2F",
          colorCircleSecond: "#FE4D32"
        })
      }, 500);
      for (var D = [], F = 25, v = 25, y = 0; y < 8; y++) {
        0 == y ? (F = 25, v = 25) : y < 3 ? (F = F, v = v + 166.6666 + 15) : y < 5 ? (v = v, F = F + 150 + 15) : y < 7 ? (v = v - 166.6666 - 15, F = F) : y < 8 && (v = v, F = F - 150 - 15);
        var b = e.data.imageAward[y],
          m = i[y];
        D.push({
          topAward: F,
          leftAward: v,
          imageAward: b,
          titlesa: m
        })
      }
      e.setData({
        awardList: D
      })
      }), t.get("zy/lottery/lottery_info", {id:i}, function (t) {
      e.setData({
        bgul: t.data
      });
      wx.setNavigationBarTitle({
        title: t.data.lottery_title
      });
      s.wxParse("wxParseData", "html", t.intro, e, "10")
    })
  },
  onReady: function () {
    a.setFillStyle("#EFEFEF"), a.fillRect(0, 0, 440, 250.75), a.draw()
  },
  getLottery: function () {
    var a = this,
      e = a.data.id,
      i = 6 * Math.random() >>> 0,
      n = a.data.bgul.has_changes - 1,
      r = a.data.lastDegs,
      s = a.data.lastId;
    a.setData({
      bgul2: n
    });
    var o = a.data.aas,
      l = o.length;
    i < 2 && (o.chance = !1), t.get("zy/lottery/getreward", { lottery:e}, function (i) {
      if (a.setData({
        ddd: i
      }), "number" != typeof a.data.ddd.id) setTimeout(function () {
        wx.showModal({
          title: "提示",
          content: i.info + "",
          showCancel: !1
        }), a.data.bgul.has_changes >= 1 && a.setData({
          btnDisabled: ""
        })
      }, 500);
      else {
        var n = i.id;
        t.get("zy/lottery/reward", { lottery: e, reward:n}, function (t) { });
        var o = r - 360 / l * (a.data.ddd.id - s) + 2880,
          d = wx.createAnimation({
            duration: 8e3,
            timingFunction: "ease"
          });
        a.animationRun = d, d.rotate(o).step(), a.setData({
          lastDegs: o,
          lastId: a.data.ddd.id,
          animationData: d.export(),
          btnDisabled: "disabled"
        }), setTimeout(function () {
          wx.showModal({
            title: "提示",
            content: i.info + "",
            showCancel: !1
          }), a.data.bgul.has_changes >= 1 && a.setData({
            btnDisabled: ""
          })
        }, 8500)
      }
    }), t.get("zy/lottery/lottery_info", {id:e}, function (t) {
      a.setData({
        bgul: t.data
      })
    })
  },
  touchStart: function (e) {
    var i = this,
      n = i.data.id,
      r = e.changedTouches[0].x,
      s = e.changedTouches[0].y;
    t.get("zy/lottery/getreward", { lottery:n}, function (t) {
      a.save(), a.beginPath(), a.clearRect(r, s, 50, 50), a.restore(), i.setData({
        guagua: t
      })
    }), t.get("zy/lottery/lottery_info", {id:n}, function (t) {
      i.setData({
        bgul: t.data
      })
    })
  },
  touchMove: function (t) {
    var e = t.changedTouches[0].x,
      i = t.changedTouches[0].y;
    a.save(), a.moveTo(this.startX, this.startY), a.clearRect(e, i, 50, 50), a.restore(), this.startX = e, this.startY = i, wx.drawCanvas({
      canvasId: "myCanvas",
      reserve: !0,
      actions: a.getActions()
    })
  },
  touchEnd: function () {
    var e = this.data.guagua.id;
    if ("number" != typeof e) wx.showModal({
      title: "提示",
      content: this.data.guagua.info + "",
      showCancel: !1
    });
    else {
      var i = this.data.id;
      t.get("zy/lottery/reward", { lottery: i, reward:e}, function (t) { });
      var n = this.data.guagua.info;
      wx.showModal({
        title: "提示",
        content: n + "",
        showCancel: !1
      })
    }
    a.setFillStyle("#EFEFEF"), a.fillRect(0, 0, 400, 200.75), a.draw()
  },
  startGame: function () {
    if (!this.data.isRunning) {
      this.setData({
        isRunning: !0
      });
      var a = this,
        e = a.data.id;
      t.get("zy/lottery/getreward", { lottery:e}, function (i) {
        var n = i.id;
        if ("number" != typeof n) wx.showModal({
          title: "",
          content: i.info + "",
          showCancel: !1,
          success: function (t) {
            t.confirm
          }
        }), a.data.bgul.has_changes < 1 ? a.setData({
          isRunning: !0
        }) : a.setData({
          isRunning: !1
        });
        else {
          t.get("zy/lottery/reward&=", { lottery: e, reward:n}, function (t) { }), 0 == n && (n = 8);
          var r = a.data.indexSelect,
            s = 200,
            o = setInterval(function () {
              r++ , (s += 50) > 1e3 && r == n && (clearInterval(o), wx.showModal({
                title: "提示",
                content: i.info + "",
                showCancel: !1,
                success: function (t) {
                  t.confirm
                }
              }), a.data.bgul.has_changes < 1 ? a.setData({
                isRunning: !0
              }) : a.setData({
                isRunning: !1
              })), r %= 8, a.setData({
                indexSelect: r
              })
            }, s)
        }
      }), t.get("zy/lottery/lottery_info", {id:e}, function (t) {
        a.setData({
          bgul: t.data
        })
      })
    }
  }
});