var app = getApp(); 
import util from '../../../resource/js/xx_util.js';
import { userModel } from '../../../resource/apis/index.js'
Page({
  data: {
    globalData: {},
    paramShop: {
      page: 1,
      type_id: 0
    },
    refreshShop: false,
    loadingShop: true,
    shop_all: {
      page: 1,
      total_page: '',
      list: []
    },
    showMoreStatus: '',
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    wx.hideShareMenu();
    util.showLoading(); 
    var tmpData = {};
    var paramShop = that.data.paramShop;
    var tmpNav = wx.getStorageSync("navTypes");

    if (options.keyword) {
      tmpData.keyword = options.keyword
    }
    if (options.all_categoryid) {
      tmpData.all_categoryid = options.all_categoryid
    }
    if (options.status == 'all') {
      tmpData.categoryid = options.all_categoryid;
      paramShop.type_id = options.all_categoryid;
      tmpData.activeIndex = '100000101';
    } else if (options.status == 'nav') {
      tmpData.categoryid = options.id;
      paramShop.type_id = options.id;
      for (let i in tmpNav.sec) {
        if (options.id == tmpNav.sec[i].id) {
          tmpData.activeIndex = i;
        }
      }
    }
    if (tmpNav) {
      tmpData.navTypes = tmpNav
    }
    that.setData({
      tmpData: tmpData,
      paramShop: paramShop,
      globalData: app.globalData,
      scrollNav: 'scrollNav' + tmpData.categoryid
    })
    if (that.data.tmpData.keyword) {
      that.getShopSearch();
    } else {
      that.getShopList(); 
    } 
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
    wx.removeStorageSync("navTypes");
  },
  onUnload: function () {
    // 页面关闭
    wx.removeStorageSync("navTypes");
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    var that = this;
    that.setData({
      refreshShop: true,
      'paramShop.page': 1,
      refreshShop: false,
      loadingShop: true,
    }, function () {
      wx.showNavigationBarLoading();
      that.getShopList();
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
    let that = this;
    that.setData({
      refreshShop : false
    })
    let { loadingShop } = that.data;
    let { page, total_page } = that.data.shop_all;
    if (page != total_page && !loadingShop) {
      that.setData({
        'paramShop.page': parseInt(page) + 1,
        refreshShop: true,
        loadingShop: true
      })
      that.getShopList();
    }
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  onPageScroll: function (e) {
    // console.log("监听页面滚动", e); 
  },
  getShopSearch: function () {
    var that = this;
    let paramObj = {
      keyword: that.data.tmpData.keyword
    }
    userModel.getShopSearch(paramObj).then((d) => {
      util.hideAll();
      console.log(d.data)
      let shop_all = {
        page:1,
        total_page:1,
        list: d.data
      } 
      let loadingShop = false;
      let refreshShop = false;
      that.setData({
        shop_all,
        loadingShop,
        refreshShop,
      })
    })
  },
  getShopList: function () {
    var that = this;
    let { refreshShop, paramShop, shop_all } = that.data;
    if(refreshShop){
      util.showLoading();
    }
    // util.showLoading();
    userModel.getShopList(paramShop).then((d) => {
      let oldlist = shop_all;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refreshShop) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      that.setData({
        shop_all: newlist,
        loadingShop: false,
        refreshShop: false,
      })
    })
  }, 
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var type = e.currentTarget.dataset.type;
    var id = e.currentTarget.dataset.id;
    var index = e.currentTarget.dataset.index;
    var categoryid = e.currentTarget.dataset.categoryid;


    if (status == 'toCopyright') {
      app.util.goUrl(e)
    }


    if (status == 'toShowMore') {
      var showMoreStatus = that.data.showMoreStatus;
      if (type == 0) {
        console.log("显示更多")
        showMoreStatus = 1;
      } else if (type == 1) {
        console.log("隐藏显示更多")
        showMoreStatus = 0;
      }
      that.setData({
        showMoreStatus: showMoreStatus
      })
    } else if (status == 'toTabClickMore' || status == 'toTabClick') {
      console.log("全部 || 类别选择", index)

      var categoryid = e.currentTarget.dataset.categoryid;
      var tmpIndex = index;
      var tmpCategoryid = categoryid;
      if (status == 'toTabClickMore') {
        tmpIndex = '100000101';
        tmpCategoryid = 'All';
      }
      that.setData({
        'tmpData.activeIndex': tmpIndex,
        'tmpData.categoryid': categoryid,
        scrollNav: 'scrollNav' + tmpCategoryid,
        shop_all: [],
        'paramShop.page': 1,
        'paramShop.type_id': categoryid,
        refreshShop: true
      })
      that.getShopList();
    } else if (status == 'toShopDetail') {
      console.log("商品详情")
      app.util.goUrl(e)
    }
  }
})