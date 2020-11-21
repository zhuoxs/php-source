// byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goodInfo:'',
    indexx:0,
    indexxx:0,
    indexxx2: 0,
   
    numvalue:1,
    selectlist:[],
    selectsize: [],
    goStatus:'add',   //区别添加到购物车还是直接购买，add购物车，go直接购买
    shoppingWindow:false,   //弹出的确认串口
    lb_imgs:[],
    goods_price:'',
    red:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
  
   
    // -----------拿能量包
    var redPacket = wx.getStorageSync('total')
    that.setData({
      red:Number(redPacket)
    })
    //---------------------------------- 异步保存上传图片需要的网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url2',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('url2', res.data)
      },
    })
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
    let id = options.id;
    let goods_price = options.goods_price;
    app.util.request({
      'url':'entry/wxapp/GoodsDetails',
      'data':{'id':id},
      'cachetime':30,
      success:function(res){
        console.log(res);
        that.setData({
              goodInfo:res.data.data,
              lb_imgs:res.data.data.lb_imgs,
              goods_price:goods_price,
              selectsize:res.data.data.spec_value,
              selectlist:res.data.data.spec_name,
              indexxxx: res.data.data.spec_value[0],
              selectsize2: res.data.data.spec_values,
              selectlist2: res.data.data.spec_names,
              indexxxx2: res.data.data.spec_values[0],
              
        })
      }
    })
    
  },

  //选择规则
  choosesize: function (e) {
    var that = this;
    var indexxx = e.currentTarget.dataset.num
    var indexxxx = e.currentTarget.dataset.index
    that.setData({
      indexxx: indexxx,
      indexxxx: indexxxx
    });
  },
  choosesize2: function (e) {
    var that = this;
    var indexxx2 = e.currentTarget.dataset.num
    var indexxxx2 = e.currentTarget.dataset.index
    that.setData({
      indexxx2: indexxx2,
      indexxxx2: indexxxx2
    });
  },
  //数量加一
  addnum: function (e) {
    var that = this;
    let nowvalue=this.data.numvalue+1
    that.setData({
      numvalue: nowvalue
    });
  },
  //数量减一
  subbnum: function (e) {
    var that = this;
    let nowvalue = this.data.numvalue
    if (this.data.numvalue>1){
      nowvalue= this.data.numvalue - 1
    }
    that.setData({
      numvalue: nowvalue
    });
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
  //自定义事件
  //这里预判他点击的时候是添加到购物车还是直接购买
  addShoppingCart: function(e){
    
    let thisStatus = e.currentTarget.dataset.stat
    this.setData({
      goStatus:thisStatus,
      shoppingWindow:true
    })
  },
  //关闭弹出窗口
  closeShoppingWindow: function(){
    this.setData({
      shoppingWindow: false
    })
  },
  //确认下单
  goProductInfo: function(e){
    var that = this
    var shop = wx.getStorageSync('shop')
    var ddddd=[]
    var len = shop.length
    var pushBtn  

    if (typeof (that.data.goods_price) == 'undefined') {
      
      var data = { 'indexId': len + 1, 'types': that.data.indexxxx + " , " + that.data.indexxxx2, 'productNumber': that.data.numvalue, 'picer': that.data.goodInfo.goods_price, 'img': that.data.goodInfo.imgs, 'red': that.data.red, 'goods_id': that.data.goodInfo.id, 'freight': that.data.goodInfo.freight, 'goods_name': that.data.goodInfo.goods_name }   
    }else{
      
      var data = { 'indexId': len + 1, 'types': that.data.indexxxx + " , " + that.data.indexxxx2, 'productNumber': that.data.numvalue, 'picer': that.data.goods_price, 'img': that.data.goodInfo.imgs, 'red': that.data.red, 'goods_id': that.data.goodInfo.id, 'freight': that.data.goodInfo.freight, 'goods_name': that.data.goodInfo.goods_name }
    }
    if (this.data.goStatus === 'add') {
      if (shop.length==0) {
        ddddd.push(data)
        wx.setStorageSync('shop', ddddd)
      }else{
      
        ddddd=shop
      
        for (var i = 0; i < len;i++){
          if (ddddd[i].goods_id == that.data.goodInfo.id) {
            ddddd[i].productNumber = ddddd[i].productNumber + that.data.numvalue
            pushBtn=true
          } 
        }
        if (pushBtn == true){
          wx.setStorageSync('shop', ddddd)
        }else{
          ddddd.push(data) 
          wx.setStorageSync('shop', ddddd)
        }
      }
      wx.showToast({
        title: '添加成功',
        icon: 'success',
        duration: 2000
      })
     
    }else{
      wx.setStorageSync('shopnow', data)
      wx.navigateTo({
        url: '/byjs_sun/pages/charge/chargeYesOrder/chargeYesOrder',
      })
    }
    that.closeShoppingWindow()
    // if(shop !='' ){
    //   wx.showModal({
    //     title: '失败',
    //     content: '请先清空你的购物车',
    //     success:function(res){
    //       if(res.confirm){
    //         wx.navigateTo({
    //           url: '/byjs_sun/pages/charge/chargeShoppingCart/chargeShoppingCart',
    //         })
    //       }    
    //     }
    //   })
    // }
    // else{
    //   shop.push(data)
    //   wx.setStorageSync('shop', data)
    //   wx.navigateTo({
    //     url: '/byjs_sun/pages/charge/chargeShoppingCart/chargeShoppingCart',
    //   })
    //   }
    
    
    //如果是购物车点过来的话
    // if (this.data.goStatus === 'add'){
    //   //到购物车去
    //   wx.navigateTo({
    //     url: '/byjs_sun/pages/charge/chargeShoppingCart/chargeShoppingCart',
    //   })
    // }else{
    //   //到确认订单
    //   
    // }
  },
  goCar:function(e){
    wx.setStorageSync('shopnow', '')
    wx.navigateTo({
      url: '/byjs_sun/pages/charge/chargeShoppingCart/chargeShoppingCart',
    })
  }
})