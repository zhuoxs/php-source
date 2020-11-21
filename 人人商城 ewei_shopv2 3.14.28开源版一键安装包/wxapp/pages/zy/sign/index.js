
var t = getApp(),
  a = t.requirejs("core");
Page({
  data: {
    yearShow: "",
    monthShow: "",
    json_arr: {},
    advaward: {},
    calendar: [],
    months: [],
    member: {},
    set: {},
    signinfo: {},
    dateHidden: 1,
    orderday: "",
    sum: "",
    credit: "",
    loading: false,
    loaded: false,
  },
  toSignrecord: function (t) {
    wx.navigateTo({
      url: "records"
    })
  },
  toDate: function (t) {
    this.setData({
      dateHidden: !this.data.dateHidden
    })
  },
  onLoad: function (o) {
    o = o || {};
    this.getList()
  },
  getList: function () {
    var t = this;
    a.loading(),
      this.setData({
        loading: true
      }),
      a.get("zy/sign/get_list", { year: t.data.yearShow, month: t.data.monthShow}, function (b) {
      a.hideLoading();
      if (!b.member) {
        a.alert(b.error);
        //wx.navigateBack();
        return false;
      }
      t.setData({
        member: b.member,
        calendar: b.calendar,
        signinfo: b.signinfo,
        advaward: b.advaward,
        yearShow: t.data.yearShow ? t.data.yearShow:b.year,
        monthShow: t.data.monthShow ? t.data.monthShow:b.month,
        today: b.today,
        signed: b.signed,
        signoldtype: b.signoldtype,
        months: b.months,
        set: b.set,
        loading: false,
        show: true
      });
    })
  },
  reDatelist: function (b) {
    var e = this,
      r = b.currentTarget.dataset.year,
      o = b.currentTarget.dataset.month;
      //console.log(o);
    e.setData({
      yearShow: r,
      monthShow: o,
      dateHidden:1
    }), e.getList();
  },
  toSign: function (c) {
    var t = this;
    t.dosign('');
  },
  oldSign: function (c) {
    var t = this;
    var date = c.currentTarget.dataset.date;
    if (!(t.data.yearShow == c.currentTarget.dataset.year && t.data.monthShow == c.currentTarget.dataset.month && t.data.today == c.currentTarget.dataset.day) && t.data.set.signold_price>0) {
        wx.showModal({
          title: "提示",
          content: t.data.set.textsignold + "需扣除" + t.data.set.signold_price + t.data.signoldtype + "，确定" + t.data.set.textsignold + "吗？",
          success: function (z) {
            if (z.confirm) t.dosign(date);
          }
        })
    } else if (t.data.yearShow == c.currentTarget.dataset.year && t.data.monthShow == c.currentTarget.dataset.month && t.data.today == c.currentTarget.dataset.day) t.dosign('');
    else t.dosign(date);
  },
  dosign: function (date){
    var t = this;
    a.post("zy/sign/dosign", { date: date }, function (b) {
      if (!b.success) {
        a.alert(b.error);
        //wx.navigateBack();
        return false;
      }
      a.alert(b.message);
      t.getList();
      if (b.lottery && b.lottery.is_changes>0){
        a.alert('您获得抽奖机会');
        setTimeout(function () {
          wx.redirectTo({
            url: "/pages/zy/lottery/lottery?id=" + b.lottery.lottery.lottery_id
          })
        },3000);
      }
    })
  },
  getCredit: function (b) {
    var t = this;
    var e = b.currentTarget.dataset.day,
      r = this;//console.log(e);
      a.post("zy/sign/doreward", { type:1, day: e }, function (b) {
      if (!b.success) {
        a.alert(b.error);
        //wx.navigateBack();
        return false;
      }
      a.alert(b.message);
      t.getList();
    })
  },
  phone: function (t) {
    a.phone(t)
  },
  tohome: function (t) {
    wx.reLaunch({
      url: '/pages/index/index',
    })
  }
})