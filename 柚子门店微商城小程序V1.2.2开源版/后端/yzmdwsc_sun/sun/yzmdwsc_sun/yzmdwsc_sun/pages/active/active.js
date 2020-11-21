// yzmdwsc_sun/pages/active/active.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '动态',
    banner: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png',
    dynamicList:[
      {
        name:'柚子鲜花店',
        uthumb:"http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png",
        cont:'红玫瑰 送花对象 朋友、恋人、家人红玫瑰 送花对象 朋友、恋人、家人红玫瑰 送花对象 朋友、恋人、家人红玫瑰 送花对象 朋友、恋人、家人',
        imaArr: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768182.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png'],
        goods:[
          {
            id:'1',
            title:'红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰红玫瑰',
            src:"http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png",
            price:'60.00',
            oldPrice:'100.00'
          }
        ],
        good: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png', ],
        comment:[
          {
            name:'墨纸墨纸',
            comment:'你好你好你好你好你好你好你好你好你好你好你好你好你好你好'
          },
          {
            name: '墨纸',
            comment: '你好你好'
          },
        ],
        times:'24小时',
        goodsStatu:0,/**0是未点赞 1已点赞 */
      },
      {
        name: '柚子鲜花店',
        uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152056647789.png",
        cont: '红玫瑰 送花对象 朋友、恋人、家人',
        imaArr: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768182.png'],
        goods: [
          {
            id: '',
            title: '红玫瑰',
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152532768193.png",
            price: '60.00',
            oldPrice: '100.00'
          }
        ],
        good: [],
        comment: [
          {
            name: '墨纸',
            comment: '你好你好'
          }
        ],
        times: '24小时',
        goodsStatu: 0,/**0是未点赞 1已点赞 */
      }
    ],
    inputShowed:false,
    comment:'',
    isLogin: false,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    app.editTabBar();  /**渲染tab */
    var that = this;
    that.reload();
    
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    //获取当前路径
    var pages = getCurrentPages() //获取加载的页面
    var currentPage = pages[pages.length - 1] //获取当前页面的对象
    var current_url = currentPage.route;
    console.log('当前路径为:' + current_url);
    that.setData({
      current_url: current_url,
    })
    app.util.request({
      'url': 'entry/wxapp/tab',
      'cachetime': '20',
      success: function (res) {
       // wx.setStorageSync('tab1', res.data.data)
        that.setData({
          tab1: res.data.data,
        })
      }
    })


  },

  //相关信息记录操作
  reload: function (e) {
    var that = this
    //获取网址
    var url = wx.getStorageSync('url');
    if (url == '') {
      app.util.request({
        'url': 'entry/wxapp/Url',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync('url', res.data)
          that.setData({
            url: res.data
          })
        },
      })
    } else {
      that.setData({
        url: url,
      })
    }
    //获取配置信息
    var settings = wx.getStorageSync('settings');
    if (settings == '') {
      app.util.request({
        'url': 'entry/wxapp/Settings',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync("settings", res.data);
          wx.setStorageSync('color', res.data.color)
          wx.setStorageSync('fontcolor', res.data.fontcolor)
          wx.setNavigationBarColor({
            frontColor: wx.getStorageSync('fontcolor'),
            backgroundColor: wx.getStorageSync('color'),
            animation: {
              duration: 0,
              timingFunc: 'easeIn' 
            }
          })
          that.setData({
            settings: res.data,
          })
        }
      })
    } else {
      that.setData({
        settings: settings,
      })
      wx.setNavigationBarColor({
        frontColor: wx.getStorageSync('fontcolor'),
        backgroundColor: wx.getStorageSync('color'),
        animation: {
          duration: 0,
          timingFunc: 'easeIn'
        }
      })
    }
   
    //获取自定义图标
    var tab = wx.getStorageSync('tab');
    if (tab == ''){
      app.util.request({
        'url': 'entry/wxapp/getCustomize',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync('tab', res.data.tab)
          that.setData({
            tab: res.data.tab,
          })
        }
      }) 
    }else{
      that.setData({
        tab: tab,
      })
    }

    // ----------------------------------获取用户登录信息----------------------------------
    wx.login({
      success: function (res) {
        var code = res.code;
        app.util.request({
          'url': 'entry/wxapp/openid',
          'cachetime': '0',
          data: { code: code },
          success: function (res) {
            wx.setStorageSync("openid", res.data.openid)
            var openid = res.data.openid;
            wx.getSetting({
              success: function (res) {
                if (res.authSetting['scope.userInfo']) {
                  wx.getUserInfo({
                    success: function (res) {
                      wx.setStorageSync("user_info", res.userInfo)
                      var nickName = res.userInfo.nickName
                      var avatarUrl = res.userInfo.avatarUrl
                      app.util.request({
                        'url': 'entry/wxapp/Login',
                        'cachetime': '0',
                        data: { openid: openid, img: avatarUrl, name: nickName },
                        success: function (res) {
                          wx.setStorageSync('users', res.data)
                          wx.setStorageSync('uniacid', res.data.uniacid)
                        },
                      })
                    },
                  })
                }
              }
            })


          }
        })

      }
    })
  },

  
  
  //底部链接
  goTap: function (e) {
    console.log(e);
    var that = this;
    that.setData({
      current: e.currentTarget.dataset.index
    })

    if (that.data.current == 0) {
      wx.redirectTo({
        url: '../index/index?currentIndex=' + 0,
      })
    };
    if (that.data.current == 1) {
      wx.redirectTo({
        url: '../shop/shop?currentIndex=' + 1,
      })
    };
    if (that.data.current == 2) {
      wx.redirectTo({
        url: '../active/active?currentIndex=' + 2,
      })
    };
    if (that.data.current == 3) {
      wx.redirectTo({
        url: '../carts/carts?currentIndex=' + 3,
      })
    };
    if (that.data.current == 4) {
      wx.redirectTo({
        url: '../user/user?currentIndex=' + 4,
      })
    };

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
    var that=this;
    //获取访问记录
    var is_login = wx.getStorageSync('is_login');
    if (!is_login) {
      wx.getSetting({
        success: function (res) {
          if (res.authSetting['scope.userInfo']) {
            wx.setStorageSync('is_login', 1);
            that.setData({
              isLogin: false,
            })
          } else {
            that.setData({
              isLogin: true,
            })
          }
        }
      })
    }


    var openid = wx.getStorageSync('openid');
    //获取动态信息
    app.util.request({
      'url': 'entry/wxapp/getDynamic',
      'cachetime': '0',
      data:{
        openid:openid,
      },
      success: function (res) {
        that.setData({
          dynamic: res.data
        })
      },
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
  
  },
  /***点赞 */
  clickGood(e){
    var that=this;
    const dynamic = that.data.dynamic;
    var statu = e.currentTarget.dataset.statu;
    var index = e.currentTarget.dataset.index;
    var id=e.currentTarget.dataset.id;
    var openid = wx.getStorageSync('openid');

    //点赞、收藏和取消 
    app.util.request({
      'url': 'entry/wxapp/setDynamicCollection',
      'cachetime': '0',
      data: {
        openid: openid,
        dynamic_id:id,
        is_status:statu,
      },
      success: function (res) {
        app.util.request({ 
          'url': 'entry/wxapp/getDynamicCollectionHeadimg',
          'cachetime': '0',
          data: {
            dynamic_id:id,
          },
          success: function (res) {
            console.log('返回信息')
            console.log(res.data);
            var collection_num =res.data.length; 
            if (statu==1){
             dynamic[index].is_collection=1;
           }else{
             dynamic[index].is_collection=0;
           }
            dynamic[index].headimg=res.data;
            that.setData({
              dynamic: dynamic,
            })
          }
        })

        


       
      },
    })

  },
  /**点击图标评论 */
  toMsg(e){
    var that = this;
    const dynamicList = that.data.dynamicList;
    var index = e.currentTarget.dataset.index;
    var id=e.currentTarget.dataset.id;
    that.setData({
      comment_id:id,
      inputShowed: true,
      commIndex:index/**需要评论的数组下标 */
    })
  },
  /**失去焦点          发送评论 */
  loseFocus(e){
    var that = this;
    var openid = wx.getStorageSync('openid');
    var comment_id=that.data.comment_id;
    var comment = that.data.comment;
    const dynamic = that.data.dynamic;
    var index = that.data.commIndex;    
    if(comment==''){
      that.setData({
        inputShowed: false
      })
      return
    }
    app.util.request({
      'url': 'entry/wxapp/setDynamicComment',
      'cachetime': '0',
      data: {
        openid:openid,
        comment:comment,
        comment_id:comment_id, 
      },
      success: function (res) {
        app.util.request({
          'url': 'entry/wxapp/getDynamicComment',
          'cachetime': '0',
          data: {
            comment_id: comment_id,
          },
          success: function (res) {
            dynamic[index].comment=res.data;
            that.setData({
              dynamic: dynamic,
              inputShowed: false
            })

          }
        })
       
      }
    })


    return ;
    var dynamicList = that.data.dynamicList
    var commIndex = that.data.commIndex;/**需要评论的数组下标 */
    var comment = that.data.comment;/*** 获取评论内容*/
    console.log(commIndex + 'comment: ' + comment )
    var comObj={}/**对象 */
    comObj.name = that.data.nickname;
    comObj.comment=comment;
    (dynamicList[commIndex].comment).push(comObj)

    that.setData({
      dynamicList: dynamicList,
      comment:'',/**成功后comment要为空 */
      inputShowed: false
    })
    
  },
  /**获取评论 */
  comment(e){
    this.setData({
      comment:e.detail.value
    })
  },
  previewImg(e) {
    var that = this;
    const dynamic = that.data.dynamic;
    let urls=that.data.url

    var index = e.currentTarget.dataset.index;
    var idx = e.currentTarget.dataset.idx;
    let url=urls + '' + dynamic[index].imgs[idx];
//    console.log(dynamic[index].imgs);
//    console.log(urls + '' + dynamic[index].imgs[idx])
    const arr = dynamic[index].imgs;
    for(var i=0;i<arr.length;i++){
      arr[i]=urls+''+arr[i]
    }

    wx.previewImage({
      current: url,
      urls: arr
    })
  },
  toGoodsdet(e) {
    var gid=e.currentTarget.dataset.gid;
    //获取商品类型
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        var lid=res.data.data.lid;
        if(lid==1||lid==2||lid==3){
          wx: wx.navigateTo({
            url: '../index/goodsDet/goodsDet?gid=' + gid,
          })
        }else if (lid == 4) {
          wx: wx.navigateTo({
            url: '../index/groupDet/groupDet?gid=' + gid,
          })
        }else if (lid == 5) {
          wx: wx.navigateTo({
            url: '../index/bardet/bardet?gid=' + gid,
          })
        }else if (lid == 6) {
          wx: wx.navigateTo({
            url: '../index/limitDet/limitDet?gid=' + gid,
          })
        }else if(lid == 7) {
          wx: wx.navigateTo({
            url: '../index/shareDet/shareDet?gid=' + gid,
          })
        }

      }
    })
  },
  toTab(e) {
    var url = e.currentTarget.dataset.url;
    url = '/' + url;
    wx.redirectTo({
      url: url,
    })
  },
  bindGetUserInfo(e) {
    if (e.detail.userInfo == undefined) {
      console.log('没有授权')
    } else {
      wx.setStorageSync('is_login', 1);
      this.setData({
        isLogin: false,
      })
     
    }

  },

})