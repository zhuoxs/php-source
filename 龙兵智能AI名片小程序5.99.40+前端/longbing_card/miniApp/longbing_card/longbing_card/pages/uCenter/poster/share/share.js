
var app = getApp();
// var getAppGlobalData = require('../../../templates/copyright/copyright.js');

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
    var isIphoneX = app.globalData.isIphoneX; 
    var nameLen = parseInt(prevPage.post_user.name.length + 2) * 30 ;
    var jobNameLen = parseInt(prevPage.post_user.job_name.length + 2) * 20 + 'rpx';

    wx.hideShareMenu();
    let template = {
      width: '641rpx',
      height: '1066rpx',
      background: '#ffffff',
      views: [ 
        {
          type: 'image',
          url: prevPage.currentPoster,
          css: {
            top: '0rpx',
            left: '0rpx',
            width: '641rpx',
            height: '855rpx',
            rotate: 0,
            borderRadius: 0,
          },
        },
        {
          type: 'rect',
          css: {
            top: '855rpx',
            left: '0rpx',
            color: '#ffffff',
            borderRadius: 0,
            borderWidth: 0,
            width: '641rpx',
            height: '214rpx',
          },
        }, 
        {
          type: 'image',
          url: prevPage.post_user.avatar_2,
          css: {
            top: '905rpx',
            left: '45rpx',
            width: '85rpx',
            height: '85rpx',
            rotate: 0,
            borderRadius: '5rpx',
          },
        },
        {
          type: 'text',
          text: prevPage.post_user.name,
          css: {
            fontSize: '29rpx',
            top: '915rpx',
            left: '150rpx',
            color: '#222222',
            textDecoration: 'none',
            align: 'left',
            width: nameLen + 'rpx',
          },
        },
        {
          type: 'text',
          text: prevPage.post_user.job_name,
          css: {
            fontSize: '20rpx',
            top: '925rpx',
            left: (nameLen + 100) + 'rpx',
            color: '#676767',
            textDecoration: 'none',
            align: 'left',
            width: jobNameLen,
          },
        },
        {
          type: 'text',
          text: prevPage.post_company.name,
          css: {
            fontSize: '20rpx',
            top: '957rpx',
            left: '150rpx',
            color: '#676767',
            textDecoration: 'none',
            align: 'left',
            width: '300rpx',
          },
        },
        {
          type: 'text',
          text:'Tel '+prevPage.post_user.phone,
          css: {
            fontSize: '20rpx',
            top: '1011rpx',
            left: '45rpx',
            color: '#676767',
            textDecoration: 'none',
            align: 'left',
            width: '330rpx',
          },
        }, 
        {
          type: 'image',
          url: prevPage.post_user.qr_path,
          css: {
            top: '891rpx',
            left: '470rpx',
            width: '112rpx',
            height: '112rpx',
            rotate: 0,
            borderRadius: '0rpx',
          },
        },
        {
          type: 'text',
          text: '长按识别 访问名片',
          css: {
            fontSize: '20rpx',
            top: '1016rpx',
            left: '441rpx',
            color: '#323232',
            textDecoration: 'none',
            align: 'left',
            width: '200rpx',
          },
        },
      ]
    }
    that.setData({
      template,
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
  changeImage:function(){
    wx.navigateBack();
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