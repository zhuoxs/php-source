
var app = getApp();
import util from '../../../../resource/js/xx_util.js';
import { baseModel, bossModel } from '../../../../resource/apis/index.js'
Page({
  data: {
    dataList: {
      page: 1,
      total_page: '',
      list: []
    },
    refresh: false,
    loading: true,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    let {id,status} = options;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData,
        id: id,
        status: status
      }, function () {
        that.toGetClientList();
      })
    })
  },
  onReady: function () {
    // console.log("页面渲染完成") 
  },
  onShow: function () {
    // 页面显示  
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")  
    let that = this;
    app.globalData.configInfo = false;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData
      }, function () {
        that.setData({
          refresh: true,
          dataList: {
            page: 1,
            total_page: '',
            list: []
          },
        }, function () {
          wx.showNavigationBarLoading();
          that.toGetClientList();
        })
      })
    })
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底")
    let that = this;
    let { loading } = that.data;
    let { page, total_page } = that.data.dataList;
    if (page != total_page && !loading) {
      that.setData({
        'dataList.page': parseInt(page) + 1,
        loading: false
      }, function () {
        that.toGetClientList();
      })
    }
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  },
  toGetClientList: function () {
    var that = this;
    let { refresh, id, dataList } = that.data;
    let paramObj = {
      page: parseInt(dataList.page),
      staff_id: id,
    }
    if (!refresh) {
      util.showLoading();
    }
    bossModel.getClientList(paramObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      that.setData({
        dataList: newlist,
        refresh: false, 
      })
    })
  },
  toJump: function (e) {
    let that = this;
    let { status } = util.getData(e);
    if (status == 'toJumpUrl') {
      util.goUrl(e);
    }
  },
})