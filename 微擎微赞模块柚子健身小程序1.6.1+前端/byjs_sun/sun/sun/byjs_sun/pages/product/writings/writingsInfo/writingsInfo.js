// byjs_sun/pages/product/writings/writingsInfo/writingsInfo.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goods_id:'',
    centText: [],
    aid:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log(options)
    let id = options.id;
    var goods_id = options.goods_id;
    var that = this;
    that.setData({
      'goods_id':goods_id,
      'aid':id
    })
    app.util.request({
      'url':'entry/wxapp/GoodsArticle',
      'data':{'id':id},
      success:function(e){
        that.setData({
          centText:e.data.article,  
        })
      }
    })

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
  onShareAppMessage: function (res) {
    var that = this
    let id = that.data.aid
    let goods_id = that.data.goods_id
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res.target)
    }
    return {
      title: '文章推荐',
      path: '/pages/charge/chargeProductInfo/chargeProductInfo?id=' + id + '&goods_id=' + goods_id,
      desc: '最好的健身小程序',
      success: function (res) {
        // 转发成功
      },
      fail: function (res) {
        // 转发失败
      }
    }
  },
  //自定义事件
  goProductInfo: function (e) {
    var goods_id =this.data.goods_id
    if(goods_id == 0){
      wx.showModal({
        title: '提示',
        content: '商品还未上架',
        
      })
    }else{
      let id = e.currentTarget.dataset.id;
      wx.navigateTo({
        url: '/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=' + id,
      })
    }
  
  }
})