var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { userModel } from '../../../../resource/apis/index.js'
Page({
  data: {
    activeIndex: '100000101', 
    refresh: false,  
    loading: true,  
    paramType :{
      to_uid: '',
      type: 0,
      user_info: 0
    }, 
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    that.setData({
      'paramType.to_uid': wx.getStorageSync("userid"), 
      'paramType.user_info': 1,
      globalData: app.globalData
    }, function () {
      that.getPosterType();
    })
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    that.setData({
      refresh: true,
      'paramType.user_info': 1,
    }, function () {
      wx.showNavigationBarLoading()
      that.getPosterType();
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getPosterType: function () {
    var that = this;
    let { refresh,paramType} = that.data;
    let user_info = that.data.paramType.user_info;
    if (!refresh) {
      util.showLoading();
    }
    userModel.getPosterType(paramType).then((d) => {
      util.hideAll();
      console.log(d.data)
      let userinfo = 0; 
      let refresh = false; 
      let loading = false;
      let post_img = d.data.post_img;
      if (user_info == 1) {
        let { post_type_list, post_user ,post_company} = d.data; 
        that.setData({ 
          post_type_list,
          post_user,
          post_company
        })
      }
      that.setData({
        post_img,
        userinfo,
        refresh,
        loading
      })
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var categoryid = e.currentTarget.dataset.categoryid; 
    if (status == 'toTabClickMore' || status == 'toTabClick') {
      var tmpIndex = index; 
      if (status == 'toTabClickMore') {
        tmpIndex = '100000101';
      }
      that.setData({
        activeIndex: tmpIndex,
        categoryid: categoryid,
        scrollNav: 'scrollNav' + categoryid,
        post_img: [],
        'paramType.type': categoryid,
        'paramType.user_info': 0,
        refresh: false
      })
      that.getPosterType();
    } else if(status == 'toShare'){ 
      that.setData({
        currentPoster: index
      },function(){
        util.goUrl(e);
      })
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    // if(status == 'toAddressList' || status == 'toOrder' || status == 'toCollage'){
    console.log("toJump ==> ", status)
    app.util.goUrl(e, true)
    // } 
  },
  toSaveFormIds: function (formId) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/formid',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        formId: formId
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  }
})