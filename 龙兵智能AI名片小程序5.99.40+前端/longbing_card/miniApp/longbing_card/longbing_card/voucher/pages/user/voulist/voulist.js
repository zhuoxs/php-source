var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { baseModel, userModel } from '../../../../resource/apis/index.js'
import { fly } from '../../../../resource/js/xx_request.js';
var voucher = require('../../../../templates/voucher/voucher.js')
Page({
  data: {
    tabList: [{status:'toSetTab',name:'待使用'},{status:'toSetTab',name:'已使用'},{status:'toSetTab',name:'已过期'}],
    currentIndex: 0,
    voucherStatus:{
      show: false,
      status: 'unreceive',
    },
    dataList: {
      page: 1,
      total_page: '',
      list: [],
      refresh: false,
      loading: true,
    },
    checkvou: [],
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    let paramObj = {};
    let couponObj = {};
    if(options.status){
      paramObj.status = options.status;
      paramObj.check = options.check;
      couponObj.to_uid = options.to_uid;
      couponObj.money = options.money;
    }
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData,
        paramObj,
        couponObj
      }, function () {
        if(paramObj.status == 'checkvou'){
          that.toGetSouponshop();
        } else {
          that.toGetCouponList();
        }
      })
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
    app.globalData.configInfo = false;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData
      }, function () {
        that.setData({
          'dataList.page':1,
          'dataList.refresh':true,
        }, function () {
          wx.showNavigationBarLoading();
          let { paramObj } = that.data;
          if(paramObj.status == 'checkvou'){
            that.toGetSouponshop();
          } else {
            that.toGetCouponList();
          }
        })
      })
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
    let that = this;
    let { paramObj } = that.data;
    if(paramObj.status != 'checkvou'){
      let { dataList } = that.data;
      if (dataList.page != dataList.total_page && !dataList.loading) {
        that.setData({
          'dataList.page': parseInt(dataList.page) + 1,
          'dataList.loading': false
        }, function () {
          that.toGetCouponList();
        })
      }
    }
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  }, 
  toGetCouponList: function () {
    var that = this;
    let { currentIndex, dataList, checkvou } = that.data;
    let paramObj = {
      page: parseInt(dataList.page),
      type: currentIndex
    }
    if (!dataList.refresh || currentIndex >= 0) {
      util.showLoading();
    }
    userModel.getCouponList(paramObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!dataList.refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      newlist.refresh = false;
      newlist.loading = false; 
      that.setData({
        dataList: newlist
      })
    })
  },
  toGetSouponshop: function () {
    var that = this;
    let { couponObj, checkvou, dataList } = that.data; 
    if (!dataList.refresh) {
      util.showLoading();
    }
    userModel.getSouponshop(couponObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!dataList.refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      newlist.refresh = false;
      newlist.loading = false;
      let checkstatus = that.data.paramObj;
      if(checkstatus.status == 'checkvou'){
        for(let i in newlist.list){
          // if(newlist.list[i].type == 2){
          //   newlist.list.splice(i,1)
          // }
          checkvou.push(0);
          if(checkstatus.check){
            checkvou[checkstatus.check] = 1
          }
        }
      }
      that.setData({
        dataList: newlist,
        checkvou
      })
    })
  },
  toGetCouponQr: function (id) {
    var that = this; 
    let paramObj = {
      record_id: id
    } 
    userModel.getCouponQr(paramObj).then((d) => {
      util.hideAll();  
      let tmp_qr = d.data.path;
      let { currentIndex } = that.data;
      let tmp_status = 'unreceive';
      if(currentIndex == 1){
        tmp_status = 'receive';
      }
      that.setData({
        tmp_qr,
        'voucherStatus.show': true,
        'voucherStatus.status': tmp_status,
      })
    })
  },
  toCloseVoucher:function(){
    let that = this; 
    voucher.toCloseVoucher(that);
  },
  toJump: function (e) {
    var that = this;
    let { status, index } = util.getData(e);
    let { currentIndex, dataList, checkvou, paramObj } = that.data; 
    let { id, type } = dataList.list[index];
    let currentVoucher = dataList.list[index];
    if(status == 'toUseVoucher'){ 
      if(currentIndex != 2){
        if(type == 1){
          if(paramObj.status == 'checkvou'){
            if(checkvou[index] == 0){
              for(let i in checkvou){
                checkvou[i] = 0
              }
              checkvou[index] = 1
            } else if(checkvou[index] == 1){
              checkvou[index] = 0
            }
            that.setData({
              checkvou
            },function(){
              if(checkvou[index] == 1){
                app.globalData.checkvoucher = currentVoucher;
                app.globalData.checkvoucher.checkvoucher = index;
                wx.navigateBack();
              }
            })
          } else {
            util.goUrl(e);
          }
        } else if(type == 2){
          that.setData({
            currentVoucher
          },function(){ 
              that.toGetCouponQr(id); 
          })
        }
      }
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    let {index, status} = util.getFromData(e); 
    if(status == 'toSetTab'){
      that.setData({
        currentIndex: index, 
        'dataList.list':[],
        'dataList.refresh': true
      },function(){
        that.toGetCouponList();
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