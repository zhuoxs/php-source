// yzmdwsc_sun/pages/shop/shop.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '商店',
    banner:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png',
    announcement:[
      {
        title:'全店包邮',
        src:'../../../style/images/icon1.png'
      },
      {
        title: '先行赔付',
        src: '../../../style/images/icon2.png'
      },
      {
        title: '七天无忧退款',
        src: '../../../style/images/icon3.png'
      }
    ],
    classify: ['全部', '玫瑰', '康乃馨', '花器', '混合包月', '薰衣草', '薰衣草', '薰衣草'],
    curIndex:0,
    newList: [
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
    ],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    app.editTabBar();  /**渲染tab */
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
    //获取当前路径
    var pages = getCurrentPages() //获取加载的页面
    var currentPage = pages[pages.length - 1] //获取当前页面的对象
    var current_url = currentPage.route;
    console.log('当前路径为:' + current_url);
    that.setData({
      current_url: current_url,
    })

    var tab = wx.getStorageSync('tab');
    var settings=wx.getStorageSync('settings');
    console.log(settings)
    var url = wx.getStorageSync('url');
    console.log(settings.shop_banner)
    console.log(options.currentIndex)
    this.setData({ 
      current: options.currentIndex,
      tab: tab,
      url:url,
      settings:settings,
    })



  
    //----------获取全部商品列表-----------
  /*  app.util.request({
      'url': 'entry/wxapp/goodList',
      'cachetime': '0',
      success: function (res) {
        console.log(res)
        that.setData({
          goodList: res.data
        })
      }
    })*/
    
    //获取商品
    var tid = options.tid;
    if(tid==undefined){
      tid=0;
    }
    that.setData({
      curIndex: tid
    })
    app.util.request({
      'url': 'entry/wxapp/TypeGoodList',
      'cachetime': '0',
      data: {
        tid: tid
      },
      success: function (res) {
        that.setData({
          goodList: res.data
        })
      }
    }) 
   



    //----------获取分类TAB--------
    app.util.request({
      'url': 'entry/wxapp/Type',
      'cachetime': '0',
      success: function (res) {
        console.log(res)
        that.setData({
          typeData: res.data
        })
      }
    })







  },

  //底部链接
  goTap: function (e) {
    console.log(e);
     var that = this;
    that.setData({
      current: e.currentTarget.dataset.index
    })
 
    if (that.data.current == 0) {
      wx.redirectTo({
        url: '../index/index?currentIndex=' + 0,
      })
    }; 
    if (that.data.current == 1) {
      wx.redirectTo({
        url: '../shop/shop?currentIndex=' + 1,
      })
    }; 
    if (that.data.current == 2) {
      wx.redirectTo({
        url: '../active/active?currentIndex=' + 2,
      })
    }; 
    if (that.data.current == 3) {
      wx.redirectTo({
        url: '../carts/carts?currentIndex=' + 3,
      })
    }; 
    if (that.data.current == 4) {
      wx.redirectTo({
        url: '../user/user?currentIndex=' + 4,
      })
    }; 

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
  navChange(e){
    var that=this;
    const index = parseInt(e.currentTarget.dataset.index);
    var tid = parseInt(e.currentTarget.dataset.id);
    that.setData({
      curIndex: index
    })
    app.util.request({
      'url': 'entry/wxapp/TypeGoodList',
      'cachetime': '0',
      data: {
        tid: tid
      },
      success: function (res) {
        console.log(res)
        that.setData({
          goodList: res.data
        })
      }
    }) 

  },
  toGoodsdet(e) {
    var gid=parseInt(e.currentTarget.dataset.id);
    wx: wx.navigateTo({
      url: '../index/goodsDet/goodsDet?gid='+gid,
    })
  },
  toTab(e) {
    var url = e.currentTarget.dataset.url;
    url = '/' + url;
    wx.redirectTo({
      url: url,
    })
  },
})