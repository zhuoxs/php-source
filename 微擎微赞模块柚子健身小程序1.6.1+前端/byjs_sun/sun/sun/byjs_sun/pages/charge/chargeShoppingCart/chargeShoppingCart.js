// byjs_sun/pages/charge/chargeShoppingCart/chargeShoppingCart.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    status:false,
    product:[
      {
        img:'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
        productNumber:1,
        cord:'蓝色',
        types:'XL',
        title:'上家肯定福建省看到了荆防颗粒胜多负少的',
        picer:89,
        status:false
      }
      ,
    ],
    total:0,
   
    
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this 
    
    that.getTotal()
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
    var shop = wx.getStorageSync('shop')
    //shop = Array(shop)
    that.setData({
      product:shop,
      red:shop.red
    })
  
  },
  // 计算总价
  getTotal:function(){
      var that = this 
      let goods = that.data.product
      let total = 0
      
      for (let i = 0; i < goods.length; i++) {
        if (goods[i].status==true){
          var num = Number(goods[i].productNumber)
          var price = Number(goods[i].picer)
          total += num * price;
        }
      }
      that.setData({
        total:total
      })
  },
  //数量加一
  addnum: function (e) {
    var that = this;
   
    let goods = that.data.product
    let num_index = e.currentTarget.dataset.index
    let num = goods[num_index].productNumber
    num = num+1
    goods[num_index].productNumber = num
   
    var index = e.currentTarget.dataset.index
    var datashop = wx.getStorageSync('shop')
    var dataIndex
    for (let i = 0; i < datashop.length; i++) {
      datashop[i].goods_id == goods[index].goods_id
      dataIndex = i
    }
    datashop[dataIndex].productNumber = num
    wx.setStorageSync('shop', datashop)


    that.getTotal()
    that.setData({
      product:goods
    })
    
  },
  //数量减一
  subbnum: function (e) {
    var that = this;
    let goods = that.data.product
    let num_index = e.currentTarget.dataset.index
    let num = goods[num_index].productNumber
    if (num == 1) {
      return false; wx.showModal({
        title: '提示',
        content: '是否删除?',
        success: function (res) {
          if (res.confirm) {
            wx.removeStorageSync('shop');
            wx.navigateBack({
            })
          } else {

          }
        }
      })
      
    }else{
      num = num - 1
    }
    goods[num_index].productNumber = num

    var index = e.currentTarget.dataset.index
    var datashop = wx.getStorageSync('shop')
    var dataIndex
    for (let i = 0; i < datashop.length; i++) {
      datashop[i].goods_id == goods[index].goods_id
      dataIndex = i
    }
    datashop[dataIndex].productNumber = num
    wx.setStorageSync('shop', datashop)


    that.setData({
      product: goods
    })
    that.getTotal()
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
  //自定义方法
  goYesOrder: function(){
    var that = this
    
    // if (that.data.status == true) {
    //   // 清楚原本缓存
    //  // wx.removeStorageSync('shop');
    //   var data = { 'money': that.data.total, 'img': that.data.product[0].img, 'types': that.data.product[0].types, 'productNumber': that.data.product[0].productNumber, 'picer': that.data.product[0].picer, 'red': that.data.product[0].red, 'goods_id': that.data.product[0].goods_id, 'freight': that.data.product[0].freight, 'goods_name': that.data.product[0].goods_name }

    //  

    //   wx.navigateTo({
    //     url: '/byjs_sun/pages/charge/chargeYesOrder/chargeYesOrder',
    //   })
    // } else {
    //   wx.showLoading({
    //     title: '请选择你想买的商品',
    //   })
    // }
    // setTimeout(function () {
    //   wx.hideLoading()
    // }, 2000)
    var product = that.data.product
    var newcar=[]
    for (var i = 0; i < product.length;i++){
      if (product[i].status==true){
        newcar.push(product[i])
      }
    }
    if (newcar.length==0){
      wx.showLoading({
        title: '请选择你想买的商品',
      })
    }else{
      wx.setStorageSync('newcar', newcar)
      wx.setStorageSync('newtotal', that.data.total)
      wx.navigateTo({
        url: '/byjs_sun/pages/charge/chargeYesOrder/chargeYesOrder',
      })
    }
    
    

 
  },
  //选框方法
  check: function(e){
    var that=this
    let total = that.data.total
    let index = e.currentTarget.dataset.index
    //把pm数组拿出来修改之后在塞回去
    let date = JSON.parse(JSON.stringify(this.data.product))
    console.log(that.data.product)
    if ((date[index].status) === true){
      date[index].status = false
      
    }else{
      date[index].status = true
      
    }
    this.setData({
      product:date
    })
    this.getTotal()
    console.log(that.data.product)
    
   
    //分辨全部是否选中，判断下面全选框的状态
    let i = 0
    let dateLen = date.length
    while (i < dateLen){
      if(date[i].status !== true){
        this.setData({
          status:false
        })
        return false
      }
      i++
    }
    this.setData({
      status:true
    })
  },
  allCheck: function(){
    var that  =this
    
    let statusA = this.data.status
    let data = JSON.parse(JSON.stringify(this.data.product))
    if(statusA === true){
      for (let i in data){
        data[i].status = false
      }
      that.setData({
        product: data,
        status:false
        
      })
      that.getTotal()
    }else{
      for(let i in data){
        data[i].status = true
      }
      that.setData({
        product: data,
        status: true
      })
      that.getTotal()
    }
  },
  // 跳转商品页
  gotobuy:function(e){
    
  
      wx.switchTab({
        url: '/byjs_sun/pages/charge/chargeIndex/chargeIndex',
      })
   
    
  },
  // 删除
  clear:function(res){
    var that=this
    var index = res.currentTarget.dataset.index
    var product = that.data.product
    var datashop = wx.getStorageSync('shop')
    var dataIndex
    for (let i = 0; i < datashop.length;i++){
      datashop[i].goods_id == product[index].goods_id
      dataIndex = i
    }
    wx.showModal({
      title: '提示',
      content: '是否删除?',
      success: function (res) {
        if (res.confirm) {
          product.splice(index, 1)
          datashop.splice(dataIndex, 1)
          wx.setStorageSync('shop', datashop)
          that.setData({
            product: product
          });
        } 
      }
    })
  }
  
})