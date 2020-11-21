// yzmdwsc_sun/pages/user/groupdet/groupdet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goods: {
      img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
      title: '发财树绿萝栀子花海棠花卉盆栽',
      price: '2.50',
      oldprice: '3.00',
      num: '3',/**当前参与 */
      userNum: 5,
      status: 2,
      spec: [
        {
          specName: '套餐类型',
          specValue: [{ name: '套餐', status: '0' }, { name: '套餐', status: '0' }, { name: '套餐', status: '0' }, { name: '套餐', status: '0' }, { name: '套餐', status: '0' }, { name: '套餐', status: '0' }, { name: '套餐', status: '0' },],
          isChoose: false/***判断该属性是否被选择 */
        },
        {
          specName: '尺寸',
          specValue: [{ name: 'S', status: '0' }, { name: 'M', status: '0' }, { name: 'L', status: '0' }],
          isChoose: false
        }
      ],
    },
    showModalStatus:false,
    specConn: '',/**选定规格 */
    num:1,
    guarantee: [
      '正品保障', '超时赔付', '7天无忧退货'
    ],
    user: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg']
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
    var order_id = options.order_id;
    var openid = wx.getStorageSync('openid');
    //order_id = 89;
    that.setData({
      order_id: order_id,  
    })
    console.log('获取拼单详情')  
    app.util.request({
      'url': 'entry/wxapp/getGroupsDetail',
      'cachetime': '0',
      data: {
        order_id: order_id,
        openid: openid,
      },
      success: function (res) {
        console.log(res.data.data.goodsdetail)
        that.setData({
          groupsdetail: res.data.data
        })
      }
    })
    that.urls()

    return 
    let goods = that.data.goods,
      user = that.data.user;
    for (var i = 0; i < (goods.userNum - goods.num); i++) {
      user.push('../../../../style/images/nouser.png')
    }
    that.setData({
      user: user
    })
    /**** 计算总价*/
    that.getTotalPrice()
  },

  urls: function () {
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
  },

  // 选择规格
  labelItemTap: function (e) {
    var that = this;
    var currentSelect = e.currentTarget.dataset.propertychildindex;
    if (!that.data.currentNamet) {
      that.data.currentNamet = '';
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
    if (!that.data.currentName) {
      that.data.currentName = '';
    }
    var specConn = that.data.currentName + ' ' + e.currentTarget.dataset.propertychildname;
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
  toGrouppro(e) {
    wx.navigateTo({
      url: '../groupPro/groupPro',
    })
  },
  powerDrawer: function (e) {
    var that = this;
    var currentStatu = e.currentTarget.dataset.statu;
    that.util(currentStatu)

  },
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
    var spec = goods.spec;
    var idx = e.currentTarget.dataset.idx;/**spec数组下标 */
    var index = e.currentTarget.dataset.index;
    var specConn = '';
    for (var i = 0; i < (goods.spec[idx].specValue).length; i++) {
      goods.spec[idx].isChoose = true;
      if (index == i) {
        goods.spec[idx].specValue[index].status = '1';
      } else {
        goods.spec[idx].specValue[i].status = '0';
      }
    }

    for (var j = 0; j < (goods.spec).length; j++) {
      for (var i = 0; i < (goods.spec[j].specValue).length; i++) {
        if (goods.spec[j].specValue[i].status == '1') {
          specConn += goods.spec[j].specValue[i].name + ' ';

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
    var totalprice = group.price * num;

    that.setData({
      totalprice: totalprice
    });
  },
  /**提交订单 */
  formSubmit(e){
    var that = this;
    var gid = e.currentTarget.dataset.gid;
    if (that.data.groupsdetail.goodsdetail.spec_name != '' && that.data.groupsdetail.goodsdetail.spec_names != '') {
      if (!that.data.currentName || !that.data.currentNamet) {
        wx.showModal({
          title: '提示',
          content: '请选择商品规格！',
          showCancel: false
        })
        return;
      }
    } else if (that.data.groupsdetail.goodsdetail.spec_name != '') {
      if (!that.data.currentName) {
        wx.showModal({
          title: '提示',
          content: '请选择商品规格！',
          showCancel: false
        })
        return;
      }

    } else if (that.data.groupsdetail.goodsdetail.spec_names != '') {
      if (!that.data.currentNamet) {
        wx.showModal({
          title: '提示',
          content: '请选择商品规格！',
          showCancel: false
        })
        return;
      }
    }
    //判断拼团清空
    app.util.request({
      'url': 'entry/wxapp/isGroups',
      'cachetime': '0',
      data: {
        order_id: that.data.order_id,
      },
      success: function (res) {

        var currentName = that.data.currentName;
        var currentNamet = that.data.currentNamet;
        var num = that.data.num;
        wx.setStorage({
          key: 'order-groupjoin',
          data: {
            spec: currentName,
            spect: currentNamet,
            num: num,
          }
        })
        wx.navigateTo({
          url: '../cforder-groupjoin/cforder-groupjoin?order_id=' + that.data.order_id,
        }) 

      }
    })

    return  
    const spec = that.data.specConn;/***商品规格字符串 */
    const goods = that.data.goods;
    let specArr = goods.spec;
    let flag = true;
    
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
      /***提交开团或支付 */
      wx: wx.navigateTo({
        url: '../cforder/cforder',
      })
      
    }

  }
})