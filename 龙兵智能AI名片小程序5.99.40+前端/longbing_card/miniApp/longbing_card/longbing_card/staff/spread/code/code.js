
var app = getApp(); 
Page({
  imagePath: '',
  data: {
    id: '',
    template: {},
    name: '',
    avatar: '',
    qrImg: '',
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log("onLoad ==>", this);
    var that = this;
    wx.hideShareMenu();
    app.util.showLoading(4); 
    var tmpID = options.id;
    var tmpName = options.name;
    var tmpAvatar = options.avatar;
    var isIphoneX = app.globalData.isIphoneX;
    let tmp_shareParamObj = {tmpID,tmpName,tmpAvatar,isIphoneX};
    that.toGetQR(tmpID,tmpName,tmpAvatar,isIphoneX);
    that.setData({
      tmp_shareParamObj
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
    let that = this;
    wx.showNavigationBarLoading();
    let {tmpID,tmpName,tmpAvatar,isIphoneX} = that.data.tmp_shareParamObj;
    that.toGetQR(tmpID,tmpName,tmpAvatar,isIphoneX);
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function (res) {
    // 用户点击右上角分_享 
  },
  toGetQR: function (tmpID,tmpName,tmpAvatar,isIphoneX) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/releaseQrDetailV2',
      // 'url': 'entry/wxapp/releaseQrDetail',
      'cachetime': '30',
      'hideLoading': false,
      'method': 'POST',
      'data': {
        id: tmpID
      },
      success: function (res) {
        console.log("获取二维码 entry/wxapp/releaseQrDetail ==>", res)
        if (!res.data.errno) {
          var tmpDataCode = res.data.data;
          var tmpMore = '';
          if(tmpDataCode.content.length > 88){
            tmpMore = '...';
          }
          tmpDataCode.content = tmpDataCode.content.slice(0,88) + tmpMore;

          let template = {
            width: '670rpx',
            height: '840rpx',
            background: '#ffffff',
            borderRadius: '0rpx',
            views: [ 
              {
                type: 'rect',
                css: {
                  top: '0rpx',
                  left: '0rpx',
                  color: '#faf8f5',
                  borderRadius: 0,
                  borderWidth: 0,
                  width: '670rpx',
                  height: '293rpx',
                },
              },
              {
                type: 'image',
                url: tmpAvatar,
                css: {
                  top: '44rpx',
                  left: '22rpx',
                  width: '92rpx',
                  height: '92rpx',
                  rotate: 0,
                  borderRadius: '92rpx',
                },
              },
              {
                type: 'text',
                text: tmpName,
                css: {
                  fontSize: '30rpx',
                  top: '65rpx',
                  left: '130rpx',
                  color: '#2b2b2b',
                  textDecoration: 'none',
                  align: 'left',
                  width: '540rpx'
                },
              },
              {
                type: 'text',
                text: tmpDataCode.content,
                css: {
                  fontSize: '28rpx',
                  top: '155rpx',
                  left: '26rpx',
                  color: '#333333',
                  textDecoration: 'none',
                  align: 'left',
                  width: '610rpx',
                },
              },
              {
                type: 'image',
                url: tmpDataCode.path,
                css: {
                  top: '363rpx',
                  left: '142rpx',
                  width: '396rpx',
                  height: '396rpx',
                  rotate: 0,
                  borderRadius: 0,
                },
              }
            ]
          }
          that.setData({
            template,
            isIphoneX
          })

        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
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
  saveImage() {
    var that = this;
    console.log("点击保存海报")
    wx.saveImageToPhotosAlbum({
      filePath: that.data.imagePath,
      success: function (res) {
        console.log("保存自定义码成功 ==>", res)
        wx.showToast({
            icon: 'none',
            title: '自定义码保存成功，快去看看吧！' ,
            duration : 2000
        })
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    });
  }
})