// yzkm_sun/pages/mine/collect/collect.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentIndex: 0,
    showModalStatus: false,
    currentTab: 0,
    statusType:['收藏的圈子','收藏的商家'],
    light:'',
    kong:'',
    num:5,
    hadImg:true,
    // dqyh_id:'',//当前用户id

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var openid = wx.getStorageSync('openid');//用户openid
    console.log('..............................................')
    console.log(openid)
    var that = this
    console.log('接收页面数据')
    console.log(openid)
    //情况一:展示后台给的星级评分  
    that.setData({
      light: that.data.num,
      kong: 5 - that.data.num
    })  
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        // console.log('页面加载请求')
        console.log(res);
        wx.getStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    })
    // 转换用户openid为id
    app.util.request({
      'url': 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        // that.setData({
        //  dqyh_id: res.data.id,
        // })
        wx.setStorageSync('dqyh_id', res.data.id);
      }
    }) 
 

    that.diyWinColor();
  },

  // 点击切换tab栏
  statusTap(e) {
    var that=this
    console.log(e);
    var dqyh_id = wx.getStorageSync('dqyh_id');//用户openid   
    // var dqyh_id = that.data.dqyh_id;
    that.setData({
      currentIndex: e.currentTarget.dataset.index
    })

    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success: function (res) {
        var latitude = res.latitude
        var longitude = res.longitude

        app.util.request({
          'url': 'entry/wxapp/Mine_sc',
          data: {
            dqyh_id: dqyh_id,
            currentIndex: e.currentTarget.dataset.index,
            latitude: latitude,
            longitude: longitude,
          },
          success: function (res) {
            console.log('商家数据请求');
            console.log(res);

            that.setData({
              list: res.data,
            })
          }
        })
      }
    })
          // app.util.request({
          //   'url': 'entry/wxapp/Mine_sc',
          //   'data': {
          //     dqyh_id: dqyh_id,
          //      currentIndex: e.currentTarget.dataset.index
          //       },
          //   success: function (res) {
          //     console.log('请求方法');
          //     console.log(res);

          //   }
          // })
  },

  // 跳转收藏的圈子详情页面
  toCircleDetails(e) {
    console.log('跳转圈子详情页id')
    console.log(e)
    var fabu_yh_id = e.currentTarget.dataset.id;
    var fabu_yh_dele_sta = e.currentTarget.dataset.dele_sta;
    if (fabu_yh_dele_sta == 2) {
      wx.showToast({
        title: '该收藏已被删除或下架',
        icon: 'none',
      })
      return false;
    }
    wx.navigateTo({
      url: '../../circle/details/details?id=' + fabu_yh_id,
    })
  },
  // 跳转收藏的上商家详情页面
  toSellerDeatils(e) {
    console.log('跳转商家详情页id')
    console.log(e)
    var fabu_sj_id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../../seller/details/details?id=' + fabu_sj_id,
    })
  },
  /*自定义弹出下拉列表*/
  writeComments: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
    console.log(e);

  },
  close: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
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
      animation.opacity(1).height('630rpx').step();
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

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that=this
    // 点击收藏进来时默认显示收藏的圈子
    var user_id = wx.getStorageSync('user_id');//当前用户id
    console.log('当前用户id')
    console.log(user_id)
    // console.log(currentIndex)
    if (this.data.currentIndex==1){
      app.util.request({
        'url': 'entry/wxapp/Mine_sc',
        data: {
          dqyh_id: user_id,//当前用户的id
          currentIndex:1
        },
        success: function (res) {
          console.log('收藏的圈子');
          console.log(res);
          that.setData({
            list: res.data,
            // currentIndex: 0
          })
        }
      })     
    } else{
      console.log(777);
      app.util.request({
        'url': 'entry/wxapp/Mine_sc',
        data: {
          dqyh_id: user_id,//当前用户的id
          currentIndex: 0
        },
        success: function (res) {
          console.log('收藏的圈子');
          console.log(res);
          that.setData({
            list: res.data,
            // currentIndex: 0
          })
        }
      })     
    }

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

  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '我的收藏',
    })
  },
})