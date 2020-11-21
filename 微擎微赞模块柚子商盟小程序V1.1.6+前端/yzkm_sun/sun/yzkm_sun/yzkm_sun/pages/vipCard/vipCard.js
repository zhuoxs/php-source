// yzkm_sun/pages/vipCard/vipCard.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    template_member:'',//会员卡模板id
    jh_num: '',//激活码
    hyk_id:'', // 会员卡类别id
    hyk_price:'',// 会员卡类别金额
    hyk_day:'',// 会员卡类别天数
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.setStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    })
    // 会员卡分类
    app.util.request({
      'url': 'entry/wxapp/Card_class',
      success: function (res) {
        console.log('会员卡分类');
        console.log(res);

        that.setData({
          class_hyk: res.data,
        })
      }
    })

    // 会员卡是否到期
    var openid = wx.getStorageSync('openid');//用户openid
    app.util.request({
      'url': 'entry/wxapp/Member_dqsj',
      'data': {
        openid: openid
      },
      success: function (res) {
        console.log('会员卡有效期')
        console.log(res);
        // wx.setStorageSync("day_yxq", res.data.day_yxq)
      }
    })
    // 会员卡信息
    app.util.request({
      'url': 'entry/wxapp/Message_hyk',
      success: function (res) {
        console.log('会员卡信息')
        console.log(res);
        that.setData({
          imags:res.data.img,
        })
      }
    })
    // 会员卡模板id获取
    app.util.request({
      url: 'entry/wxapp/Mob_message',
      success: function (res) {
        console.log('模板消息数据');
        console.log(res);
        that.setData({
          template_member: res.data.template_member,
        })
      }
    })
    // 当前用户是否开通会员卡
    app.util.request({
      'url': 'entry/wxapp/User_hyk',
      'data': {
        openid: openid
      },
      success: function (res) {
        console.log('用户会员状态')
        console.log(res);
        if (res.data==''){
          console.log('空的');
          that.setData({
            endTime:'当前非会员状态',
          })
        }else{
          that.setData({
            endTime: res.data.dq_time
          })
        }

      }
    })
    
    that.diyWinColor();
  },
  // 选择会员卡
  buyCardType(e) {
    console.log(e)
    var that = this
    that.setData({
      currentIdx: e.currentTarget.dataset.index,
      hyk_id: e.currentTarget.dataset.id, // 会员卡类别id
      hyk_price: e.currentTarget.dataset.price,// 会员卡类别金额
      hyk_day: e.currentTarget.dataset.day,// 会员卡类别天数
    })
  },
  // 购买会员卡
  tobuy(e) {
    console.log(e)
    var that = this;
    var openid = wx.getStorageSync('openid');//用户openid
    console.log(openid)
    console.log(that.data.sta_hyk)
    // if (that.data.sta_hyk == 2) {
    //   wx.showToast({
    //     title: '不好意思这个功能暂未开放',
    //     icon: "none"
    //   })
    //   return;
    // }
    // 获取用户id
    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        that.setData({
          user_id: res.data.id,
        })
      }
    })

    // 查询用户是否已是会员 是的话不能重复购买 要过期了才能再次购买
    app.util.request({
      url: 'entry/wxapp/Member_dqsj',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('返回的用户会员卡状态');
        console.log(res);
        console.log(that.data.hyk_id);
        // 判断是否选中会员分类
          if (that.data.hyk_id == '') {
            wx.showToast({
              title: '购买的会员天数不能为空',
              icon: 'none',
            })
            return;
          }

          // 延时
          setTimeout(function () {
            // var openid = wx.getStorageSync('openid');//用户openid
            var price = that.data.hyk_price;
            var user_id = that.data.user_id;
            console.log(user_id)
            console.log(price)
            console.log(openid)
            app.util.request({
              url: 'entry/wxapp/Orderarr',
              'cachetime': '30',
              data: {
                openid: openid,
                 price: price 
                // price: 0.01
              },
              success: function (res) {
                console.log(res)
                var prepay_id = res.data.prepay_id;
                wx.requestPayment({
                  'timeStamp': res.data.timeStamp,
                  'nonceStr': res.data.nonceStr,
                  'package': res.data.package,
                  'signType': 'MD5',
                  'paySign': res.data.paySign,
                  success: function (res) {
                    console.log('支付数据')
                    console.log(res)
                    wx.showToast({
                      title: '支付成功',
                      icon: 'success',
                      duration: 2000
                    })

                    // 用户数据添加到会员卡
                    app.util.request({
                      url: 'entry/wxapp/Member_card',
                      data: {
                        openid: openid,
                        user_id: user_id,
                        hyk_id: that.data.hyk_id, // 会员卡类别id
                        hyk_price: that.data.hyk_price,// 会员卡类别金额
                        hyk_day: that.data.hyk_day,// 会员卡类别天数
                      },
                      success: function (res) {
                        console.log('修改成功')
                        console.log(res)
                        // console.log(that.data.formid)

                        // 发送模板消息
                        app.util.request({
                          'url': 'entry/wxapp/AccessToken',
                          'cachetime': '0',
                          success: function (res1) {
                          console.log('模板消息的 formid 和 模板编号')
                            console.log(res1.data)
                            console.log(e.detail.formId)
                            console.log(that.data.template_member)
                            app.util.request({
                              'url': 'entry/wxapp/Send_hyk',
                              'cachetime': '0',
                              data: {
                                access_token: res1.data.access_token,//这是支付成功之后获取的参数  
                                template_id: that.data.template_member,
                                page: "./index/index",
                                openid: openid,
                                form_id: e.detail.formId,
                                // prepay_id: prepay_id,
                                money: that.data.hyk_price,
                              },
                              success: function (res2) {
                                console.log(res2)
                                    wx.navigateTo({
                                      url: '../vipCard/vipCard',
                                    })
                              }
                            })
                          }
                        })
                      }
                    })
                  }
                })
              }
            })
          }, 500)      

      }
    })

  },




  // 会员激活码输入
  inputActCode(e) {
    console.log(e)
    console.log(e)
    console.log(e.detail.value)
    var that = this;
    that.setData({
      jh_num: e.detail.value
    })
  },
  // 会员卡激活 激活点击事件
  deterActTap(e) {
    var that = this
    console.log(e)
    console.log(that.data.jh_num)




    setTimeout(function () {

      var openid = wx.getStorageSync('openid');//用户openid
      console.log(openid)
      // 获取用户id
      app.util.request({
        url: 'entry/wxapp/User_id',
        data: {
          openid: openid,
        },
        success: function (res) {
          console.log('查看用户id');
          console.log(res);
          // that.setData({
          //   user_id: res.data.id,
          // })
                // var openid = wx.getStorageSync('openid');//用户openid
                console.log(openid)
                console.log(that.data.jh_num)
                app.util.request({
                  url: 'entry/wxapp/Activation',
                  data: {
                    num_code: that.data.jh_num,//激活码
                    user_id: res.data.id,
                    openid: openid,
                  },
                  success: function (res1) {
                    console.log('激活码判定');
                    console.log(res1);


                  }
                })


        }
      })



    }, 1000)

    // 延时
    setTimeout(function () {
      wx.navigateTo({
        url: '../vipCard/vipCard',
      })
    }, 3000)   


  },

  selVipType(e){
    this.setData({
      currentIdx:e.currentTarget.dataset.index,
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
  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '会员卡',
    })
  },
})