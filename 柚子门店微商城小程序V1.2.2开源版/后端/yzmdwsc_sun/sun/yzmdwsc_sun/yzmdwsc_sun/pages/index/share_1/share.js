// yzmdwsc_sun/pages/index/share/share.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '分享',
    classify: ['综合', '最新', '推荐'],
    curIndex:0,
    shareList:[
      {
        title: '发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽',
        bgSrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png',
        shareprice: '0.15',
      },
      {
        title: '发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽',
        bgSrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png',
        shareprice: '0.15',
      },
      {
        title: '发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽',
        bgSrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png',
        shareprice: '0.15',
      }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarTitle({
      title: that.data.navTile
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
  /**导航切换 */
  navChange(e) {
    var that = this;
    const index = parseInt(e.currentTarget.dataset.index);

    /***请求其他分类 */
    that.setData({
      curIndex: index,
    })
   
  },
  toSharedet(e){
    wx: wx.navigateTo({
      url: '../shareDet/shareDet',
    })
  }
})