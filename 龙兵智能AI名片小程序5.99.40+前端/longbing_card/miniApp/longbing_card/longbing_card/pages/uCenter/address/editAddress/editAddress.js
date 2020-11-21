var app = getApp();
Page({
  data: {
    sexItems: [
      { name: '先生', value: '先生', checked: true },
      { name: '女士', value: '女士', checked: false }
    ],
    sexVal: '',
    address: '',
    editAddress: []
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    // console.log(this);
    app.util.showLoading(1);
    wx.hideShareMenu();
    var that = this;
    var paramData = {};
    var sexVal = '先生';
    if (options.status) {
      paramData.status = options.status;
      if (options.status == 'toEdit') {
        paramData.editAddress = wx.getStorageSync('storageAddress');

        var tmpData = that.data.sexItems;
        if (paramData.editAddress.sex == '先生') {
          sexVal = '先生';
          tmpData[0].checked = true;
        }
        if (paramData.editAddress.sex == '女士') {
          sexVal = '女士';
          tmpData[1].checked = true;
        }

        var checkAddress = {};
        checkAddress.address = paramData.editAddress.address;
        checkAddress.address_detail = paramData.editAddress.address_detail;
        that.setData({
          checkAddress: checkAddress
        })

      } else if (options.status == 'toAdd') {
        var tmpData = that.data.sexItems;
        sexVal = '先生';
        tmpData[0].checked = true;
      }
    }

    that.setData({
      sexVal: sexVal,
      sexItems: tmpData,
      paramData: paramData,
      globalData: app.globalData
    })
    wx.hideLoading();

  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
    var that = this;
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
    wx.showNavigationBarLoading();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  radioChange: function (e) {
    let that = this;
    that.sexVal = e.detail.value;
    that.setData({
      sexVal: e.detail.value
    });
  },
  getToAddUpdateAddress: function (paramObj) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopAddAddress',
      'cachetime': '30',
      
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/shopAddAddress ==>", res)
        if (!res.data.errno) {
          var tmpMsg;
          if (that.data.paramData.status == 'toAdd') {
            tmpMsg = '已成功新增地址！'
          }
          if (that.data.paramData.status == 'toEdit') {
            tmpMsg = '已成功编辑地址！'
          }
          wx.showToast({
            icon: 'none',
            title: tmpMsg,
            duration: 2000,
            success: function () {
              setTimeout(() => {
                wx.hideToast();
                wx.navigateBack();
              }, 1000);
            }
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopAddAddress ==> fail ==> ", res)
      }
    })
  },
  chooseLocation: function (e) {
    let that = this;
    wx.chooseLocation({
      success: function (res) {
        let regex = /^(北京市|天津市|重庆市|上海市|香港特别行政区|澳门特别行政区)/;
        let REGION_PROVINCE = [];
        let addressBean = {
          REGION_PROVINCE: null,
          REGION_COUNTRY: null,
          REGION_CITY: null,
          ADDRESS: null
        };
        function regexAddressBean(address, addressBean) {
          regex = /^(.*?[市州]|.*?地区|.*?特别行政区)(.*?[市区县])(.*?)$/g;
          let addxress = regex.exec(address);
          addressBean.REGION_CITY = addxress[1];
          addressBean.REGION_COUNTRY = addxress[2];
          addressBean.ADDRESS = addxress[3] + '(' + res.name + ')';
          // console.log(addxress);
        }
        if (!(REGION_PROVINCE = regex.exec(res.address))) {
          regex = /^(.*?(省|自治区))(.*?)$/;
          REGION_PROVINCE = regex.exec(res.address);
          addressBean.REGION_PROVINCE = REGION_PROVINCE[1];
          regexAddressBean(REGION_PROVINCE[3], addressBean);
        } else {
          addressBean.REGION_PROVINCE = REGION_PROVINCE[1];
          regexAddressBean(res.address, addressBean);
        }

        var checkAddress = {};
        checkAddress.address =
          addressBean.REGION_PROVINCE +
          addressBean.REGION_CITY +
          addressBean.REGION_COUNTRY;
        checkAddress.address_detail = addressBean.ADDRESS;

        that.setData({
          addressBean: addressBean,
          checkAddress: checkAddress
        }); 
      }
    }); 
  },
  toEditAddress: function (e) {
    let that = this;
    let paramObj = e.detail.value;
    console.log('button clicked', e, paramObj);
    if (!paramObj.name) {
      wx.showToast({
        icon: 'none',
        title: '请填写联系人！',
        duration: 2000,
        success: function () {
          setTimeout(() => {
            wx.hideToast();
          }, 1000);
        }
      })
      return false;
    }
    if (!paramObj.phone) {
      wx.showToast({
        icon: 'none',
        title: '请填写手机号！',
        duration: 2000,
        success: function () {
          setTimeout(() => {
            wx.hideToast();
          }, 1000);
        }
      })
      return false;
    }

    if (that.data.paramData.status == 'toAdd') {
      console.log('新增');
      // paramObj.default = 0;

      if (!that.data.addressBean) {
        wx.showToast({
          icon: 'none',
          title: '请选择地址！',
          duration: 2000,
          success: function () {
            setTimeout(() => {
              wx.hideToast();
            }, 1000);
          }
        })
        return false;
      }
      paramObj.province = that.data.addressBean.REGION_PROVINCE;
      paramObj.city = that.data.addressBean.REGION_CITY;
      paramObj.area = that.data.addressBean.REGION_COUNTRY;
    } else if (that.data.paramData.status == 'toEdit') {
      console.log('编辑');
      paramObj.id = that.data.paramData.editAddress.id;
      // paramObj.default = that.data.paramData.editAddress.default;
      if (!that.data.addressBean) {
        paramObj.province = that.data.paramData.editAddress.province;
        paramObj.city = that.data.paramData.editAddress.city;
        paramObj.area = that.data.paramData.editAddress.area;
      } else {
        paramObj.province = that.data.addressBean.REGION_PROVINCE;
        paramObj.city = that.data.addressBean.REGION_CITY;
        paramObj.area = that.data.addressBean.REGION_COUNTRY;
      }
    }

    if (!paramObj.address_detail) {
      wx.showToast({
        icon: 'none',
        title: '请填写详细地址！',
        duration: 2000,
        success: function () {
          setTimeout(() => {
            wx.hideToast();
          }, 1000);
        }
      })
      return false;
    }
    that.getToAddUpdateAddress(paramObj);
  },
})