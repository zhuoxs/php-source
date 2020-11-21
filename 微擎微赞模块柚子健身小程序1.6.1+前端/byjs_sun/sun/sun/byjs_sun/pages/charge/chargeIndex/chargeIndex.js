var tool = require('../../../../we7/js/countDown.js');
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    scrollBtn: true,
    navImg: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
    nav: [

    ],
    fight1: [

    ],
    fight2: [

    ],
    type_name: '',
    //以下是倒计时的东西
    endTimeOut: null,
    countDownTime: {
      h: '00',
      s: '00',
      m: "00",
      d: "00"
    },
    endTime: '2018-04-12 12:00:00',
    bargainList: [
      {
        endTime: '1527519898765',
        clock: ''
      },
      {
        endTime: '1521519898765',
        clock: ''
      }
    ],
    // 限时抢购商品
    goods: [],
    tabBarList: [


    ]
  },
  scrollBtnFalse: function () {
    this.setData({
      scrollBtn: false
    })
  },
  scrollBtnTrue: function () {
    this.setData({
      scrollBtn: true
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
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
    // 获取底部图标
    app.util.request({
      'url': 'entry/wxapp/Tab',
      'cachetime': 30,
      success: function (res) {
        var data1 = [{
          state: false,
          url: 'goIndex',
          publish: false,
          text: res.data.data.index,
          iconPath: res.data.data.indeximg,
          selectedIconPath: res.data.data.indeximgs,
        },
        {

          state: true,
          url: 'goChargeIndex',
          publish: false,
          text: res.data.data.coupon,
          iconPath: res.data.data.couponimg,
          selectedIconPath: res.data.data.couponimgs,
        },
        {
          state: false,
          url: 'goPublishTxt',
          publish: true,
          text: res.data.data.fans,
          iconPath: res.data.data.fansimg,
          selectedIconPath: res.data.data.fansimgs,
        },
        {
          state: false,
          url: 'goFindIndex',
          publish: false,
          text: res.data.data.find,
          iconPath: res.data.data.findimg,
          selectedIconPath: res.data.data.findimgs,
        },
        {
          state: false,
          url: 'goMy',
          publish: false,
          text: res.data.data.mine,
          iconPath: res.data.data.mineimg,
          selectedIconPath: res.data.data.mineimgs,
        },
        ]
        // 是否显示
        app.util.request({

          'url': 'entry/wxapp/SwitchBar',
          'cachetime': 0,
          success: function (res) {
            // console.log(res.data.is_fbopen+'sss')
            let is_fbopen = res.data.is_fbopen
            if (is_fbopen == "0") {
              data1.splice(2, 2)
              that.setData({
                tabBarList: data1
              })
            }else{
              that.setData({
                tabBarList: data1
              })
            }

          }
        })

      }
    })
    // 轮播图
    app.util.request({
      'url': 'entry/wxapp/Banner',
      'cachetime': '30',
      // 成功回调
      success: function (res) {
        console.log(res.data)
        that.setData({
          bannerList: res.data.lb_imgs

        })

      },
    })
    //----------获取年度热销单品(全部)列表-----------
    app.util.request({
      'url': 'entry/wxapp/GoodList',
      'cachetime': '0',
      success: function (res) {
        console.log(res)
        that.setData({
          fight1: res.data
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
          nav: res.data
        })
      }
    })
    // --------------获取类别显示商品-----------
    app.util.request({
      'url': 'entry/wxapp/TypeShow',
      'cachetime': 0,
      success: function (res) {
        that.setData({
          fight2: res.data[0],
          type_name: res.data.type_name
        })
      }
    })

    // ----------获取限时抢购商品--------
    app.util.request({
      'url': 'entry/wxapp/GoodsDiscount',
      'cachetime': 30,
      success: function (res) {
        console.log("进入抢购");
        console.log(res.data);
        var goods = res.data;
        // that.setData({
        //   goods: res.data,
        // })
        
        //var goods = goods_all
        var clock = '';
     //   var countDown = that.data.goods;/**传入的数组一定要有clock字段 */

     
        var cdInterval = setInterval(function () {
          for(var i=0;i<goods.length;i++){
            goods[i].clock='';
         
            var endtime = goods[i].endtime.replace(/(-)/g, '/');
           
            var times = (new Date(endtime)).getTime();
          
            var time = tool.countDown(that, times);/***第二个参数 结束时间 */
            
            if (time) {
              goods[i].clock = time[0] + '天' + time[1] + "时" + time[3] + "分" + time[4] + "秒";
            } else {
              goods[i].clock = '已经截止';
            }
            that.setData({
              goods: goods
            })
          }
        }, 1000)
      }
    })
    /**砍价倒计时 */

  },
  goIndex: function (e) {
    wx.redirectTo({
      url: '../../product/index/index'
    })
  },
  goChargeIndex: function (e) {
    wx.redirectTo({
      url: '../../charge/chargeIndex/chargeIndex'
    })
  },
  goPublishTxt: function (e) {
    wx.redirectTo({
      url: '../../publishInfo/publish/publishTxt'
    })
  },
  goFindIndex: function (e) {
    wx.redirectTo({
      url: '../../find/findIndex/findIndex'
    })
  },
  goMy: function (e) {
    wx.redirectTo({
      url: '../../myUser/my/my'
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    //这里是暂时丢的方法，数据过来的可以移动到回调里面使用
    let Time = this.data.endTime
    this.countdown(Time);

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
  goUrl: function (e) {
    console.log(e);
    let type_id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=' + type_id,
    })
  },
  //跳转到商品详情 --- 限时抢购
  goProductInfo: function (e) {
    let id = e.currentTarget.dataset.id
    let goods_price = e.currentTarget.dataset.goods_price
    wx.navigateTo({
      url: '/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=' + id + '&goods_price=' + goods_price,
    })
  },
  goType: function (e) {
    let id = e.currentTarget.dataset.id
    wx: wx.navigateTo({
      url: '/byjs_sun/pages/charge/equipment/equipment?id=' + id,
    })
  },
  //
  goInfo: function (e) {
    let id = e.currentTarget.dataset.id
    wx: wx.navigateTo({
      url: '/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=' + id,
    })
  },
  //这里写一个倒计时方法，套的时候直接用
  countdown: function (endTime) {
    //时间获取并且对比
    console.log(new Date().getTime());
    console.log((new Date(endTime)).getTime())
    //结束时间
    let allEndTime = new Date(endTime).getTime();
    //当前时间
    let thisTime = new Date().getTime();
    //如果结束时间小于当前时间,则不执行
    if (allEndTime < thisTime) {
      clearInterval(this.data.endTimeOut);
      this.data.endTimeOut = null
      return false
    }
    //否则进行倒计时计算
    this.setCountDown(allEndTime)
    let self = this
    let set = setInterval(function () {
      try {
        self.setCountDown(allEndTime)
      } catch (e) {
        console.log(e);
        //clearInterval(self.countDown);
        clearInterval(self.data.endTimeOut)
      }
    }, 1000)
  },
  //进行倒计时方法放置计算

  //进行剩余时间计算
  setCountDown: function (allEndTime) {
    let thisTime = new Date().getTime();
    let showTime = allEndTime - thisTime;

    let h = parseInt(showTime / (1000 * 60 * 60));
    let d = parseInt(h / 24);
    h = h % 24;
    let m = parseInt((showTime % (1000 * 60 * 60)) / (1000 * 60));
    let s = parseInt((showTime % (1000 * 60 * 60)) % (1000 * 60) / 1000);
    if (h < 10) {
      h = "0" + h;
    }
    if (m < 10) {
      m = "0" + m;
    }
    if (s < 10) {
      s = "0" + s;
    }
    let countDownTime = {
      h: h,
      m: m,
      s: s,
      d: d
    }
    this.setData({
      countDownTime: countDownTime
    })
  },

})