// yzkm_sun/pages/classDetails/classDetails.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    showModalStatus: false,
    curIndex: 0,
    classicData: ["打听事", "求帮助",],
  },

  /**
   * 生命周期函数--监听页面加载
   */
 
  onLoad: function (options) {
    var that = this;
    that.calculWidth();
  },
  tabClick(e) {
    var curIndex = e.currentTarget.dataset.index;
    this.setData({
      curIndex: curIndex,
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
  // 跳转圈子详情页面
  toCircleDetails(e) {
    wx.navigateTo({
      url: '../circle/details/details',
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
  // 计算顶部标题宽度的方法
  calculWidth: function (e) {
    console.log(this.data.classicData.length)
    var wid = "width"
    var nowid = "min-width"
    if (this.data.classicData.length > 3) {
      this.setData({
        limit: nowid
      })
    } else {
      calWidth: wid
    }
  }
})