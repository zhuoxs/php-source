var app = getApp()

Page({
  data: {
    Unchanged: [],
    lists: [],
    addsInput:'',
    clickIndex: '0',
  },
  //获取常用标签
  oftenLabel:function(){
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/oftenLabel',
      'cachetime': '30',
     
      'method': 'POST',
      'data': {},
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          that.setData({
            Unchanged: res.data.data
          })
        }
      }
    })
  },
  //获取用户标签
  Labels:function(){
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Labels',
      'cachetime': '30',
     
      'method': 'POST',
      'data': {
        target_id: that.data.id
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          that.setData({
            lists: res.data.data
          })
        }
      }
    })
  },
  onLoad: function(options) {
    app.util.showLoading(1);
    wx.hideShareMenu();
    if (options.id) {
      this.setData({
        id: options.id,
        globalData: app.globalData
      })
    }
    this.oftenLabel()
    this.Labels()
    wx.hideLoading();
    // 页面初始化 options为页面跳转所带来的参数 
  },
  return1: function(e) {
    var that = this;
    if(that.data.addsInput){
      that.getInsertLabel();
    } else {
      wx.navigateBack({
        delta: 1
      })
    }
  },
  //添加标签
  bindinput:function(e){
    var that = this;
    console.log("bindinput",e)
    that.setData({
      addsInput: e.detail.value
    })
  },
  bindbulr:function(e){
    console.log("失去焦点，",e)
    var that = this;
    that.getInsertLabel();
  },
  blur_addsInput: function(e) {
    // console.log(e,"添加标签添加标签添加标签添加标签添加标签")
    var that = this;
    that.getInsertLabel();
  },
  getInsertLabel:function(){
    var that = this;
    let lists = that.data.lists;
    if(!that.data.addsInput){
      wx.showToast({
        icon:'none',
        title:'请填写标签!',
        duration: 2000
      })
      return false;
    } else {
      app.util.request({
        'url': 'entry/wxapp/insertLabel',
        'cachetime': '30',
       
        'method': 'POST',
        'data': {
          target_id: that.data.id,
          label: that.data.addsInput
        },
        success: function(res) {
          // console.log("entry/wxapp/formid ==>", res)
          if (!res.data.errno) {
            that.setData({
              addsInput: ''
            })
            that.Labels()
          }
        }
      }) 
    }
  },
  //点击谁  谁右上角出现删除按钮
  lableclick: function(e) {
    let index = e.currentTarget.dataset.index
    this.setData({
      clickIndex: index
    })
    // console.log(e)
  },
  lableclick2: function(e) {
    let name = e.currentTarget.dataset.name
    // this.setData({
    //   clickIndex2: index
    // })
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/insertLabel',
      'cachetime': '30',
     
      'method': 'POST',
      'data': {
        target_id: that.data.id,
        label: name
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          app.util.request({
            'url': 'entry/wxapp/Labels',
            'cachetime': '30',
           
            'method': 'POST',
            'data': {
              target_id: that.data.id
            },
            success: function (res) {
              // console.log("entry/wxapp/formid ==>", res)
              if (!res.data.errno) {
                that.setData({
                  lists: res.data.data
                })
              }
            }
          })
        }
      }
    })
  },
  reduce: function(e) {
    let id = e.currentTarget.dataset.id
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/DeleteLabel',
      'cachetime': '30',
     
      'method': 'POST',
      'data': {
        target_id: that.data.id,
        id: id,
      },
      success: function(res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          app.util.request({
            'url': 'entry/wxapp/Labels',
            'cachetime': '30',
           
            'method': 'POST',
            'data': {
              target_id: that.data.id
            },
            success: function(res) {
              // console.log("entry/wxapp/formid ==>", res)
              if (!res.data.errno) {
                that.setData({
                  lists: res.data.data
                })
              }
            }
          })
        }
      }
    })
    // console.log(e)
  },
  onReady: function() {
    // console.log("页面渲染完成")
  },
  onShow: function() {
    // console.log('aa')
    // 页面显示 

  },
  onHide: function() {
    // console.log("页面隐藏")
  },
  onUnload: function() {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function() {
    // console.log("监听用户下拉动作") 
    let that = this;
    wx.showNavigationBarLoading(); 
    wx.stopPullDownRefresh(); 
    that.oftenLabel()
    that.Labels()
  },
  onReachBottom: function() {
    // console.log("监听页面上拉触底") 
    var that = this;

  },
  onPageScroll: function(e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function(res) {
    // console.log("用户点击右上角分_享")

  },
})