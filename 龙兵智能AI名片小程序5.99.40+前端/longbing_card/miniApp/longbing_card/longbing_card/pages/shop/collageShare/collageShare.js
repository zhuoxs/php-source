
var app = getApp(); 
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'

Page({
  imagePath: '',
  data: {
    template: {}, 
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    wx.hideShareMenu();
    setTimeout(() => {
      app.util.showLoading(4);
    }, 300);
    var company_name;
    getApp().getConfigInfo().then(() => {
      that.setData({ 
        globalData: app.globalData
      }, function () {
        company_name = that.data.globalData.configInfo.my_company.name; 
        if(company_name.length > 20){
          if(that.data.globalData.configInfo.my_company.short_name){
            company_name = that.data.globalData.configInfo.my_company.short_name;
          } 
        }
      })
    })


    var currPage = getCurrentPages();
    var prevPage = currPage[currPage.length - 2].__viewData__; 
    console.log('prevPage',prevPage)

    var tmpShare = prevPage.shareParamObj;
    if(tmpShare.name.length > 18){
      tmpShare.name = tmpShare.name.substr(0,18) +"..."
    } 

    var tmpShare2 = prevPage.shareParamObj2;
    var priceLen = parseInt(tmpShare2.price.length) * 22;
    var peopleLen = parseInt(tmpShare2.people.length) * 22;
 
    var tmpPriceLen = priceLen +'rpx';
    var tmpPriceLength = parseInt(priceLen + 45) +'rpx';
    var tmpPeopleLength = parseInt(peopleLen + 70) +'rpx'; 
    var isIphoneX = app.globalData.isIphoneX;

    wx.hideShareMenu();
    setTimeout(() => {
      
    let template = {
      width: '612rpx',
      height: '987rpx',
      background: '#e1e1e1',
      views: [ 
        {
          type: 'image',
          url: '/longbing_card/resource/images/icon-productBg.png',
          css: {
            top: '0rpx',
            left: '0rpx',
            width: '612rpx',
            height: '82rpx',
            rotate: 0,
            borderRadius: 0,
          },
        },
        {
          type: 'text',
          text: company_name,
          css: {
            fontSize: '28rpx',
            top: '10rpx',
            left: '306rpx',
            color: '#ffffff',
            bold:'bold',
            textDecoration: 'none',
            align: 'center',
            width: '572rpx',
          },
        }, 
        {
          type: 'rect',
          css: {
            top: '82rpx',
            left: '0rpx',
            color: '#ffffff',
            borderRadius: '0rpx', 
            width: '612rpx',
            height: '97rpx',
          },
        },
        {
          type: 'text',
          text: tmpShare.name,
          css: {
            fontSize: '30rpx',
            top: '78rpx',
            left: '20rpx',
            color: '#313131',
            bold:'bold',
            textDecoration: 'none',
            align: 'left',
            width: '572rpx',
          },
        },
        {
          type: 'text',
          text: '￥',
          css: {
            fontSize: '24rpx',
            top: '130rpx',
            left: '20rpx',
            color: '#e93636',
            bold:'bold',
            textDecoration: 'none',
            align: 'left',
            width: '20rpx',
          },
        },
        {
          type: 'text',
          text: tmpShare2.price,
          css: {
            fontSize: '36rpx',
            top: '120rpx',
            left: '48rpx',
            color: '#e93636',
            bold:'bold',
            textDecoration: 'none',
            align: 'left',
            width: tmpPriceLen,
          },
        },
        {
          type: 'text',
          text: tmpShare2.people + '人拼团',
          css: {
            fontSize: '24rpx',
            top: '130rpx',
            left: tmpPriceLength,
            color: '#e93636',
            bold:'bold',
            textDecoration: 'none',
            align: 'left',
            width: tmpPeopleLength,
          },
        },  
        {
          type: 'text',
          text: '已拼' + tmpShare.collage_count + '件',
          css: {
            fontSize: '24rpx',
            top: '130rpx',
            right: '20rpx',
            color: '#313131',
            bold:'bold',
            textDecoration: 'none',
            align: 'right',
            width: '680rpx',
          },
        }, 
        {
          type: 'image',
          url: tmpShare.cover2,
          css: {
            top: '187rpx',
            left: '9rpx',
            width: '594rpx',
            height: '594rpx',
            rotate: 0,
            borderRadius: 0,
          },
        }, 
        {
          type: 'rect',
          css: {
            top: '786rpx',
            left: '2rpx',
            color: '#ffffff',
            borderRadius: '5rpx', 
            width: '612rpx',
            height: '200rpx',
          },
        },
        {
          type: 'image',
          url: tmpShare.qr,
          css: {
            top: '808rpx',
            left: '78rpx',
            width: '158rpx',
            height: '158rpx',
            rotate: 0,
            borderRadius: 0,
          },
        },  
        {
          type: 'text',
          text: '长按识别小程序码',
          css: {
            fontSize: '30rpx',
            top: '850rpx',
            left: '300rpx',
            color: '#313131',
            bold:'bold',
            textDecoration: 'none',
            align: 'left',
            width: '300rpx',
          },
        }, 
        {
          type: 'text',
          text: '超值好货一起拼',
          css: {
            fontSize: '24rpx',
            top: '900rpx',
            left: '300rpx',
            color: '#313131',
            bold:'bold',
            textDecoration: 'none',
            align: 'left',
            width: '300rpx',
          },
        }, 
      ]
    }

    that.setData({
      template,
      isIphoneX
    })
  }, 3000);


  
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
  saveImage() {
    var that = this;
    console.log("点击保存海报")
    wx.saveImageToPhotosAlbum({
      filePath: that.data.imagePath,
      success: function (res) {
        console.log("保存拼团海报成功 ==>", res) 
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    });
  }
})