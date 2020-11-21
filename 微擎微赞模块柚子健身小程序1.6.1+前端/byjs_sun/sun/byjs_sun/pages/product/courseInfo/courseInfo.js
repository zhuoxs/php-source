var app = getApp();
Page({

  /**
  * 页面的初始数据
  */
  data: {

    index: 0,
    name: '',
    nameindex: 0,
    date: '',
    course_id:'',
    userName: '',
    mobile: '',
    is_open:'' //是否开启模板消息 
  },

  /**
  * 生命周期函数--监听页面加载
  */
  onLoad: function (options) {
    var that = this
    var id = options.id
    var money = options.money
    var price = options.price
    if(money == 0){
      that.setData({
        money: price
      })
    }else{
      that.setData({
        money: money
      })
    }
    // 获取模板消息开关
    app.util.request({
      'url':'entry/wxapp/GetMbmessage',
      'cachetime':0,
      success(res){
        that.setData({
          is_open:res.data.is_open
        })
      }
    })
 
    app.util.request
    ({
      'url':'entry/wxapp/CourseInfo',
      'data':{id:id},
      'cachetime':0,
      success:function(res){
        console.log(res)
        that.setData({
          'name':res.data.course_coach,
          'type':res.data.course_type,
          'date':res.data.course_time,
          'course_id':res.data.id
        })
      }
    })
  },
  bindnameChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      nameindex: e.detail.value
    })
  },
  bindPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      index: e.detail.value
    })
  },
  bindDateChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      date: e.detail.value
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
   
  userNameInput: function (e) {
    this.setData({
      userName: e.detail.value
    })
  },

  mobileInput: function (e) {
    this.setData({
      mobile: e.detail.value
    })
  },
  //自定义方法
  formSubmit: function (e) {
    var that = this
    var userName = this.data.userName;
    var mobile = this.data.mobile;
    var phonetel = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    var name = /^[u4E00-u9FA5]+$/;
    if (userName == '') {
      wx.showToast({
        title: '请输入用户名',
        icon: 'succes',
        duration: 1000,
        mask: true
      })

      return false
    } else if (mobile == '') {
      wx.showToast({
        title: '手机号不能为空',
      })

      return false
    }
    else if (mobile.length != 11) {
      wx.showToast({
        title: '手机号长度有误！',
        icon: 'success',
        duration: 1500
      })
      return false;
    }

    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    if (!myreg.test(mobile)) {
      wx.showToast({
        title: '手机号有误！',
        icon: 'success',
        duration: 1500
      })
      return false;
    }
    var user_id = wx.getStorageSync('users').id
    console.log(e.detail.target.dataset.course_id)
    //-----------付款---------------
    wx.getStorage({
      key: 'openid',
      success: function (res) {
        var openid = res.data;
        var price = that.data.money
        app.util.request({
          'url': 'entry/wxapp/Orderarr',
          'cachetime': '30',
          data: {
            price: price,
            openid: openid,
          },
          success: function (res) {

            var user_id = wx.getStorageSync('users').id
            console.log('-----直接购买=------')
            app.util.request({
              'url': 'entry/wxapp/Order',
              'cachetime': '0',
              data: {
                'user_id': user_id,
                'money': that.data.money,
                'user_name': that.data.userName,
                'tel': that.data.mobile,
                'good_name': '课程预约',
                'good_money': that.data.money,

              },
              success: function (o) {
                console.log(o.data)
                var order_id = o.data;
                console.log(res)
                wx.requestPayment({
                  'timeStamp': res.data.timeStamp,
                  'nonceStr': res.data.nonceStr,
                  'package': res.data.package,
                  'signType': 'MD5',
                  'paySign': res.data.paySign,
                  'success': function (result) {

                    wx.showToast({
                      title: '支付成功',
                      icon: 'success',
                      duration: 2000
                    })
                    app.util.request({
                      'url': 'entry/wxapp/PayOrder',
                      'cachetime': '0',
                      data: {
                        order_id: order_id,
                      },
                      success: function (res) {
                        app.util.request({
                          'url': 'entry/wxapp/Appointment',
                          'data': {
                            course_id: e.detail.target.dataset.course_id,
                            name: e.detail.value.name,
                            phone: e.detail.value.phone,
                            user_id: user_id
                          },
                          success: function (res) {
                            wx.navigateTo({
                              url: '/byjs_sun/pages/course/course',
                            })
                          },
                        })
                      }
                    })
                    if(that.data.is_open == 2){
                      // 发送预约成功模板消息
                      var fId = e.detail.formId;
                      var access_token = wx.getStorageSync('access_token');

                      var d = {
                        access_token: access_token,
                        touser: wx.getStorageSync('users').openid,
                        template_id: '9_m_oCy6xXYDWEmJ43nvcvuZtx0yUa10tTqfesihZ3A',//这个是1、申请的模板消息id，  
                        page: '/byjs_sun/pages/myUser/myBespoke/myBespoke',
                        form_id: fId,

                        "value1": that.data.type,
                        "color1": "#4a4a4a",

                        "value2": that.data.name,
                        "color2": "#9b9b9b",

                        "value3": that.data.date,
                        "color3": "#9b9b9b"
                      }
                      app.util.request({
                        'url': 'entry/wxapp/Send',
                        data: d,
                        method: 'POST',
                        success: function (res) {
                          console.log("push msg");
                          console.log(res);
                        },
                        fail: function (err) {
                          // fail  
                          console.log("push err")
                          console.log(err);
                        }
                      });

                    }
                    

                    wx.navigateTo({
                      url: '../reservationYes/reservationYes',
                    })

                  },


                  'fail': function (result) {
                    console.log(result + 'ssssss')
                  }
                });
              }
            })

          }
        })
      },
    })

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

  }
})