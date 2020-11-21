// yzkm_sun/pages/seller/details/details.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentIndex:0,
    showModalStatus: false,
    statusType: ["商家详情", "用户评论"],                                   //不可删
    num: 5,
    light: '',
    kong: '',   
    starMap: ['非常差','差','一般','好','非常好',
    ],
    star:0,
    
    noS:'',                              
    banners: ["http://oydmq0ond.bkt.clouddn.com/shangpinxiangqing.png"],   //活数据可删
    serverList: ["刷卡支付", "免费WIFI", "免费停车", "禁止吸烟", "提供包间"],      //活数据可删
    nodes: [                                                                //活数据可删
      {
        name:'p',
        attrs:{
          style:'color:#666;font-size:30rpx;'
        }
      },
      {
        name:'img',
        src:'http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png',
        attrs:{
          style:'width:100%;'
        }
      }
    ],
    detailsList:[                                                            //可删
      {
        text:'这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删',
        pic:'http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png'
      }, {
        text: '这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删',
        pic: 'http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png'
      },{
        text: '这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删',
        pic: 'http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png'
      }
    ],
    comments:[
      {
        headerImg:'http://oydnzfrbv.bkt.clouddn.com/header.png',
        nick:'XXX',
        dateTime:'2018-01-23 14:00',
        contents:'这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧'
      },
      {
        headerImg: 'http://oydnzfrbv.bkt.clouddn.com/header.png',
        nick: 'Up',
        dateTime: '2020-08-23 09:00',
        contents: '这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧'
      },
      {
        headerImg: 'http://oydnzfrbv.bkt.clouddn.com/header.png',
        nick: 'David',
        dateTime: '2016-02-23 23:00',
        contents: '这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧'
      }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
        var that=this;
        wx.setStorageSync('iid', options.id);
         that.diyWinColor();
         console.log('获取当前商家Id');
         console.log(options.id);
              app.util.request({
                'url': 'entry/wxapp/Url',
                success: function (res) {
                  console.log('页面加载请求')
                  console.log(res);
                  wx.getStorageSync('url', res.data);
                  that.setData({
                    url: res.data,
                  })
                }
              })

            // //情况一:展示后台给的星级评分  
            // that.setData({
            //   light: that.data.num,
            //   kong: 5 - that.data.num
            // })  
            // 经纬度获取和数据请求
              wx.getLocation({
                type: 'gcj02', //返回可以用于wx.openLocation的经纬度
                success: function (res) {
                  var latitude = res.latitude
                  var longitude = res.longitude

                  app.util.request({
                    'url': 'entry/wxapp/Store_xqy',
                    data: {
                      latitude: latitude,
                      longitude: longitude,
                      currentIndex: 0,
                      sj_id: options.id,
                    },
                    success: function (res) {
                      console.log('商家详情页数据请求');
                      console.log(res);
                      // wx.setNavigationBarTitle({
                      //   title: res.data[0].store_names
                      // })
                      that.setData({
                        list_xqy: res.data[0],
                      })
                    }
                  })
                }
              })
              //   // 详情头部显示
              wx.setNavigationBarTitle({
                title: options.store_name,
              })

                    app.util.request({
                      'url': 'entry/wxapp/Store_xqyGoods',
                      data: {
                        sj_id: options.id,
                      },
                      success: function (res) {
                        console.log('商家详情页商品数据请求');
                        console.log(res);
                        that.setData({
                          list_xqyGoods: res.data,
                        })
                      }
                    })
          //成功后添加添加评论数据到后台
       var openid = wx.getStorageSync('openid');//用户openid
                  app.util.request({
                    'url': 'entry/wxapp/User_id',
                    data: {
                      openid: openid,
                    },
                    success: function (res) {
                      console.log('查看用户id');
                      console.log(res);
                      that.setData({
                        comment_xqy: res.data,
                      })
                      wx.setStorageSync('user_id', res.data.id);
                      }
                    })    
                  //设定超时函数//让页面延迟几秒出现
                  setTimeout(function () {

                    var user_id = wx.getStorageSync('user_id');//用户user_id
                    // 页面进来先判断收藏状态
                    console.log(user_id)
                    app.util.request({
                      'url': 'entry/wxapp/Status_sc',
                      data: {
                        user_id: user_id,
                        store_id:options.id
                      },
                      success: function (res) {
                        console.log('判断初始收藏状态');
                        console.log(res);
                        if (res.data.state== 0){
                          that.setData({
                            noS: 0,//未收藏
                          })
                        }else{
                          that.setData({
                            noS: 1,//已收藏
                          })
                        }
                      }
                    })

                  }, 500)

  },
// 点击跳转商家入驻页面
  toZhu(e){
    wx.navigateTo({
      url: '../../sjrz-Page/sjrz-Page',
    })
  },
  // 点击切换tab栏

  statusTap(e) {
    var that = this;
    var currentIndex = e.currentTarget.dataset.index;
    that.setData({
      currentIndex: e.currentTarget.dataset.index
    })
    that.onShow();
  },
  // 点击我要评论方法
  toComments: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
    // console.log('点击评论');
    // console.log(e);
  },
  // // 用户评价星级
  myChooseStar: function (e) {
    var that=this;
    console.log('用户评价星级')
    console.log(e)
       let star = parseInt(e.target.dataset.star) || 0;
       that.setData({
          star: star,
        });
  },
  // // 评论内容
  in_content:function(e){
    var that = this;
    console.log('评论内容')
    console.log(e)
    let vals =e.detail.value;
    that.setData({
      vals: vals,
    });
  },
  // 取消发布
  cancleBtn(e){
    var currentStatu = e.currentTarget.dataset.statu;
    var star = e.target.dataset.star;
    this.util(currentStatu);
  },
  //点击确认按钮
  close: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    var star = e.target.dataset.star;
    this.util(currentStatu);
    this.deterTap(star);
  },
  //以下是弹窗效果
  util: function (currentStatu) {
    if (currentStatu == "open") {
      this.setData(
        {
          showModalStatus: true
        }
      );
    }
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    });
    this.animation = animation;
    animation.opacity(0).height(0).step();
    this.setData({
      animationData: animation.export()
    })
//设定超时函数//让页面延迟几秒出现
    setTimeout(function () {
      animation.opacity(1).height('630rpx').step();
      this.setData({
        animationData: animation
      })
      if (currentStatu == "close") {
        this.setData(
          {
            showModalStatus: false
          }
        );
      }
    }.bind(this), 200)
  },
  // 评价成功
  deterTap: function (e) {
    console.log(e);
    var that=this;
    console.log(that.data.star)
    if (that.data.star > 0) {
          wx.showToast({
            title: '评价成功',
            icon: 'success',
            duration: 2000
          });
          that.setData({
            hideStarBox: true
          })
          var currentStatu = e.currentTarget.dataset.statu;
          var vals = that.data.vals;//输入框的值
          var star = that.data.star;//星星的值  
          var openid = wx.getStorageSync('user_id');//用户openid

          console.log('sadfsadsaddasdsadsadasdas');
          console.log(openid);
          console.log(star);
          console.log(vals);
          var iid = wx.getStorageSync('iid')//商家ID
          var user_id = wx.getStorageSync('user_id')//用户ID
                        app.util.request({
                          'url': 'entry/wxapp/Comment_AddSjpl',
                          data: {
                            vals: vals,
                            star: star,
                            user_id:user_id,
                            sj_id: iid,
                          },
                          success: function (res1) {
                            console.log('查看是否评论成功');
                            console.log(res1);
                            that.setData({
                              comment_xqy: res1.data,
                            })
                          }
                        })      
                        
                        this.util(currentStatu);
    } else {
          wx.showToast({
            title: '请评价星级',
            icon: 'none',
            duration: 3000
          });
    }

  },
  // 拨打电话
  makePhone(e) {
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
          phoneNumber: res.data[0].phone,
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
  // 点击商品跳转商品详情页面
  goGoodsDetails(e){
    console.log('点击商品跳转商品详情页面');
    console.log(e);
    wx.redirectTo({
      url: '../../goodsDetails/goodsDetails?id=' + e.currentTarget.dataset.id,
    })
    // wx.navigateTo({
    //   url: '../../goodsDetails/goodsDetails?id=' + e.currentTarget.dataset.id,
    // })
  },

  // 点击收藏
  collectTap(e){
    var that=this;
    var iid = wx.getStorageSync('iid')
    var user_id = wx.getStorageSync('user_id')
    console.log(iid)
    console.log(user_id)
    if(that.data.noS==1){//未收藏 点击收藏
      app.util.request({
        'url': 'entry/wxapp/Collect_sj',
        data: {
          noS: '0',
          id: user_id,
          iid: iid,
        },
        success: function (res) {
          console.log('收藏数据');
          console.log(res);
          that.setData({
            comment_xqy: res.data,
            noS:0,
          })
        }
      })           
    }else{//已收藏，取消收藏
      app.util.request({
        'url': 'entry/wxapp/Collect_sj',
        data: {
          noS: '1',
          id: user_id,
          iid: iid,
        },
        success: function (res) {
          console.log('收藏数据');
          console.log(res);
          that.setData({
            comment_xqy: res.data,
            noS: '1',
          })
        }
      })        
    }
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
    var iid=wx.getStorageSync('iid')
    console.log('商家ID');
    console.log(iid);
          app.util.request({
            'url': 'entry/wxapp/Url',
            success: function (res) {
              wx.getStorageSync('url', res.data);
              that.setData({
                url: res.data,
              })
            }
          })
    // this.getUserInfo();
    // template.tabbar("tabBar", 1, this)//0表示第一个tabbar 
    var currentIndex = that.data.currentIndex;
    console.log('详情页选项卡下标获取')
    console.log(currentIndex)
    if (currentIndex==0){
      app.util.request({
        'url': 'entry/wxapp/Store_sjxqsj',
        data: {
          currentIndex: currentIndex,
          sj_id: iid,
        },
        success: function (res) {
          console.log('商家详情数据');
          console.log(res);
          that.setData({
            list_xqsj: res.data,
          })
        }
      })
    } else if (currentIndex==1){
      app.util.request({
        'url': 'entry/wxapp/Store_xqy_comment',
        data: {
          currentIndex: currentIndex,
          sj_id: iid,
        },
        success: function (res) {
          console.log('商家评论数据');
          console.log(res);
          that.setData({
            list_comment: res.data,
          })
        }
      })
    }

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
   * 用户点击分享
   */
  onShareAppMessage: function (res) {
    console.log(res);
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res.target)
    }
    return {
      title: '自定义转发标题',
      path: '/pages/first/index',
      success: function (res) {
        // 转发成功
        console.log("转发成功")
      },
      fail: function (res) {
        // 转发失败
        console.log("转发失败")
      }
    }
  },
  // 自定义window
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
  },
})