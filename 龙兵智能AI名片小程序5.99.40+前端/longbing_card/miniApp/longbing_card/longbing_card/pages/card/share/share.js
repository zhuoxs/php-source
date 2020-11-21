
var app = getApp(); 

Page({
  imagePath: '',
  data: {
    template: {},
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this; 
    app.util.showLoading(4);
    var currPage = getCurrentPages(); 
    var prevPage = currPage[currPage.length - 2].__viewData__;
    console.log('prevPage',prevPage)
    var to_uid = app.globalData.to_uid;
    var isIphoneX = app.globalData.isIphoneX;

    wx.hideShareMenu();
    let template = {
      width: '670rpx',
      height: '1070rpx',
      background: '#ffffff',
      views: [ 
        {
          type: 'image',
          url:prevPage.tmpShareData.avatar,
          css: {
            top: '0rpx',
            left: '0rpx',
            width: '668rpx',
            height: '668rpx',
            rotate: 0,
            borderRadius: 0,
          },
        },
        {
          type: 'image',
          url: '/longbing_card/resource/images/circle.png',
          css: {
            top: '622rpx',
            left: '211rpx',
            width: '257rpx',
            height: '57rpx',
            rotate: 0,
            borderRadius: 0,
          },
        },
        {
          type: 'image',
          url:prevPage.tmpShareData.logo,
          css: {
            top: '630rpx',
            left: '290rpx',
            width: '100rpx',
            height: '100rpx',
            rotate: 0,
            borderRadius: '100rpx',
          },
        },
        {
          type: 'text',
          text:prevPage.tmpShareData.name,
          css: {
            fontSize: '34rpx',
            top: '755rpx',
            left: '340rpx',
            color: '#313131',
            textDecoration: 'none',
            align: 'center',
            width: '670rpx',
          },
        },
        {
          type: 'text',
          text:prevPage.tmpShareData.job_name,
          css: {
            fontSize: '24rpx',
            top: '800rpx',
            left: '340rpx',
            color: '#9a9a9a',
            textDecoration: 'none',
            align: 'center',
            width: '670rpx',
          },
        },
        {
          type: 'text',
          text:prevPage.tmpShareData.companyName,
          css: {
            fontSize: '24rpx',
            top: '840rpx',
            left: '340rpx',
            color: '#9a9a9a',
            textDecoration: 'none',
            align: 'center',
            width: '670rpx',
          },
        },
        {
          type: 'text',
          text: '手机',
          css: {
            fontSize: '28rpx',
            top: '900rpx',
            left: '30rpx',
            color: '#838591',
            textDecoration: 'none',
            align: 'left',
            width: '100rpx',
          },
        },
        {
          type: 'text',
          text:prevPage.tmpShareData.phone,
          css: {
            fontSize: '28rpx',
            top: '900rpx',
            left: '100rpx',
            color: '#343541',
            textDecoration: 'none',
            align: 'left',
            width: '380rpx',
          },
        },
        {
          type: 'text',
          text: '微信',
          css: {
            fontSize: '28rpx',
            top: '940rpx',
            left: '30rpx',
            color: '#838591',
            textDecoration: 'none',
            align: 'left',
            width: '100rpx',
          },
        },
        {
          type: 'text',
          text:prevPage.tmpShareData.wechat,
          css: {
            fontSize: '28rpx',
            top: '940rpx',
            left: '100rpx',
            color: '#343541',
            textDecoration: 'none',
            align: 'left',
            width: '380rpx',
          },
        },
        {
          type: 'text',
          text: '地址',
          css: {
            fontSize: '28rpx',
            top: '980rpx',
            left: '30rpx',
            color: '#838591',
            textDecoration: 'none',
            align: 'left',
            width: '100rpx',
          },
        },
        {
          type: 'text',
          text:prevPage.tmpShareData.addrMore,
          css: {
            fontSize: '28rpx',
            top: '980rpx',
            left: '100rpx',
            color: '#343541',
            textDecoration: 'none',
            align: 'left',
            width: '350rpx',
          },
        },
        {
          type: 'image',
          url: prevPage.tmpShareData.qrImg,
          css: {
            top: '880rpx',
            left: '470rpx',
            width: '170rpx',
            height: '170rpx',
            rotate: 0,
            borderRadius: 0,
          },
        }
      ]
    }
    that.setData({
      template,
      to_uid,
      isIphoneX
    })
  },
  onReady: function () {
    // 页面渲染完成
    var that = this;
  },
  onShow: function () {
    // 页面显示
    var that = this;
  },
  onHide: function () {
    // 页面隐藏 
  },
  onUnload: function () {
    // 页面关闭 
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function (res) {
    // 用户点击右上角分_享 
  },
  onImgOK: function (e) {
    var that = this;
    that.setData({
      imagePath: e.detail.path
    })
    wx.hideLoading();
    console.log(e);
  },
  previewImage:function(){
    var that = this;
    var newImage = that.data.imagePath;
    var newImageUrls = [];
    newImageUrls.push(newImage)
    wx.previewImage({
			current: newImage,
			urls: newImageUrls
		})
  },
  toCopyRecord: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/copyRecord',
      'cachetime': '30', 
      'method': 'POST',
      'data': {
        type: 10,
        to_uid: to_uid
      },
      success: function (res) {
        // console.log("entry/wxapp/copyRecord ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'none',
            title: '名片保存成功，快去看看吧！',
            duration: 2000
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  saveImage() {
    var that = this;
    console.log("点击保存海报")
    wx.saveImageToPhotosAlbum({
      filePath: that.data.imagePath,
      success: function (res) {
        console.log("保存名片成功 ==>", res)
        if (app.globalData.to_uid != wx.getStorageSync("userid")) {
          that.toCopyRecord();
        } else if(app.globalData.to_uid == wx.getStorageSync("userid")){
          wx.showToast({
            icon: 'none',
            title: '名片保存成功，快去看看吧！',
            duration: 2000
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    });
  }
})