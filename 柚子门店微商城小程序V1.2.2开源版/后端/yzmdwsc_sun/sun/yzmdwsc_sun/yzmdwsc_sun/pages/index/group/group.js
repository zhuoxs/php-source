// yzmdwsc_sun/pages/index/group/group.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '拼团',
    classify: ['综合', '最新', '推荐'],
    curIndex: 0,
    goodsList: [
      {
        title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
        price: '399.00',
        groupNum: 6,
        userNum: 2,
        discount: 20
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00',
        groupNum: 6,
        userNum: 2,
        discount: 20
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00',
        groupNum: 6,
        userNum:2,
        discount:20
      }
    ],
    show: '0',
    priceFlag: true,
    remind:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542355884.png'
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });

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

    //获取砍价商品
    app.util.request({
      'url': 'entry/wxapp/getGroupGoods',
      'cachetime': '0',
      success: function (res) {
        that.setData({
          goodList: res.data
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
  onShareAppMessage: function () {

  },
  /**导航切换 */
  navChange(e) {
    var that = this;
    const index = parseInt(e.currentTarget.dataset.index);

    if (index == 3) {
      var flag = e.currentTarget.dataset.flag;
      that.setData({
        priceFlag: flag
      })

      if (!flag) {
        /*** 价格向上 */
        console.log('上');
      } else {
        /*** 价格向下*/
        console.log('下');
      }
      that.setData({
        show: 1,
        curIndex: index,
      })
    } else {
      /***请求其他分类 */
      that.setData({
        show: 0,
        curIndex: index,
        priceFlag: true
      })
    }

    //获取拼团商品
    app.util.request({
      'url': 'entry/wxapp/getGroupGoods',
      'cachetime': '0',
      data: {
        index: index,
        flag: flag
      },
      success: function (res) {
        var countDown = res.data;
        that.setData({
          goodList: countDown
        })
      }
    })
  },
  toGroupdet(e) {
    var gid = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: '../groupDet/groupDet?gid=' + gid,
    })
  }
})