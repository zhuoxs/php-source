// yzkm_sun/pages/index/index.js

// 调用tabbar模板
const app = getApp()
var template = require('../template/template.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    sta_hyk:'',//会员卡是否开启购买状态
    jh_num:'',//激活码
    // formid:'',
    user_id:'',
    // price:'',
    banners: ['http://oydnzfrbv.bkt.clouddn.com/a5.jpg'],
    is_modal_Hidden: true,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    isLogin: false,
    currentTab: 0,
    currentIndex:0,
    statusType:["商家推荐","最新入驻","距离最近"],
    num:5,
    light:'',                                   
    kong:'',
    imgUrls:'',
    is_open_pop:'',//首页弹窗
    cheatTrial:'',//是否开启骗审页面
    // vipCardData:[
    //   {
    //     price:300,
    //    title:1
    //   },
    //   {
    //     price: 300,
    //     title: 1
    //   },
    //   {
    //     price: 300,
    //     title: 1
    //   },
    // ],
        hyk_id:'', // 会员卡类别id
    hyk_price:'',// 会员卡类别金额
    hyk_day:'',// 会员卡类别天数


  },

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


    // 获取系统表的配置参数
    app.util.request({
      'url': 'entry/wxapp/system',
      success: function (res) {
        console.log('****************************');
        console.log(res);
        wx.setStorageSync('system', res.data);
        wx.setNavigationBarTitle({
          title: res.data.pt_name
        })
        wx.setNavigationBarColor({
          frontColor: res.data.color,
          backgroundColor: res.data.fontcolor,
          animation: {
            // duration: ,
            timingFunc: 'easeIn',
          }
        })
        that.setData({
          system:res.data,
          is_open_pop: res.data.is_open_pop,
          cheatTrial: res.data.cheatTrial,
        })
      }
    })
    // 首页弹窗
    app.util.request({
      'url':'entry/wxapp/winindex',
      'cachetime':'30',
      success:function(res){
        console.log(res)
        that.setData({
          winindex:res.data,
        })
      }
    })
    var openid = wx.getStorageSync('openid');//用户openid

    app.util.request({
      'url':'entry/wxapp/Test',
      // 'cachetime':'30',
      'data':{openid:openid},
      success:function(res){
        console.log('请求方法');
         that.setData({
        list:res.data,
        })          
      }
    })
    app.util.request({
      'url': 'entry/wxapp/Banner_photo',
      success: function (res) {
        console.log('轮播图');
        console.log(res.data);
        that.setData({
          imgUrls: res.data,
          
        })
      }
    })
    app.util.request({
      'url': 'entry/wxapp/Type_sj',
      success: function (res) {
        console.log('商家分类');
        console.log(res.data);
        that.setData({
          sj_class: res.data,

        })
      }
    })

    // 会员卡数据自定义
    app.util.request({
      'url': 'entry/wxapp/Card_zdy',
      success: function (res) {
        console.log('会员卡数据自定义');
        console.log(res.data);
        console.log(res.data.img);
        console.log(res.data.title);

        that.setData({
          card_img: res.data.img,
          card_title: res.data.title,
        })
      }
    })
    // 会员卡数据请求
    // app.util.request({
    //   'url': 'entry/wxapp/Card_yhhy',
    //   success: function (res) {
    //     console.log('会员卡数据请求');
    //     console.log(res.data);

    //     that.setData({
    //       Card_yhhy: res.data,
    //       // price: res.data[0].money,
    //     })
    //   }
    // })
    // 会员卡分类
    // app.util.request({
    //   'url': 'entry/wxapp/Card_class',
    //   success: function (res) {
    //     console.log('会员卡分类');
    //     console.log(res);

    //     that.setData({
    //       class_hyk:res.data,
    //     })
    //   }
    // })
    // 会员卡是否到期
    // app.util.request({
    //   'url': 'entry/wxapp/Member_dqsj',
    //   'data': { 
    //     openid: openid 
    //     },
    //   success: function (res) {
    //     console.log('会员卡有效期')
    //     console.log(res);
    //     // wx.setStorageSync("day_yxq", res.data.day_yxq)
    //   }
    // })

    // 是否开启会员卡购买状态
    app.util.request({
      url: 'entry/wxapp/Card_hyzt',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('判断是否可以购买会员卡');
        console.log(res);
        that.setData({
          sta_hyk:res.data.price
        })
      }
    }) 



    // 底部自定义数据请求
    app.util.request({
      'url': 'entry/wxapp/Custom_photo',
      success: function (res) {
        console.log('自定义数据显示');
        console.log(res.data);
        var url = wx.getStorageSync('url')
        console.log(url)
        template.tabbar("tabBar", 0, that, res,url)//0表示第一个tabbar 
        // that.setData({

        // })
      }
    })
  },

  goBuyTap(e){
    var that=this
      if(that.data.sta_hyk==2){
    wx.showToast({
      title: '不好意思这个功能暂未开放',
      icon: "none"
    })
    return;
  }
      wx.navigateTo({
        url: '../vipCard/vipCard',
      })

  },

  /**
   * 生命周期函数--监听页面加载
   */
  goDetails(e) {
    wx.navigateTo({
      url: '../psDetails/psDetails',
    })
  },


  itemClick(e){
    console.log(e)
    if(e.currentTarget.dataset.pop_type==3){
      wx.navigateTo({
        url: '../goodsDetails/goodsDetails?id='+e.currentTarget.dataset.id,//1
      })
    } else if (e.currentTarget.dataset.pop_type == 2){
      wx.navigateTo({
        url: '../seller/details/details?id=' + e.currentTarget.dataset.id,
      })
    }
  },
// 技术支持
  callmemine(e) {
    wx.makePhoneCall({
      phoneNumber: e.currentTarget.dataset.tel,
      success: function (e) {
        console.log("-----拨打电话成功-----")
      },
      fail: function (e) {
        console.log("-----拨打电话失败-----")
      }
    })
  },
  // 点击关闭弹窗
  closeTap(e) {
    wx.setStorageSync('comeIn', 1);
    this.setData({
      comeIn: 1
    })
  },
// 选择会员卡
  buyCardType(e){
console.log(e)
var that=this
that.setData({
  currentIdx: e.currentTarget.dataset.index,
  hyk_id:e.currentTarget.dataset.id, // 会员卡类别id
  hyk_price:e.currentTarget.dataset.price,// 会员卡类别金额
  hyk_day:e.currentTarget.dataset.day,// 会员卡类别天数
})
  },
// 购买会员卡
// tobuy(e){
//   console.log(e)
//   var that=this;
//   var openid = wx.getStorageSync('openid');//用户openid
//   console.log(openid)
//   console.log(that.data.sta_hyk)
//   if(that.data.sta_hyk==2){
//     wx.showToast({
//       title: '不好意思这个功能暂未开放',
//       icon: "none"
//     })
//     return;
//   }
//   // 获取用户id
//   app.util.request({
//     url: 'entry/wxapp/User_id',
//     data: {
//       openid: openid,
//     },
//     success: function (res) {
//       console.log('查看用户id');
//       console.log(res);
//       that.setData({
//         user_id: res.data.id,
//       })
//     }
//   })

// // 查询用户是否已是会员 是的话不能重复购买 要过期了才能再次购买
//   app.util.request({
//     url: 'entry/wxapp/Member_dqsj',
//     data: {
//       openid: openid,
//     },
//     success: function (res) {
//       console.log('返回的用户会员卡状态');
//       console.log(res);
//           if(res.data.status==0){
//             wx.showToast({
//               title: '您的会员还未过期，无需重复购买',
//               icon: 'none',
//             })


//           } else if (res.data == '' || res.data.status == 1) {
//             if (that.data.hyk_id == '') {
//               wx.showToast({
//                 title: '购买的会员天数不能为空',
//                 icon: 'none',
//               })
//               return;
//             }

//             // 延时
//             setTimeout(function () {
//               // var openid = wx.getStorageSync('openid');//用户openid
//               var price = that.data.hyk_price;
//               var user_id = that.data.user_id;
//               console.log(user_id)
//               console.log(price)
//               console.log(openid)
//               app.util.request({
//                 url: 'entry/wxapp/Orderarr',
//                 'cachetime': '30',
//                 data: {
//                   openid: openid,
//                   //  price: price 
//                   price: 0.01
//                 },
//                 success: function (res) {
//                   console.log(res)
//                   var prepay_id = res.data.prepay_id;
//                   wx.requestPayment({
//                     'timeStamp': res.data.timeStamp,
//                     'nonceStr': res.data.nonceStr,
//                     'package': res.data.package,
//                     'signType': 'MD5',
//                     'paySign': res.data.paySign,
//                     success: function (res) {
//                       console.log('支付数据')
//                       console.log(res)
//                       wx.showToast({
//                         title: '支付成功',
//                         icon: 'success',
//                         duration: 2000
//                       })
//                       // 用户数据添加到会员卡
//                       app.util.request({
//                         url: 'entry/wxapp/Member_card',
//                         data: {
//                           openid: openid,
//                           user_id: user_id,
//                           hyk_id: that.data.hyk_id, // 会员卡类别id
//                           hyk_price: that.data.hyk_price,// 会员卡类别金额
//                           hyk_day: that.data.hyk_day,// 会员卡类别天数
//                         },
//                         success: function (res) {
//                           console.log('修改成功')
//                           console.log(res)
//                           // console.log(that.data.formid)

//                           // 发送模板消息
//                           app.util.request({
//                             'url': 'entry/wxapp/AccessToken',
//                             'cachetime': '0',
//                             success: function (res1) {

//                               console.log(res1.data)
//                               console.log(e.detail.formId)
//                               app.util.request({
//                                 'url': 'entry/wxapp/Send_hyk',
//                                 'cachetime': '0',
//                                 data: {
//                                   access_token: res1.data.access_token,//这是支付成功之后获取的参数  
//                                   template_id: '8cHbAdKMxbW0hHT14-F50YuMmDIiiRjatjLUL3VxDwo',
//                                   page: "./index/index",
//                                   openid: openid,
//                                   form_id: e.detail.formId,
//                                   // prepay_id: prepay_id,
//                                   money: that.data.hyk_price,
//                                 },
//                                 success: function (res2) {
//                                   console.log(res2)
//                                   // 修改数据库状态
//                                   // app.util.request({
//                                   //   'url': 'entry/wxapp/changeOrder',
//                                   //   'cachetime': '0',
//                                   //   data: {
//                                   //     order_id: order_id,
//                                   //     gid: that.data.gid,
//                                   //     money: price,
//                                   //   },
//                                   //   success: function (res3) {
//                                   //     console.log(res3)

//                                   //   }
//                                   // })
//                                 }
//                               })
//                             }
//                           })
//                         }
//                       })
//                     }
//                   })
//                 }
//               })
//             }, 500)

//           }
//     }
//   })

// },
// 会员激活码输入
  inputActCode(e){
    console.log(e)
    console.log(e)
    console.log(e.detail.value)
    var that=this;
    that.setData({
      jh_num: e.detail.value
    })
  },
// 会员卡激活
  deterActTap(e){
    var that=this
    console.log(e)
    console.log(that.data.jh_num)


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
        that.setData({
          user_id: res.data.id,
        })
      }
    })

    setTimeout(function(){  

      var user_id = that.data.user_id;
      console.log(user_id)
      var openid = wx.getStorageSync('openid');//用户openid
      console.log(openid)
      app.util.request({
        'url': 'entry/wxapp/Activation',
        data: {
          num_code: that.data.jh_num,//激活码
          user_id: user_id,
          openid: openid,
        },
        success: function (res) {
          console.log('激活码判定');
          console.log(res);

        }
      }) 

    },500)




  },

  // 商家分类点击事件
  click_sj(e){
    console.log('商家分类id')
    console.log(e)
    var sjfl_id= e.currentTarget.dataset.id;//选中的分类ID
    wx.navigateTo({
      url: '../seller/seller?id='+ sjfl_id,
    })
  },
 //商家选项卡下标选择
  statusTap(e){
    var that = this;
    var currentIndex = e.currentTarget.dataset.index;
        that.setData({
          currentIndex:e.currentTarget.dataset.index
        })
     that.onShow();          
  },

  // 拨打电话
  makePhone(e){
    console.log('电话的参数');
    console.log(e);
    var that = this;
    var tel = e.currentTarget.dataset.id;//当前点击的商家ID
      app.util.request({
        'url': 'entry/wxapp/Store_tel',
        data: {
          sj_id: tel,
        },
        success: function (res) {
          console.log('商电话请求');
          console.log(res);
              wx.makePhoneCall({
                phoneNumber : res.data[0].phone,
                success: function (e) {
                  console.log("-----拨打电话成功-----")
                },
                fail: function (e) {
                  console.log("-----拨打电话失败-----")
                }
              })          
        }
      }) 
  },

  // 跳转商家详情页面
  toSellerDeatils(e){
    console.log(e)
    wx.navigateTo({
      url: '../seller/details/details?id=' + e.currentTarget.dataset.id + '&&store_name='+e.currentTarget.dataset.store_name,
    })
  },

  // // 自定义顶部颜色
  // diyWinColor(e){
  //   wx.setNavigationBarColor({
  //     frontColor: '#ffffff',
  //     backgroundColor: '#ffb62b',
  //   })
  //   wx.setNavigationBarTitle({
  //     title: '首页',
  //   })
  // },

  /*底部tab*/
  bindChange: function (e) {

    var that = this;
    that.setData({ currentTab: e.detail.current });

  },
  swichNav: function (e) {

    var that = this;

    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
      })
    }
  },

  bindGetUserInfo: function (e) {
    console.log(e.detail.userInfo)
    this.setData({
      isLogin: false
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   * 当小程序启动，或从后台进入前台显示，会触发 onShow
   */

  onShow: function () {
    var  that = this;
    // // 延时
    // setTimeout(function(){
    //   var day_yxq = wx.getStorageSync('day_yxq');//用户day_yxq
    //   console.log(day_yxq)
    //   var openid = wx.getStorageSync('openid');//用户openid
    //   console.log(openid)
    //   app.util.request({
    //     'url': 'entry/wxapp/User_Mksj',
    //     data: {
    //       openid: openid,
    //       day_yxq: day_yxq,//有效期
    //     },
    //     success: function (res1) {
    //       console.log('是否已到期');
    //       console.log(res1);
    //       var myDate = new Date();
    //       var time1 = parseInt(res1.data.day_ts) + parseInt(day_yxq * 24 * 60 * 60);
    //      var time2 = myDate.getTime();
    //      console.log(time1)
    //      console.log(time2)
    //       if (time1>time2){
    //               app.util.request({
    //                 'url': 'entry/wxapp/Over_huiyuan',
    //                 data: {
    //                   openid: openid,
    //                 },                   
    //                 success: function (res) {
    //                   console.log('会员已过期');
    //                   console.log(res.data);
    //                 }
    //               })
    //           }
    //     }
    //   })

    // },2000)









    var comeIn = wx.getStorageSync('comeIn');
    if(comeIn){
      that.setData({
        comeIn:1,
      })
    }
    // that.getUserInfo();
    that.wxauthSetting();
    // template.tabbar("tabBar", 0, that)//0表示第一个tabbar 
    var currentIndex = that.data.currentIndex;
    console.log(currentIndex)
    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success: function (res) {
        var latitude = res.latitude
        var longitude = res.longitude
      
        app.util.request({
          'url': 'entry/wxapp/Store_xxk',
          data: {
            latitude: latitude,
            longitude: longitude,
            currentIndex: currentIndex,
          },
          success: function (res) {
            console.log('商家数据请求');
            console.log(res);
            
            that.setData({
              list1: res.data,
             
              // light: res.data.light,
              // kong: res.data.kong,
            })
          }
        })
      }
    })
  },

  //微信授权信息
  wxauthSetting(e) {
    var that = this;
    //先判断是否已经缓存用户数据，有就不用在获取授权进行存储
    var openid = wx.getStorageSync('openid');//用户openid
    if (openid) {
              wx.getSetting({
                success: function (res) {
                  console.log("进入wx.getSetting 1");
                  console.log(res);
                  if (res.authSetting['scope.userInfo']) {
                    console.log("scope.userInfo已授权 1");
                    wx.getUserInfo({
                      success: function (res) {
                        that.setData({
                          is_modal_Hidden: true,
                          thumb: res.userInfo.avatarUrl,
                          nickname: res.userInfo.nickName
                        })
                      }
                    })
                  } else {
                    console.log("scope.userInfo没有授权 1");
                    that.setData({
                      is_modal_Hidden: false
                    })
                  }
                },
                fail: function (res) {
                  console.log("获取权限失败 1");
                  that.setData({
                    is_modal_Hidden: false
                  })
                }
              })
    } else {
      wx.login({
                success: function (res) {
                  console.log("进入wx-login");
                  var code = res.code
                  wx.setStorageSync("code", code)
                  wx.getSetting({
                          success: function (res) {
                                  console.log("进入wx.getSetting");
                                  console.log(res);
                                  if (res.authSetting['scope.userInfo']) {
                                    console.log("scope.userInfo已授权");
                                    wx.getUserInfo({
                                      success: function (res) {
                                        console.log(res)
                                        that.setData({
                                          is_modal_Hidden: true,
                                          thumb: res.userInfo.avatarUrl,
                                          nickname: res.userInfo.nickName
                                        })
                                        console.log("进入wx-getUserInfo");
                                        console.log(res.userInfo);
                                        wx.setStorageSync("user_info", res.userInfo)
                                        var nickName = res.userInfo.nickName
                                        var avatarUrl = res.userInfo.avatarUrl
                                        var gender = res.userInfo.gender;
                                                  app.util.request({
                                                    'url': 'entry/wxapp/openid',
                                                    'cachetime': '0',
                                                    data: { code: code },
                                                          success: function (res) {
                                                            console.log("进入获取openid");
                                                            console.log(res.data)
                                                            wx.setStorageSync("key", res.data.session_key)
                                                            wx.setStorageSync("openid", res.data.openid)
                                                            var openid = res.data.openid
                                                                        app.util.request({
                                                                          'url': 'entry/wxapp/Login',
                                                                          'cachetime': '0',
                                                                          data: { openid: openid, img: avatarUrl, name: nickName, gender: gender },
                                                                              success: function (res) {
                                                                                console.log("进入地址login");
                                                                                console.log(res.data)
                                                                                //wx.setStorageSync('viptype', res.data)
                                                                                // console.log(res.data.time+'hhhhhhhhhhhhhhhh')
                                                                                wx.setStorageSync('users', res.data)
                                                                                wx.setStorageSync('uniacid', res.data.uniacid)
                                                                                that.setData({
                                                                                  usersinfo: res.data
                                                                                })
                                                                              },
                                                                        })
                                                          },
                                                  })
                                      },
                                            fail: function (res){
                                              console.log("进入 wx-getUserInfo 失败");
                                              that.setData({
                                                is_modal_Hidden: false
                                              })
                                            }
                                    })
                                } else {
                                      console.log("scope.userInfo没有授权");
                                      // wx.showModal({
                                      // title: '获取信息失败',
                                      // content: '请允许授权以便为您提供给服务!!',
                                      // success: function (res) {
                                        that.setData({
                                          is_modal_Hidden: false
                                        })
                                      // }
                                      // })
                            }
                        }
                })
              },
            fail: function () {
              wx.showModal({
                title: '获取信息失败',
                content: '请允许授权以便为您提供给服务!!!',
                success: function (res) {
                  that.setData({
                    is_modal_Hidden: false
                  })
                }
              })
            }
});
}
},    

  updateUserInfo(e) {
    console.log("授权操作更新");
    var that = this;
    that.wxauthSetting();
  },      
          
  /**
   * 生命周期函数--监听页面隐藏
   */
 // 当小程序从前台进入后台，会触发 onHide
  
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载/关闭
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉刷新数据
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
  
  },

  /**
   * 当小程序初始化完成时，会触发 onLaunch（全局只触发一次）
   */
  // onLaunch: function () {
  //   console.log("[ onLaunch");
  //   this.userLogin();
  //   console.log("]");
  // },


/**
   * 当小程序发生脚本错误，或者 api 调用失败时，会触发 onError 并带上错误信息
   */
  onError: function (msg) {
    console.log("[ onError");
    console.log('onError');
    console.log('msg');
    console.log("]");
  },
  // // 获取用户头像
  // onShow: function () {

  // },
  getUserInfo: function () {
    var that = this;
    wx.login({
      success: function () {
        wx.getUserInfo({
          success: function (res) {
            console.log('获取用户信息')
            console.log(res);
            that.setData({
              userInfo: res.userInfo
            });
          }
        })
      }
    })
  },
})
// ..................................................获取用户头像........................................
