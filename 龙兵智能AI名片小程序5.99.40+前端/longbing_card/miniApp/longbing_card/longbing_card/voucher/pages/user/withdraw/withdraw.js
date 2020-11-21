var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { baseModel } from '../../../../resource/apis/index.js'
var voucher = require('../../../../templates/voucher/voucher.js')
Page({
  data: {  
    tabList: [{status:'toSetTab',name:'提现申请中'},{status:'toSetTab',name:'提现已到账'}],
    currentIndex: 0,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    let paramObj = {};
    if(options.money){
      paramObj.money = options.money;
      paramObj.wechat = options.wechat;
      paramObj.min = 100;
      // paramObj.min = options.min;
    } 
    that.setData({ 
      globalData: app.globalData,
      paramObj
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
      // 'paramType.user_info': 1,
    }, function () {
      wx.showNavigationBarLoading()
      // that.getPosterType();
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  }, 
  toCloseVoucher:function(){
    let that = this; 
    voucher.toCloseVoucher(that);
  },
  toJump: function (e) {
    var that = this;
    let {status} = util.getData(e); 
    let { paramObj } = that.data;
    if(status == 'toWithdrawAll'){
      if(paramObj.money >= paramObj.min){
        that.setData({
          inputMoney: paramObj.money
        })
      } else {
        util.showModalText('温馨提示','提现金额未达到最低提现标准！')
      }
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    let { index, status } = util.getFromData(e);
    let { paramObj } = that.data;
    if(status == 'toWithDrawBtn'){
      wx.showModal({
        title:'',
        content:'需要添加管理员微信好友后才可提现\r\n管理员微信号：' + paramObj.wechat,
        confirmText: '复制微信',
        cancelText:'关闭',
        success(res) {
          if (res.confirm) {
            wx.setClipboardData({
              data: tmp_wechat,
              success: function (res) {
                wx.getClipboardData({
                  success: function (res) {
                    console.log('复制微信号 ==>>', res.data);
                  }
                });
              }
            });
          } else if (res.cancel) {
            
          }
        }
      })
    }
    that.toSaveFormIds(formId); 
    // app.util.goUrl(e, true) 
  },
  toSaveFormIds: function (formId) {
    var that = this;
    let paramObj = {
      formId: formId
    }
    baseModel.getFormId(paramObj).then((d) => {
      // util.hideAll();
    })
  }
}) 