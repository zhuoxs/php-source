var app = getApp();
Page({
  data:{ 
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this); 
    wx.hideShareMenu();
    var that = this; 
    that.setData({
      globalData: app.globalData
    })
  },
  onReady:function(){
    // 页面渲染完成
  },
  onShow:function(){
    // 页面显示
    app.util.showLoading(1);
    var that = this;
    that.getAddressList();
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
    let that = this;
    wx.showNavigationBarLoading();
    that.getAddressList();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getAddressList: function () {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/shopmyaddress',
      'cachetime': '30',
      'method': 'POST',
      'data':{
      },
      success: function (res) {
        console.log("entry/wxapp/shopmyaddress ==>", res)
        if (!res.data.errno) { 
          var tmpData = res.data.data;
          var tmpList = [];
          let tmpPhone = [];
          for (let i in tmpData) {
            tmpData[i].is_default = parseInt(tmpData[i].is_default);
            if (tmpData[i].is_default == 1) {
              tmpList.push(1);
            } else if (tmpData[i].is_default == 0) {
              tmpList.push(0);
            }

            tmpPhone.push(
              tmpData[i].phone.substr(0, 3) +
                '****' +
                tmpData[i].phone.substr(7, 10)
            );
          } 
 

          that.setData({
            idList: tmpList,
            dataList: tmpData,
            tmpPhone: tmpPhone
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopmyaddress ==> fail ==> ", res)
      }
    })
  },
  setShopAddressDefault: function (index) {
    var that = this;
    var tmpData = that.data.dataList;
    var tmpIdList = that.data.idList;
    var tmpType;
    if(tmpData[index].is_default == 0){
      tmpType = 1
    }
    if(tmpData[index].is_default == 1){
      tmpType = 2
    }
    app.util.request({
      'url': 'entry/wxapp/ShopAddressDefault',
      'cachetime': '30',
      'method': 'POST',
      'data':{
        type : tmpType,
        id: tmpData[index].id
      },
      success: function (res) {
        console.log("entry/wxapp/ShopAddressDefault ==>", res)
        if (!res.data.errno) { 
          for(let i in tmpData){
            tmpData[i].is_default = 0;
            tmpIdList[i] = 0;
          }
          tmpData[index].is_default = 1;
          tmpIdList[index] = 1;
          wx.showToast({
            icon:'none',
            title:'已成功设为默认地址',
            duration:2000
          })
          app.globalData.checkAddress = tmpData[index];
          that.setData({
            idList: tmpIdList,
            dataList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopAddressDefault ==> fail ==> ", res)
      }
    })
  },
  getToAddUpdateAddress: function (paramObj) {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/shopAddAddress',
      'cachetime': '30',
      'method': 'POST',
      'data':paramObj,
      success: function (res) {
        console.log("entry/wxapp/shopAddAddress ==>", res)
        if (!res.data.errno) { 
          wx.showToast({
            icon:'none',
            title: '已成功新增地址！',
            duration: 2000
          }) 
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopAddAddress ==> fail ==> ", res)
      }
    })
  },
  getDeleteAddr: function (index) {
    var that = this; 
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/shopdeladdress',
      'cachetime': '30',
      'method': 'POST',
      'data':{
        id: tmpData[index].id
      },
      success: function (res) {
        console.log("entry/wxapp/shopdeladdress ==>", res)
        if (!res.data.errno) { 
          wx.showToast({
            icon:'none',
            title: '已成功删除地址！',
            duration: 2000
          })
          tmpData.splice(index,1);
          that.setData({
            dataList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopdeladdress ==> fail ==> ", res)
      }
    })
  },
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var tmpData = that.data.dataList;
    if(status == 'toAddAddr' || status == 'toEditAddr'){
      console.log("手动添加 || 编辑地址")
      if(status == 'toEditAddr'){
        var address = that.data.dataList[index];
        wx.setStorageSync('storageAddress', address);
      }
      app.util.goUrl(e);
    } else if(status == 'toCheckAddr'){
      console.log("默认地址")
      var tmpData = that.data.dataList;
      var tmpList = tmpData[index];
      app.globalData.checkAddress_cur = tmpList;
      setTimeout(() => {
        wx.navigateBack();
      }, 300);
    } else if(status == 'toCheckDefaultAddr'){
      console.log("默认地址")
      that.setShopAddressDefault(index);
    } else if(status == 'toDeleteAddr'){
      console.log("删除地址")
      that.getDeleteAddr(index);
    } else if(status == 'toWechatAddr'){
      console.log("微信添加")
      wx.chooseAddress({
        success: function (res) {
          // console.log(res.userName)
          // console.log(res.postalCode)
          // console.log(res.provinceName)
          // console.log(res.cityName)
          // console.log(res.countyName)
          // console.log(res.detailInfo)
          // console.log(res.nationalCode)
          // console.log(res.telNumber)
          let paramObj = {
            address: res.provinceName + res.cityName + res.countyName,
            address_detail: res.detailInfo,
            province: res.provinceName,
            city: res.cityName,
            area: res.countyName,
            name: res.userName,
            phone: res.telNumber,
            sex: ''
          }
          that.getToAddUpdateAddress(paramObj);
          that.setData({
            dataList: []
          })
          that.getAddressList();
        }
      })
    }
  }
}) 