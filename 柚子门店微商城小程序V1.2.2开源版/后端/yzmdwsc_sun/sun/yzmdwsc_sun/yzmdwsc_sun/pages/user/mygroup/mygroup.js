// yzmdwsc_sun/pages/user/mygroup/mygroup.js
const app = getApp();
var tool = require('../../../../style/utils/countDown.js');
var cdInterval;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我的拼团',
    curIndex: 0,
    nav: ['拼团中', '已拼成','拼团失败'],
    /**正在砍价 */
    curBargain: [
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1',
        userNum: 2,
        endtime: '1526483891000',
        clock: ''
      },
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1',
        userNum: 2,
        endtime: '1526483891000',
        clock: ''
      },
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1',
        userNum: 2,
        endtime: '1526483891000',
        clock: ''
      }
    ],
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
    var url = wx.getStorageSync('url');
    this.setData({
      url: url,
    })
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
    var that = this;
    var openid = wx.getStorageSync('openid');
    //获取砍价信息
    app.util.request({
      'url': 'entry/wxapp/getUserGroups',
      'cachetime': '0',
      data: {
        openid: openid,
        index: that.data.curIndex
      },
      success(res) {
        var countDown = res.data;/**传入的数组一定要有clock字段 */
        cdInterval = setInterval(function () {
          for (var i = 0; i < countDown.length; i++) {
            var time = tool.countDown(that, countDown[i].endtime);/***第二个参数 结束时间 */
            if (time) {
              countDown[i].clock = time[2] + " : " + time[3] + " : " + time[4];
            } else {
              countDown[i].clock = '00 : 00 : 00';
              //  clearInterval(cdInterval);
            }
            that.setData({
              groups: countDown
            })
          }
        }, 1000)

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
  onShareAppMessage: function (res) {
    if (res.from === 'button') {
      var order_id = res.target.dataset.order_id;
      var gname = res.target.dataset.gname;
      return {
        title: gname,
        path: 'yzmdwsc_sun/pages/index/groupjoin/groupjoin?order_id=' + order_id,
        success: function (res) {
          console.log('转发成功') 
        },
        fail: function (res) {
          console.log('转发失败')
        }
      }
    }
  },
  bargainTap(e) {
    var index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
    var that = this;
    var openid = wx.getStorageSync('openid');
    //获取砍价信息
    app.util.request({
      'url': 'entry/wxapp/getUserGroups',
      'cachetime': '0',
      data: {
        openid: openid,
        index: that.data.curIndex
      },
      success(res) {
        clearInterval(cdInterval);
        console.log(111111);
        that.setData({
          groups:res.data,
        })
        clearInterval(cdInterval);
        if(index==0){ 
          var countDown = res.data;/**传入的数组一定要有clock字段 */
          cdInterval = setInterval(function () {
            for (var i = 0; i < countDown.length; i++) {
              var time = tool.countDown(that, countDown[i].endtime);/***第二个参数 结束时间 */
              if (time) {
                countDown[i].clock = time[2] + " : " + time[3] + " : " + time[4];
              } else {
                countDown[i].clock = '00 : 00 : 00';
              }

              that.setData({
                groups: countDown
              })
            }
          }, 1000)
        }else{
          that.setData({
            groups: res.data
          })
        }
      }
    })
  },
  toBuy(e) {
    /**支付 */
    var gid = e.currentTarget.dataset.gid;
    wx.navigateTo({
      url: '../../index/goodsDet/goodsDet?gid=' + gid,
    })
  },
  togroupdet(e){
   var order_id=e.currentTarget.dataset.order_id;
   wx.navigateTo({
     url: '../groupdet/groupdet?order_id=' + order_id,
   })
  },
  /**删除订单 */
  toCancel(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var curBargain = that.data.curBargain;
    wx:wx.showModal({
      title: '提示',
      content: '订单删除后将不再显示',
      success:function(res){
        if(res.confirm){
          curBargain.splice(index, 1);
          that.setData({
            curBargain: curBargain
          })
        }
      }
    })
  }
})