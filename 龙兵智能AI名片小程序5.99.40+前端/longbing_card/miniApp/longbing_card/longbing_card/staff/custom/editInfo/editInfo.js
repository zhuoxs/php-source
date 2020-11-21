
var app = getApp()
Page({
  data: {
    setCount: [{ name: "男" }, { name: "女" }],
    count: -1, 
    date: '', 
    clientData:[]
  },
  shuaxin: function (e) {
    let that = this
    app.util.request({
      'url': 'entry/wxapp/clientInfo',
      'cachetime': '30',
     
      'method': 'POST',
      'data': {
        client_id: that.data.param.id
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          // console.log(res)
          let tmpData = res.data.data.info
          for(let i in tmpData){
            if (tmpData[i] == 'undefined' || typeof(tmpData[i]) == undefined) {
              tmpData[i] = ''
            }
          }
          var tmpSex = tmpData.sex;
          if(!tmpSex){
            tmpSex = '-1'
          }
          that.setData({ 
            clientData:tmpData,
            count: tmpSex,
            date:tmpData.birthday
          })
          e ? wx.stopPullDownRefresh() : ''
        }
      }
    })
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu(); 
    let param = {};
    if (options.id) { 
      param.id = options.id;
    }
    if (options.fromstatus) { 
      param.fromstatus = options.fromstatus;
    }
    that.setData({
      param, 
      globalData: app.globalData
    })

    this.shuaxin()
    wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function (e) {
    // 页面显示 
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")  
    wx.showNavigationBarLoading();
    this.shuaxin(1)
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底")  
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
    var that = this;
  },
  listenerDatePickerSelected: function (e) {
    let that = this;
    let tmpData = e.detail.value; 
    that.setData({
      date: tmpData
    })
  },
  pickerSelected: function (e) {
    let that = this;
    var value = e.detail.value;
    if (value) {
      that.setData({
        count: value,
        'froms.sex': value
      })
    }
  },
  blur_name: function (e) {
    let val = e.detail.value
    if (val) {
      this.setData({
        'froms.name': val
      })
    }
  },
  switchChange: function (e) {
    if(this.data.param.fromstatus){
      return false;
    } else {
      let val = e.detail.value
      if (val) {
        this.setData({
          'froms.is_mask': e.detail.value
        })
      }
    }
  },
  // adds: function (e) {
  //   let that = this
  //   let datas = that.data.froms
  //   datas.client_id = that.data.param.id
  toEditInfo: function (paramObj) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/editClient',
      'cachetime': '30',
     
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        // console.log("entry/wxapp/editClient ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon:'none',
            title: '客户信息修改成功！',
            duration: 2000,
            success: function () {
              setTimeout(function () {
                wx.navigateBack();
              }, 2000)
            } 
          }) 
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/editClient ==>fail ==>", res)
      }
    })
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toEditStaff') {

      var paramObj = e.detail.value;
      paramObj.client_id = that.data.param.id;
      var tmpSex = that.data.count;
      if(tmpSex == '-1' || tmpSex == 'undefined'){  
        tmpSex = ''
      }
      paramObj.sex = tmpSex;
      paramObj.birthday = that.data.date;
      for(let i in paramObj){
        if (paramObj[i] == 'undefined') {
          paramObj[i] = ''
        }
      }
      if(paramObj.is_mask == false){
        paramObj.is_mask = 0
      } else{ 
        paramObj.is_mask = 1
      }
     
      // var myPreg = /^[1][3,4,5,7,8][0-9]{9}$/;
      // var myEreg = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
      // if (!myPreg.test(e.detail.value.phone)) {
      //   wx.showToast({
      //     icon: 'none',
      //     title: '请填写正确的手机号码！',
      //     duration: 2000
      //   })
      //   return false;
      // }
      // if (!myEreg.test(e.detail.value.email)) {
      //   wx.showToast({
      //     icon: 'none',
      //     title: '请填写正确的邮箱号码！',
      //     duration: 2000
      //   })
      //   return false;
      // }

      that.toEditInfo(paramObj);

    }
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