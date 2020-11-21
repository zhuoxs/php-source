// chbl_sun/pages/manager/withDrawal/withDrawal.js
var app = getApp();
//强制保留2位小数，如：2，会在2后面补上00.即2.00   
function toDecimal2(x) {
  var f = parseFloat(x);
  if (isNaN(f)) {
    return false;
  }
  var f = Math.round(x * 100) / 100;
  var s = f.toString();
  var rs = s.indexOf('.');
  if (rs < 0) {
    rs = s.length;
    s += '.';
  }
  while (s.length <= rs + 2) {
    s += '0';
  }
  return s;
}   
Page({

  /**
   * 页面的初始数据
   */
  data: {
    noticeBox:true,
    checked:false,
    flag:true,
    balance_sj:'',//可提现金额
    tx_sxf: '',//提现费率
    commission_cost: '',//提现费率
  },

  // putMaxMoney(e){
  //   var that = this;
  //   var maxMoney = that.data.putforword.canbeput;
  //   var putmoney = toDecimal2(e.detail.value);//保留俩小数~

  //   console.log(maxMoney + 'kkk' + putmoney)
  //   if (maxMoney < putmoney){
  //     wx.showToast({
  //       title: '提现金额不能大于可提现金额！',
  //       icon: 'none',
  //     })
  //   }
  // },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  console.log(options)
  var that=this;
  that.setData({
    balance_sj: options.balance_sj,
  })
  // 系统表数据加载
  app.util.request({
    'url': 'entry/wxapp/Sys_tixian',
    success: function (res) {
      console.log('查看系统表数据');
      console.log(res);
      that.setData({
        tx_sxf: res.data.tx_sxf,//提现费率  
        tx_details: res.data.tx_details,//提现须知
        commission_cost: res.data.commission_cost,//提现的佣金比例
      })
    }
  })  

  var openid = wx.getStorageSync('openid');//用户openid
  app.util.request({
    'url': 'entry/wxapp/User_id',
    data: {
      openid: openid,
    },
    success: function (res) {
      console.log('查看用户id');
      console.log(res);
      wx.setStorageSync('user_id', res.data.id);
    }
  }) 

  },

// 提现点击事件
  bindSubmit(e) {
    
    var that = this;
    var checked = that.data.checked;
    var user_id = wx.getStorageSync('user_id');//用户user_id
    // var canbeInput = that.data.putforword.canbeput;//可提现金额
    var canbeInput = that.data.balance_sj;//可提现金额
    var putmoney = toDecimal2(e.detail.value.putmoney);//提现金额
    var username = e.detail.value.username;//姓名
    var accountnumber = e.detail.value.accountnumber;//微信号
    var comaccountnumber = e.detail.value.comaccountnumber;//确认账号
    var openid = wx.getStorageSync('openid');
    var minMoney = that.data.txset.tx_money;//最小提现金额
    var yj_num =  putmoney * (that.data.commission_cost/100)//要扣除的佣金数量
    var fl_num = (putmoney - yj_num) * (that.data.tx_sxf / 100);//提现的手续费
    // var actual_money = putmoney - putmoney * (that.data.tx_sxf / 100);// 实际金额
    var actual_money = putmoney - yj_num - fl_num;// 实际金额
    console.log(yj_num)
    console.log(fl_num)
    console.log(actual_money)
    if (putmoney < 1) {
      wx.showToast({
        title: '请输入正确的提现金额！',
        icon: 'none',
      })
      return;
    }
    if (checked == true) {
      var flag = that.data.flag;
      console.log(flag);
      if (flag == true) {
        that.setData({
          flag: false,
        })
        setTimeout(function () {
          that.setData({
            flag: true,
          })
        }, 1000)
        if (putmoney - 0 > canbeInput - 0) {
          wx.showToast({
            title: '提现金额不能大于可提现金额！',
            icon: 'none',
          })
        } else if (putmoney - 0 < minMoney - 0) {
          wx.showToast({
            title: '提现金额不能小于最低提现金额！',
            icon: 'none',
          })
        } else {
          if (!putmoney) {
            wx.showToast({
              title: '请输入提现金额！',
              icon: 'none',
            })
            return false;
          }
          if (!username) {
            wx.showToast({
              title: '请输入您的姓名！',
              icon: 'none',
            })
            return false;
          }
          if (!accountnumber) {
            wx.showToast({
              title: '请输入微信号！',
              icon: 'none',
            })
            return false;
          }
          if (!comaccountnumber) {
            wx.showToast({
              title: '请输入确认账号！',
              icon: 'none',
            })
            return false;
          }
          if (accountnumber != comaccountnumber) {
            wx.showToast({
              title: '微信号和确认账号不一致！',
              icon: 'none',
            })
            return false;
          }

          app.util.request({
            'url': 'entry/wxapp/InputStoreMoney',
            'cachetime': '0',
            data: {
              canbeInput: canbeInput,//可提现金额
              accountnumber: accountnumber,//微信号
              comaccountnumber: comaccountnumber,//确认账号
              putmoney: putmoney,//提现金额
              username: username,//姓名
              openid: openid, 
              actual_money:actual_money,//实际金额
              user_id:user_id,//
            },
            success: function (res) {
              console.log(res)
              if (res.data== 1) {
                // wx.showLoading({
                //   title: '提现信息提交中...',
                //   mask: true,
                // })
                wx.hideLoading()
                wx.showToast({
                  title: '提交成功！',
                })
                setTimeout(function () {

                  wx.redirectTo({
                    url: '../mine/mine',
                  })                 
                }, 2000)

                // setTimeout(function () {
                //   wx.showToast({
                //     title: '提现金额：' + putmoney + '平台佣金' + yj_num + '提现手续费' + fl_num + '实际金额' + actual_money,
                //   })

                // },4000)
              }
            }
          })
        }
        // wx.showLoading({
        //   title: '提现信息提交中...',
        //   mask: true
        // })

      } else {
        wx.showToast({
          title: '请勿重复提交请求...',
          icon: 'none',
        })
      }
    } else {
      wx.showToast({
        title: '请阅读并同意《提现须知》',
        icon: 'none',
      })
    }
  },



  checkBoxTap(e){

    console.log(e);
    if(!this.data.checked){
      this.setData({
        checked: true
      })
    }else{
      this.setData({
        checked: false
      })
    }
    
  },


  noticeBoxTap(e){
    this.setData({
      noticeBox:false
    })
  },

  closeTap(e){
    this.setData({
      noticeBox:true
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
      var that = this;
      //可提现金额
      app.util.request({
        'url':'entry/wxapp/Putforward',
        'cachetime':'0',
        data:{
          openid:wx.getStorageSync('openid'),
        },
        success:function(res){
          console.log(res)
          that.setData({
            putforword:res.data.data,
          })
        }
      })
      //提现设置
      app.util.request({
        'url':'entry/wxapp/system',
        'cachetime':'0',
        success:function(res){
          console.log(res)
          that.setData({
            txset:res.data
          })
        }
      })
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

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})