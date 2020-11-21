// yzkm_sun/pages/goodsDetails/goodsDetails.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    hideShopPopup: false,
    // goodsDetail: [                                                         //可删除数据
    //   {
    //     taname: "商品规格",
    //     tavalue: ["大", "中", "小", "大", "中", "小", "大", "中", "小"]
    //   }
    // ],
    shopprice:'',
    buyNumber:0,
    guige:'还未选择',
    // inventory:'',//库存
    banners: ["http://oydmq0ond.bkt.clouddn.com/shangpinxiangqing.png"],   //活数据可删
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setStorageSync('iid', options.id);
    console.log('获取当前商品Id');
    console.log(options.id);
    that.diyWinColor();
        app.util.request({
          'url': 'entry/wxapp/Url',
          success: function (res) {
            console.log('页面加载请求')
            console.log(res);
            wx.getStorageSync('url', res.data);
            that.setData({
              url: res.data,
            })
          }
        })
  },

//  点击选中规格
  labelItemTap:function(e){
    var that=this;
    console.log('规格');
    console.log(e);
    console.log( e.currentTarget.dataset.index);
    var currentIndex = e.currentTarget.dataset.index;
//     if('判断库存是否为0'){
// 是的话  购买数量为0
//     }else{
// 否者  购买数量为1
//     }
    that.setData({
      guige: e.currentTarget.dataset.item,
      currentIndex: e.currentTarget.dataset.index,
      })
  },
  // 购买数量
  // 减
  numJianTap:function(e){
    var that = this;
    // var inventory = e.currentTarget.dataset.inventory;
    console.log('减少');
    console.log(e);
    var buyNumber = that.data.buyNumber;
    
    if (buyNumber >=1){
      buyNumber--;
      that.setData({
        buyNumber: buyNumber,
      })
    }
  },
  // 加
  numJiaTap: function(e){
    var that=this;
    var inventory = e.currentTarget.dataset.inventory;
      console.log('增加');
      console.log(e);
      var buyNumber = that.data.buyNumber;
      buyNumber++;
      if (buyNumber>=inventory){
            that.setData({
              buyNumber: inventory,
            })
        }else{
            that.setData({
              buyNumber: buyNumber,
            })
        }
  },

  // 点击立即购买
  buyNow(e) {
    var that=this;
    console.log('立即购买');
    console.log(e);

    var buyNumber = that.data.buyNumber;//购买数量
    var guige = that.data.guige;//购买规格
    var iid = wx.getStorageSync('iid');//商品ID
    var openid = wx.getStorageSync('openid');//用户openid
    console.log(buyNumber);
    console.log(guige);
    console.log(iid);
    console.log(openid);
    wx.setStorageSync('buyNumber', buyNumber);
    // 规格不能为空
    if (guige == '') {
      wx.showToast({
        title: '规格不能为空',
        icon: 'none',
      })
      return false;
    }
    // 购买数量不能为空
    if (buyNumber==0){
      wx.showToast({
        title: '购买数量不能为空',
        icon: 'none',
      })
      return false;
      }
    // 库存不能为空
    if (e.currentTarget.dataset.inventory==0){
      wx.showToast({
        title: '库存不足',
        icon: 'none',
      })
      return false;
    }else{
      wx.navigateTo({
        // url: '../to-pay-order/to-pay-order',
        url: '../to-pay-order/to-pay-order?iid=' + iid + '&&openid=' + openid + '&&guige=' + guige + '&&buyNumber=' + buyNumber + '&&shopprice=' + that.data.shopprice,
      })
    }



  },
  /*自定义弹出下拉列表*/
  toBuy: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
    console.log(e);
  },
  close: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
  },
  util: function (currentStatu) {
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    });
    this.animation = animation;
    animation.opacity(0).height(0).step();
    this.setData({
      animationData: animation.export()
    })
    setTimeout(function () {
      animation.opacity(1).height('630rpx').step();
      this.setData({
        animationData: animation
      })
      if (currentStatu == "close") {
        this.setData(
          {
            hideShopPopup: false
          }
        );
      }
    }.bind(this), 200)
    
    if (currentStatu == "open") {
      var that=this;
      that.setData(
        {
          hideShopPopup: true
        }
      );
// 商品规格数据获取
      var iid = wx.getStorageSync('iid');//商品ID
      console.log('获取当前商品Id');
      console.log(iid); 
              app.util.request({
                'url': 'entry/wxapp/Doods_details',
                data: {
                    iid:iid,
                },
                success: function (res) {
                  console.log('商品数据请求');
                  console.log(res);
                  that.setData({
                    sp_guige: res.data,
                  })
                }
              })

      
    }
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that=this;
    var iid = wx.getStorageSync('iid');//商品ID
    console.log('获取当前商品Id');
    console.log(iid); 
          app.util.request({
            'url': 'entry/wxapp/Doods_details',
            // 'cachetime':'30',
            'data': { iid: iid },
            success: function (res) {
              console.log('商品信息详情');
              console.log(res);
              that.setData({
                sp_xx: res.data,
                shopprice: res.data.shopprice,
              })
            }
          })
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  },
  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '商品详情',
    })
  },
})