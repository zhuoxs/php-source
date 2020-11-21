var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { userModel } from '../../../../resource/apis/index.js'
Page({
  data:{ 
    globalData: {},
    dataList: [], 
    manageStatus: 0,
    idList: {},
    isAll: false,
    icon_car_empty:'http://retail.xiaochengxucms.com/images/12/2018/11/uAsB6O4AbAC6cs3IU4OZZaa64cBu3Z.png'
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this);
    var that = this;
    that.setData({
      globalData: app.globalData
    })
    wx.hideShareMenu(); 
  },
  onReady:function(){
    // 页面渲染完成
  },
  onShow:function(){
    // 页面显示
    app.util.showLoading(1);
    var that = this;
    that.getShopMyTrolley();
    wx.hideLoading();
  },
  onHide:function(){
    // 页面隐藏
  },
  onUnload:function(){
    // 页面关闭
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    var that = this; 
    wx.showNavigationBarLoading();
    that.getShopMyTrolley(); 
  },
  onReachBottom: function () {
    // 页面上拉触底
    var that = this; 
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getShopMyTrolley: function () {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/ShopMyTrolley',
      'cachetime': '30', 
      'method': 'POST',
      'data':{},
      success: function (res) {
        console.log("entry/wxapp/ShopMyTrolley ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          var tmp = [];
          for (let i in tmpData.list) {
            tmp.push(0);
          }
          that.setData({ 
            dataList: tmpData,
            idList: tmp
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopMyTrolley ==> fail ==> ", res)
      }
    })
  },
  toShopUpdateTrolley: function (paramObjToUpdate) {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/ShopUpdateTrolley',
      'cachetime': '30',
      
      'method': 'POST',
      'data':paramObjToUpdate,
      success: function (res) {
        console.log("entry/wxapp/ShopUpdateTrolley ==>", res)
        if (!res.data.errno) {  
          that.toCountPrice();
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopUpdateTrolley ==> fail ==> ", res)
      }
    })
  },
  toShopDelTrolley: function (paramObj,index) {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/ShopDelTrolley',
      'cachetime': '30',
      
      'method': 'POST',
      'data':paramObj,
      success: function (res) {
        console.log("entry/wxapp/ShopDelTrolley ==>", res)
        if (!res.data.errno) {
          if(index != 'delete'){
            var tmpData = that.data.dataList; 
            var tmpIdList = that.data.idList; 
            tmpIdList.splice(index, 1);
            tmpData.list.splice(index,1);
            that.setData({
              idList: tmpIdList,
              dataList: tmpData,
            })
            that.toCountPrice();
          }
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopDelTrolley ==> fail ==> ", res)
      }
    })
  },
  RemoveAddNum:function(e) {
    let that = this; 
    let status = e.currentTarget.dataset.status;
    let index = e.currentTarget.dataset.index;
    let tmpData = that.data.dataList; 
    let tmpStock = tmpData.list[index].stock;
    let tmpType = 1; 
    if (status == 'remove') {
      tmpType = 2;
    }
    var paramObjToUpdate = {
      id: tmpData.list[index].id, 
      type: tmpType,
      number: 1
    };
    if (status == 'remove') {
      console.log('购物车-1', index);
      if (tmpData.list[index].number == 1) {
        wx.showModal({
          title: '',
          content: '是否确认删除本条数据',
          success: function(res) {
            if (res.confirm) {
              let paramObj = {
                id: tmpData.list[index].id, 
              };
              that.toShopDelTrolley(paramObj, index);
            } else if (res.cancel) {
            }
          }
        });
      }  else{ 
          tmpData.list[index].number = tmpData.list[index].number * 1 - 1;
          tmpData.list[index].price = tmpData.list[index].number * tmpData.list[index].price2;
          that.toShopUpdateTrolley(paramObjToUpdate); 
      }
    }

    if (status == 'add') {
      console.log('购物车+1', index); 
      if( tmpData.list[index].number > tmpStock -1 ){
        wx.showModal({
          title: '',
          content: '库存不足，不能再添加了',
          confirmText:'知道啦',
          showCancel:false,
          success: function (res) {
            if (res.confirm) { 
            }
          }
        })
        return false;
      } else {
        tmpData.list[index].number = tmpData.list[index].number * 1 + 1; 
        tmpData.list[index].price = tmpData.list[index].number * tmpData.list[index].price2;
        that.toShopUpdateTrolley(paramObjToUpdate);
      }
    }

    that.setData({
      dataList: tmpData
    })
    that.toCountPrice();
  },
  toCountPrice:function(){
    var that = this;
    var tmpData = that.data.dataList;
    var tmpIdList = that.data.idList;
    var count_price = 0;
    var tmp_trolley_ids = '';
    var storageCarList = [];
    for (let index in tmpData.list) {
      if (tmpIdList[index] == 1) {
        count_price += (tmpData.list[index].price*1);
        storageCarList.push(tmpData.list[index]);
        tmp_trolley_ids += (tmpData.list[index].id + ',')
      }
    }
    tmp_trolley_ids = tmp_trolley_ids.slice(0,-1)
    
    var tmpCarList = {
      count_price: count_price.toFixed(2),
      tmp_trolley_ids: tmp_trolley_ids,
      dataList: storageCarList,
    }

    that.setData({
      dataList: tmpData,
      countPrice: count_price.toFixed(2),
      tmpCarList: tmpCarList,
      trolley_ids: tmp_trolley_ids
    });

  },
  checkIsAll:function() {
    var that = this;
    var tmpAll = that.data.isAll;
    var tmpIdList = that.data.idList;
    var sign = true;
    for (let index in tmpIdList) {
      if (tmpIdList[index] == 0) {
        sign = false;
      }
    }
    tmpAll = sign; 
    that.setData({
      isAll: tmpAll
    })
  },
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var tmpData = that.data.dataList.list;
    if(status == 'toProductDetail'){
      app.util.goUrl(e)
    } else if (status == 'toManage') {
      console.log("管理商品")
      var tmpIndex;
      if(index == 0){
        tmpIndex = 1
      }
      if(index == 1){
        tmpIndex = 0
      }
      that.setData({
        manageStatus: tmpIndex
      })
    } else if (status == 'toDelete') {
      console.log('删除本条数据');
      wx.showModal({
        title: '',
        content: '是否确认删除本条数据',
        success: function(res) {
          if (res.confirm) {  
            app.util.showLoading(2);
            var paramObj = {
              id: tmpData[index].id, 
            };
            that.toShopDelTrolley(paramObj, index); 
            wx.hideLoading();
            } else if (res.cancel) {
            }
          }
      });
    } else if(status == 'toCheck'){
      console.log("选择产品")
      var tmp = that.data.idList;
      if (tmp[index]) {
        tmp[index] = 0;
        that.isAll = false;
        that.setData({
          isAll: false
        });
      } else {
        tmp[index] = 1;
      } 
      that.setData({
        idList: tmp
      });
      that.toCountPrice();
      that.checkIsAll();
    } else if(status == 'toChooseAll'){
      console.log("全选")
      var that = this;
      var tmpAll = that.data.isAll;
      var tmpIdList = that.data.idList;
      tmpAll = tmpAll ? false : true;
      that.isAll = tmpAll;
      that.setData({
        isAll: tmpAll
      });
      if (tmpAll) {
        for (let index in tmpIdList) {
          tmpIdList[index] = 1;
        }
      } else {
        for (let index in tmpIdList) {
          tmpIdList[index] = 0;
        }
      } 
      that.setData({
        idList: tmpIdList
      });
      that.toCountPrice();
    } else if(status == 'toOrderPay'){
      var tmpStatus = that.data.manageStatus;
      var tmpIdList = that.data.idList;
      var tmpList = that.data.dataList.list;
      if(tmpStatus == 1){
        console.log("批量删除")
        app.util.showLoading(2);
        for(let i in tmpIdList){
          if(tmpIdList[i] == 1){
            var paramObj = {
              id: tmpList[i].id,
            };
            that.toShopDelTrolley(paramObj, 'delete');
          }
        }
        setTimeout(() => {
          that.getShopMyTrolley();
          wx.hideLoading();
        }, 500);
      } else if(tmpStatus == 0){
        console.log("去结算")
        if(!that.data.trolley_ids){
          wx.showToast({
            icon:'none',
            title:'暂未选择任何商品哦',
            duration: 2000
          })
          return false;
        } else {
          wx.setStorageSync('storageToOrder', that.data.tmpCarList);
          wx.navigateTo({
            url: '/longbing_card/pages/shop/car/toOrder/toOrder?status=toCarOrder'
          })
        }
      }
    }
  }

})