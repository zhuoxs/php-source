// byjs_sun/pages/charge/chargeYesOrder/chargeYesOrder.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    product: [
     
     
    ],
    userName:'',
    totalPrice:'',
  },
  onLoad: function (options) {

      var that = this
      // --------------------------获取url-----------------------
      app.util.request({
        'url': 'entry/wxapp/Url',
        'cachetime': '30',
        success: function (res) {
          // ---------------------------------- 异步保存网址前缀----------------------------------
          wx.setStorageSync('url', res.data)
          that.setData({
            url: res.data
          })
        },
      })
      //var goods = wx.getStorageSync('new')
      var goods = wx.getStorageSync('shopnow')
       goods = Array(goods)
       var totalPrice = goods[0].picer * goods[0].productNumber 
      var total =wx.getStorageSync('total')||0
      console.log(goods)
      console.log(goods)
      console.log(totalPrice)
      console.log(total)
      if (goods==''){
        goods = wx.getStorageSync('newcar')
         totalPrice = wx.getStorageSync('newtotal')
         console.log(totalPrice)
      }
     
      
      
     // var totalPrice = goods.picer*goods.productNumber
      
      var freight=0 //一开始默认为0
      for (var i = 0; i < goods.length;i++){
        if (goods[i].freight>0){
           freight = Number(goods[i].freight) 
          if (freight < goods[i].freight){
            freight = Number(goods[i].freight) 
          }
        }
      }
      
     var  lasttotalPrice = totalPrice + freight
     
     if (total >= totalPrice) {
       lasttotalPrice = freight
     } else {
       lasttotalPrice = totalPrice - total + freight 
     }
     
      freight =freight.toFixed(2)
      totalPrice = Number(totalPrice).toFixed(2)
      lasttotalPrice = lasttotalPrice.toFixed(2)


     // wx.setStorageSync('total', total)
      that.setData({
        product: goods,
        total:total,
        totalPrice: totalPrice,
        freight: freight,
        lasttotalPrice: lasttotalPrice
      })
      console.log(this.data.product)
      
      
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
//  自定义方法
  yesOrder: function(){
    console.log(111111+'这是断点')
    var that = this
    if (that.data.userName !=''){
      var goods = that.data.product
      var user_id = wx.getStorageSync('users').id
      var goodsId = []
      var goodsName = []
      var goodsImg 
      var goodsPrice = []
      var goodsNum = []
      for (var i = 0; i < goods.length; i++) {
        goodsId.push(goods[i].goods_id)
        goodsName.push(goods[i].goods_name)
        goodsImg=goods[i].img
        goodsPrice.push(goods[i].picer)
        goodsNum.push(goods[i].productNumber)
      }
      //-----------付款---------------
      wx.getStorage({
        key: 'openid',
        success: function (res) {
          console.log(111111 + '这是断点1')
          var openid = res.data;
          var price = that.data.lasttotalPrice
          app.util.request({
            'url': 'entry/wxapp/Orderarr',
            'cachetime': '30',
            data: {
              price: price,
              openid: openid,
            },
            success: function (res) {
             
              console.log(res)
             // var goods = wx.getStorageSync('new')
              var user_id = wx.getStorageSync('users').id
              console.log('-----直接购买=------')
              console.log(wx.getStorageSync('shopnow') == '','就是购物车过来的')
              
              if (wx.getStorageSync('shopnow') == '') {
                console.log(goodsId)
                var carlist = wx.getStorageSync('shop')
                console.log(carlist)
                var newcarlist=[]
                for (var i = 0; i < carlist.length;i++){
                  for (var j = 0; j < goodsId.length;j++){
                    if (goodsId[j] == carlist[i].goods_id){
                      carlist.splice(i,1)     
                    }
                   }
                }
                wx.setStorageSync('shop', carlist)
              }

              app.util.request({
                'url': 'entry/wxapp/Order',
                'cachetime': '0',
                data: {
                  'user_id': user_id,
                  'money': price,
                  'user_name': that.data.userName,
                  'tel': that.data.telNumber,
                  'good_id': goodsId,
                  'good_name': goodsName,
                  'good_img': goodsImg,
                  'good_money': goodsPrice,
                  'good_num': goodsNum,
                  'address': that.data.provinceName + that.data.cityName + that.data.countyName + that.data.detailInfo
                },
                success: function (o) {
                  console.log(o.data)
                  var order_id = o.data;
                  console.log(res)
                  wx.requestPayment({
                    'timeStamp': res.data.timeStamp,
                    'nonceStr': res.data.nonceStr,
                    'package': res.data.package,
                    'signType': 'MD5',
                    'paySign': res.data.paySign,
                    'success': function (result) {
                    
                      wx.showToast({
                        title: '支付成功',
                        icon: 'success',
                        duration: 2000
                      })
                      app.util.request({
                        'url': 'entry/wxapp/PayOrder',
                        'cachetime': '0',
                        data: {
                          order_id: order_id,
                        },
                        success: function (res) {
                          var that = this
                        
                          console.log('ssss')
                          var t = wx.getStorageSync('total')
                          if (t > that.data.totalPrice) {
                            t = t - that.data.totalPrice
                          } else {
                            t = that.data.totalPrice - t
                            t = t.toFixed(2)
                          }
                          wx.removeStorageSync('total')
                          wx.setStorageSync('total', t)
                          wx.removeStorageSync('new')
                        }
                      })
                      wx.switchTab({
                        url: '../../index/index',
                      })

                    },
                    'fail': function (result) {
                    }
                  });
                }
              })

            }
          })
        },
      })

    }else{
      console.log(2)
      // wx.showLoading({
      //   title: '请填写地址',
      // })
      // setTimeout(function(){
      //     wx.hideLoading(),5000
      // })
      wx.showModal({
        title: '提示',
        content: '请填写地址',
        success: function (res) {
          if (res.confirm) {
            console.log('用户点击确定')
          } else if (res.cancel) {
            console.log('用户点击取消')
          }
        }
      })
    } 
   
   
    
    
  },
  /**
 * 我的收货地址
 */
  myAddress: function () {
    var that = this
    wx.chooseAddress({
      success: function (res) {
        that.setData({
          userName: res.userName,
          postalCode: res.postalCode,
          provinceName: res.provinceName,
          cityName: res.cityName,
          countyName: res.countyName,
          detailInfo: res.detailInfo,
          nationalCode: res.nationalCode,
          telNumber: res.telNumber
        })
        
      }
    })
  },
  //去填写收货地址
  goAddress: function(){
    wx.navigateTo({
      url: '/byjs_sun/pages/charge/chargeAddressReceipt/chargeAddressReceipt',
    })
  }
  
})
