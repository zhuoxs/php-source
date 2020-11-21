
var t = getApp(),
  a = t.requirejs("core");
Page({
  data: {
    images:[],
    imgs:[]
  },
  onLoad: function (options) {
    this.getinfo();
  },
  onReady: function () {
  
  },
  onShow: function () {
  
  },

  onHide: function () {
  
  },
  onUnload: function () {
  
  },
  onPullDownRefresh: function () {
  
  },

  onReachBottom: function () {
  
  },
  shopName: function (a) {
    this.setData({
      shopName: a.detail.value
    })
  },
  shoptips: function (a) {
    this.setData({
      shoptips: a.detail.value
    })
  },
  save: function () {
    var t = this;
    if (t.data.shopName=='') a.alert('请输入您的小店名称！');
    else{
      a.post("zy/commission/shopset", { save: 1, shopname: t.data.shopName, shopdesc: t.data.shoptips, imgs:t.data.imgs}, function (b) {
        a.alert('保存成功！');
        return setTimeout(function () {
          wx.navigateBack({
            delta: 1
          })
        }, 2000);
      })
    }
  },
  getinfo: function () {
    var t = this;
    a.loading(),
      this.setData({
        loading: true
      }),
      a.get("zy/commission/shopset", {}, function (b) {
        a.hideLoading();
        if (!b.shop) {
          a.alert(b.error);
          //wx.navigateBack();
          return false;
        }
        t.setData({
          shopName: b.shop.name ? b.shop.name:'',
          shoptips: b.shop.desc ? b.shop.desc : '',
          imgs: b.shop.imgs,
          loading: false,
          show: true
        });
      })
  },
  upload: function (t) {
    var e = this,
      s = a.data(t),
      i = s.type,
      o = e.data.images,
      n = e.data.imgs,
      r = s.index;
    "image" == i ? a.upload(function (t) {
      o.push(t.filename), n.push(t.url), e.setData({
        images: o,
        imgs: n
      })
    }) : "image-remove" == i ? (o.splice(r, 1), n.splice(r, 1), e.setData({
      images: o,
      imgs: n
    })) : "image-preview" == i && wx.previewImage({
      current: n[r],
      urls: n
    })
  }
})