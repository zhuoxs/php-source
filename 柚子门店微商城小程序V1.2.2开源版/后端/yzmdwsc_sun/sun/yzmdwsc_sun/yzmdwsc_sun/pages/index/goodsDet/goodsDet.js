// yzmdwsc_sun/pages/index/goodsDet/goodsDet.js
const app = getApp();
var tool = require('../../../../style/utils/countDown.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '商品详情',
    indicatorDots: false,
    autoplay: false,
    interval: 3000,
    duration: 800,
    showModalStatus: false,
    totalprice: 48.80,
    goods: [
      {
        id:22,
        imgUrls: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png'
        ],
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '48.80',
        oldPrice: '90.00',
        litnum: '40',
        endtime: '1526483891000',
        clock: '',
        freight: '免运费',
        detail: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png'
        ],
        goodsThumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png',
        /***规格 */
        spec: [
          {
            specName: '套餐类型',
            specValue: [{ name: '套餐1', status: '0' }, { name: '套餐2', status: '0' }, { name: '套餐3', status: '0' }, { name: '套餐4', status: '0' }],
            isChoose: false/***判断该属性是否被选择 */
          },
          {
            specName: '尺寸',
            specValue: [{ name: 'S', status: '0' }, { name: 'M', status: '0' }, { name: 'L', status: '0' }],
            isChoose: false
          }
        ],
        num:1,/**数量 */
        specConn: '',/**选定规格 */
        limit:999999,
        selected: false
      }
    ],
    curIndex: '0',
    specConn: '',/**选定规格 */
    comment: [
      {
        uname: '上善诺水',
        uface: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152159562425.png',
        cont: '保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞保洁阿姨服务认真，非常赞保洁阿姨服务认真，非常赞保洁阿姨服务认真',
        time: '2017-11-07 17:55'
      },
      {
        uname: '上善诺水',
        uface: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152159562425.png',
        cont: '保洁阿姨服务认真，非常赞',
        time: '2017-11-07 17:55'
      },
    ],
    guarantee: [
      '正品保障', '超时赔付', '7天无忧退货'
    ],
    num: 1,
    
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    var gid = options.gid;
   // var gid=32; 
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    that.setData({
      gid:gid,
    });
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })

    //---------------------------------- 异步保存上传图片需要的网址----------------------------------
/*    app.util.request({
      'url': 'entry/wxapp/Url2',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('url2', res.data)
      },
    })*/
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
    //----------获取商品详情----------
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        console.log(res)
        that.setData({
          goodinfo: res.data.data
        })
      }
    })

    /***倒计时 */
    var countDown = that.data.goods;/**传入的数组一定要有clock字段 */
    var clock = '';
    var cdInterval = setInterval(function () {
      for (var i = 0; i < countDown.length; i++) {
        var time = tool.countDown(that, countDown[i].endtime);/***第二个参数 结束时间 */
        if (time) {
          clock = time[0] + "天" + time[1] + ":" + time[3] + ":" + time[4];
        } else {
          clock = '00 : 00 : 00';
          clearInterval(cdInterval);
        }
        that.setData({
          clock: clock
        })
      }
    }, 1000)

    /**** 计算总价*/
    that.getTotalPrice();
    /****切分当前价格 */
    var price = that.data.goods[0].price

    var arrPrice = price.split(".");
    that.setData({
      arrPrice: arrPrice
    })
  },

  // 选择规格
  labelItemTap: function (e) {
    var that = this;
    var currentSelect = e.currentTarget.dataset.propertychildindex;
    if (!that.data.currentNamet){
      that.data.currentNamet='';
    }
    var specConn = e.currentTarget.dataset.propertychildname + that.data.currentNamet;
    that.setData({
      currentIndex: currentSelect,
      currentName: e.currentTarget.dataset.propertychildname,
      specConn: specConn,
    })
  },
  labelItemTaB: function (e) { 
    var that = this;
    var currentSelect = e.currentTarget.dataset.propertychildindex;
    if (!that.data.currentName){
      that.data.currentName='';
    }
    var specConn = that.data.currentName +' '+ e.currentTarget.dataset.propertychildname;
    that.setData({
      currentSel: currentSelect,
      currentNamet: e.currentTarget.dataset.propertychildname,
      specConn: specConn,
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
    var that=this;
    //获取商品评价
    app.util.request({
      'url': 'entry/wxapp/getPingjia',
      'cachetime': '0',
      data: {
        gid: that.data.gid,
      },
      success: function (res) {
        that.setData({
           pingjia:res.data,
        })
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
  /*  var goods = this.data.goods;
    var title = goods[0].title;
    if (res.from === 'button') {
      console.log(res.target)
    }
    return {
      title: title,
      path: '/page/user?id=123',
      success: function (res) {
        // 转发成功
      },
      fail: function (res) {
        // 转发失败
      }
    }*/
  },
  navTab(e) {
    const index = e.currentTarget.dataset.index;
    var that = this;
    that.setData({
      curIndex: index
    });
  },
  powerDrawer: function (e) {
    var that = this;
    var currentStatu = e.currentTarget.dataset.statu;
    var style = e.currentTarget.dataset.style;/***获取点击按钮是哪一个 */
    if (style) {
      console.log(style)
      that.setData({
        style: style
      })
    }
    that.util(currentStatu)

  },

  // 选择规格
 /* labelItemTap: function (e) {
    console.log(e);
    var that = this;
    var currentSelect = e.currentTarget.dataset.propertychildindex;
    that.setData({
      currentIndex: currentSelect,
      currentName: e.currentTarget.dataset.propertychildname,
    })
  },
  labelItemTaB: function (e) {
    console.log(e);
    var that = this;
    var currentSelect = e.currentTarget.dataset.propertychildindex;
    that.setData({
      currentSel: currentSelect,
      currentNamet: e.currentTarget.dataset.propertychildname,
    })
  },*/
  


  util: function (currentStatu) {
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    });
    this.animation = animation;
    animation.opacity(0).height(0).step();
    this.setData({
      animationData: animation.export()
    })
    setTimeout(function () {
      animation.opacity(1).height('724rpx').step();
      this.setData({
        animationData: animation
      })
      if (currentStatu == "close") {
        this.setData(
          {
            showModalStatus: false
          }
        );
      }
    }.bind(this), 200)
    if (currentStatu == "open") {
      this.setData(
        {
          showModalStatus: true
        }
      );
    }
  },
  /**选择规格 */
  chooseSpec(e) {
    var that = this;
    var goods = that.data.goods;
    var spec = goods[0].spec;
    var idx = e.currentTarget.dataset.idx;/**spec数组下标 */
    var index = e.currentTarget.dataset.index;
    var specConn = '';
    for (var i = 0; i < (goods[0].spec[idx].specValue).length; i++) {
      goods[0].spec[idx].isChoose = true;
      if (index == i) {
        goods[0].spec[idx].specValue[index].status = '1';
      } else {
        goods[0].spec[idx].specValue[i].status = '0';
      }
    }

    for (var j = 0; j < (goods[0].spec).length; j++) {
      for (var i = 0; i < (goods[0].spec[j].specValue).length; i++) {
        if (goods[0].spec[j].specValue[i].status == '1') {
          specConn += goods[0].spec[j].specValue[i].name + ' ';
        }
      }
    }
    that.setData({
      goods: goods,
      specConn: specConn
    })
  },
  /**增加 */
  addNum(e) {
    var that = this;
    const num = e.currentTarget.dataset.index;
    var numb = parseInt(num) + 1;
    if (numb > 100) {
      numb = 99;
    }
    this.setData({
      num: numb
    });
    that.getTotalPrice()
  },
  reduceNum(e) {
    var that = this;
    const index = e.currentTarget.dataset.index;
    var numb = parseInt(index) - 1;
    if (numb < 1) {
      numb = 1;
    }
    this.setData({
      num: numb
    });
    that.getTotalPrice();
  },
  /**计算总价 */
  getTotalPrice() {
    var that = this;
    var num = parseFloat(that.data.num);
    var group = that.data.goods
    var totalprice = (group[0].price * num).toFixed(2);

    that.setData({
      totalprice: totalprice
    });
  },

  /**表单提交 */
  formSubmit(e) {
    var that = this;
    var gid = e.currentTarget.dataset.gid;
  /*  if (!that.data.currentIndex) {
      var currentNamet = '';
    } else {
      var currentNamet = that.data.currentNamet;
    }*/
    if (that.data.goodinfo.spec_name != '' && that.data.goodinfo.spec_names != '') {
      if (!that.data.currentName || !that.data.currentNamet) {
        wx.showModal({
          title: '提示',
          content: '请选择商品规格！',
          showCancel: false
        })
        return;
      } 
    }else if(that.data.goodinfo.spec_name != ''){
      if (!that.data.currentName) {
        wx.showModal({
          title: '提示',
          content: '请选择商品规格！',
          showCancel: false
        })
        return;
      } 

    }else if(that.data.goodinfo.spec_names != ''){
      if (!that.data.currentNamet) {
        wx.showModal({
          title: '提示',
          content: '请选择商品规格！',
          showCancel: false
        })
        return;
      } 
    }
    //限制条件 检测商品
    app.util.request({
      'url': 'entry/wxapp/checkGoods',
      'cachetime': '0',
      data: {
        gid: gid,
        num: that.data.num,
      },
      success: function (res) {
        var style = that.data.style;/**按钮点击类型 */
        var currentName=that.data.currentName;
        var currentNamet = that.data.currentNamet;
        var num = that.data.num;
        wx.setStorage({
          key: 'order',
          data: {
            spec: currentName,
            spect: currentNamet,
            num: num,
          }
        })
        if(style==1){
          wx.getStorage({
            key: 'openid',
            success: function (res) {
              app.util.request({
                'url': 'entry/wxapp/AddShopCart',
                'cachetime': '0',
                data: {
                  uid: res.data,
                  gid: gid,
                  num: num,
                  spec_value: currentName, 
                  spec_value1: currentNamet,
                  gname: e.currentTarget.dataset.gname,
                  price: e.currentTarget.dataset.price,
                  pic: e.currentTarget.dataset.pic,
                },
                success: function (res) {
                  console.log(res)
                  if (res.data.errno == 0) {
                    wx.showToast({
                      title: '加入购物车成功',
                      icon: 'success',
                      duration: 2000
                    })
                  }
                }
              })
            }
          })

        }else if(style==2){
          wx.navigateTo({
            url: '../cforder/cforder?gid=' + gid,
          })
        }
      }
    })

    return 
    const spec = that.data.specConn;/***商品规格字符串 */
    var style = that.data.style;/**按钮点击类型 */
    const goods = that.data.goods;
    var num=that.data.num;/**获取当前数量 */
    var specArr = goods[0].spec;
    var flag = true;
    var specConn = that.data.specConn;
    goods[0].specConn = specConn;
    /**判断是否选择了规格 */
    for (var i = 0; i < specArr.length; i++) {
      if (specArr[i].isChoose == false) {
        flag = false;
        break;
      }
    }

    if (!flag) {
      wx: wx.showModal({
        title: '',
        content: '请选择商品规格',
        showCancel: false,
        success: function (res) { },
      })
    } else {
      /**对数量先赋值 */
      goods[0].num=num;
      /***提交开团或支付 */
      if (style == 1) {
        console.log('加入购物车')
        try {
          const carts = wx.getStorageSync('carts') || [];

          /***判断是否已加入购物车 */
          for(var i=0;i<carts.length;i++){
            if (goods[0].id == carts[i].id && goods[0].specConn == carts[i].specConn){
              carts[i].num+=num;
              wx.setStorageSync('carts', carts);
              wx.showToast({
                title: '加入购物车成功',
                icon: 'success',
                duration: 2000
              })
              console.log(carts);
              return;
            }
          }
          carts.push(goods[0]);
          wx.setStorageSync('carts', carts);

          wx.showToast({
            title: '加入购物车成功',
            icon: 'success',
            duration: 2000
          })
          console.log(carts);
        } catch (e) {
          // Do something when catch error
          wx.showToast({
            title: '加入购物车失败',
            icon: 'none',
            duration: 2000
          })
        }

      } else if (style == 2) {
        console.log('立即购买')
        wx: wx.navigateTo({
          url: '../cforder/cforder',
        })
      }
    }

  },
  toIndex(e) {
    wx: wx.redirectTo({
      url: '../index',
    })
  }
})