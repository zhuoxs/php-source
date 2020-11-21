// yzkm_sun/pages/circle/circle.js

// 调用tabbar模板
const app = getApp()
var template = require('../template/template.js');

Page({

  /**
   * 页面的初始数据
   */
  data: {
    showModalStatus: false,
    currentTab: 0,
    currentIndex: 0,
    statusType: ["热门圈子", "最新发布", "距离最近"],
    latitude_dq: '',
    longitude_dq: '',
    fabu_id: '',//发布者id
    // Zan:'',
    // browse:'',//浏览量
    store: [
      {
        pic: 'http://oydmq0ond.bkt.clouddn.com/3c6d55fbb2fb4316b81c19dd2ca4462309f7d312.jpg',
        text: '房产租售'
      },
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */



  onLoad: function (options) {

    var that = this;

    app.util.request({
      'url': 'entry/wxapp/system',
      success: function (res) {
        console.log('****************************');
        console.log(res); 
        wx.setStorageSync('system', res.data);
        // wx.setStorageSync('is_zx', res.data.is_zx);//判断是否需要通过审核才能显示圈子内容
        that.setData({
          is_zx: res.data.is_zx
        })

        wx.setNavigationBarColor({
          frontColor: res.data.color,
          backgroundColor: res.data.fontcolor,
          animation: {
            // duration: ,
            timingFunc: 'easeIn'
          }
        })
      }
    })

    var openid = wx.getStorageSync('openid');//用户openid
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
    that.diyWinColor();
    // 获取当前用户经纬度
    wx.getLocation({
      type: 'wgs84 ', //返回可以用于wx.openLocation的地址
      success: function (res) {
        console.log('获取当前用户经纬度')
        console.log(res)
        that.setData({
          latitude_dq: res.latitude,
          longitude_dq: res.longitude,
        })

      }
    })
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
          comment_xqy: res.data,
        })
        wx.setStorageSync('user_id', res.data.id);//当前要评论的用户id
      }
    })
// 底部自定义部分的数据传输
    app.util.request({
      'url': 'entry/wxapp/Custom_photo',
      success: function (res) {
        console.log('自定义数据显示');
        console.log(res.data);
        var url = wx.getStorageSync('url')
        if (res.data.key == 0) {
          template.tabbar("tabBar", 3, that, res, url)//0表示第一个tabbar 
        } else {
          template.tabbar("tabBar", 2, that, res, url)//0表示第一个tabbar 
        }
      }
    })
    // 圈子分类数据请求
    app.util.request({
      'url': 'entry/wxapp/Post_tz',
      success: function (res) {
        console.log('圈子分类数据');
        console.log(res);
          that.setData({
            post_list:res.data
          });
          if (that.data.post_list.length <= 5) {
            that.setData({
              height: 150
            })
          } else if (that.data.post_list.length > 5) {
            that.setData({
              height: 300
            })
          }
          // ----------------------------------把分类以10个位一组分隔开----------------------------------
          var nav = []
          for (var i = 0, len = that.data.post_list.length; i < len; i += 10) {
            nav.push(that.data.post_list.slice(i, i + 10))
          }
          that.setData({
            nav: nav
          })

      }
    })


  },

  // 圈子分类点击事件
  goclassDetails(e) {
    var that = this;
    console.log(e);
    console.log(e.currentTarget.dataset.id);
    var is_zx = that.data.is_zx;
    var currentIndex = that.data.currentIndex;
    // 1状态开启 2状态关闭 
    if (is_zx == 1) {
      console.log(currentIndex)
      console.log(that.data.latitude_dq)
      console.log(that.data.longitude_dq)
      app.util.request({
        'url': 'entry/wxapp/Circle_zx1',
        data: {
          currentIndex: currentIndex,
          latitude_dq: that.data.latitude_dq,
          longitude_dq: that.data.longitude_dq,
          post_id:e.currentTarget.dataset.id//分类id
        },
        success: function (res) {
          console.log('圈子数据请求需要审核');
          console.log(res.data);
          that.setData({
            list: res.data,
          })
        }
      })
    } else if (is_zx == 2) {
      console.log(currentIndex)
      console.log(that.data.latitude_dq)
      console.log(that.data.longitude_dq)
      console.log(e.currentTarget.dataset.id)
      app.util.request({
        'url': 'entry/wxapp/Circle_zx',
        data: {
          currentIndex: currentIndex,
          latitude_dq: that.data.latitude_dq,
          longitude_dq: that.data.longitude_dq,
          post_id: e.currentTarget.dataset.id,//分类id
        },
        success: function (res) {
          console.log('圈子数据请求无需审核');
          console.log(res);
          that.setData({
            list: res.data,
          })
        }
      })
    }
  },

  // var is_zx = wx.getStorageSync('is_zx');//判断是否需要审核发布内容
  // console.log(is_zx);

  // console.log(currentIndex);


  // 取消发布
  cancleBtn(e) {
    var currentStatu = e.currentTarget.dataset.statu;
    var star = e.target.dataset.star;
    this.util(currentStatu);
  },
  //圈子选项卡下标选择
  statusTap(e) {
    var that = this;
    var currentIndex = e.currentTarget.dataset.index;
    that.setData({
      currentIndex: e.currentTarget.dataset.index
    })
    that.onShow();
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    // var is_zx = wx.getStorageSync('is_zx');//判断是否需要审核发布内容
    // console.log(is_zx);
    var that = this;
    // template.tabbar("tabBar", 3, this)//0表示第一个tabbar 
    
    // console.log(currentIndex);
    setTimeout(function(){
      var is_zx = that.data.is_zx;
      var currentIndex = that.data.currentIndex;
      // 1状态开启 2状态关闭 
      if (is_zx == 1) {
        console.log(currentIndex)
        console.log(that.data.latitude_dq)
        console.log(that.data.longitude_dq)
        app.util.request({
          'url': 'entry/wxapp/Circle_zx1',
          data: {
            currentIndex: currentIndex,
            latitude_dq: that.data.latitude_dq,
            longitude_dq: that.data.longitude_dq,
          },
          success: function (res) {
            console.log('圈子数据请求需要审核');
            console.log(res.data);
            that.setData({
              list: res.data,
            })
          }
        })
      } else if (is_zx == 2) {
        console.log(currentIndex)
        console.log(that.data.latitude_dq)
        console.log(that.data.longitude_dq)       
        app.util.request({
          'url': 'entry/wxapp/Circle_zx',
          data: {
            currentIndex: currentIndex,
            latitude_dq: that.data.latitude_dq,
            longitude_dq: that.data.longitude_dq,
          },
          success: function (res) {
            console.log('圈子数据请求无需审核');
            console.log(res.data);
            that.setData({
              list: res.data,
            })
          }
        })
      }
    },1000)
  },


  // 点击圈子信息跳转详情页面
  details(e){
    console.log('圈子说说id')
    console.log(e.currentTarget.dataset.id)

    var that = this;
    var fabu_id = e.currentTarget.dataset.id
    var user_id = wx.getStorageSync('user_id');//用户openid
          that.diyWinColor();
          app.util.request({
            url: 'entry/wxapp/Details_qz',
            data: {
              openid: user_id,
              fabu_id: fabu_id,
            },
            success: function (res) {
              console.log('圈子详情页面信息');
              console.log(res);
              that.setData({
                Details_xqy: res.data,
              })
              // 跳转到详情页
              wx.navigateTo({
                // url: './details/details',
                url: './details/details?id=' + fabu_id ,
              })  
            }
          })
  },
  // 点赞点击事件
      praise(e){
        console.log('圈子说说id')
        console.log(e.currentTarget.dataset.id)
        var idx = e.currentTarget.dataset.idx;
        var fabu_id = this.data.list[idx].id;
        var that = this
        var user_id = wx.getStorageSync('user_id');//用户openid
        that.diyWinColor();
        app.util.request({
          url: 'entry/wxapp/Tickle_qz',
          data: {
            openid: user_id,
            fabu_id: fabu_id,
          },
          success: function (res) {
            console.log('圈子点赞数据信息');
            console.log(res);
            if (res.data == 1) {
              that.setData({
                ['list[' + idx + '].praise']: that.data.list[idx].praise - 0 + 1
              })
            }
          }
        })
      },
  
  // 跳转圈子详情页面
  toCircleDetails(e) {
    wx.navigateTo({
      url: './details/details',
    })
  },

  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '圈子',
    })
  },
  // 表单数据接收
  bindSubmit(e){
    console.log('圈子用户评论内容')
    console.log(e)
    var that=this
    var contents=e.detail.value.contents;//输入内容
    var user_id = wx.getStorageSync('user_id');//用户id
    console.log(user_id);
    // var id = e.currentTarget.dataset.id;//当前要评论的说说id
    var fabu_id = that.data.fabu_id;//当前要评论的说说id
    console.log('d465654646465')
    // console.log(id)
    // 判断评论是输入框是否为空
    if (contents==''){
      wx.showToast({
        title: '内容不能为空！！！',
        icon:'none',
      })
    }else{
      app.util.request({
        url: 'entry/wxapp/Comments_qz',
        data: {
          openid: user_id,
          contents: contents,
          fabu_id: fabu_id,
        },
        success: function (res) {
          console.log('查看圈子评论说说');
          console.log(res);
          // 跳转到圈子
          // 详情页面
          wx.navigateTo({
            url: './details/details?id=' + this.data.fabu_id,
          })
        }
      })
    }

  },
  /*自定义弹出下拉列表*/
  writeComments: function (e) {
    var that=this;
    console.log('111111e');
    console.log(e);
    var currentStatu = e.currentTarget.dataset.statu;
    var id = e.currentTarget.dataset.id;
    console.log(id);
    // var id = e.currentTarget.dataset.id;
    that.setData({
      fabu_id: id,//当前要评论的发布者id
       });
    that.util(currentStatu);
  },
  // 确认发布按钮
  close: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
  },
  util: function (currentStatu) {
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
        // 跳转到圈子详情页面
          // wx.navigateTo({
          //   url: './details/details?id='+this.data.fabu_id,
          // })
      }
    }.bind(this), 200)
    if (currentStatu == "open") {
      this.setData(
        {
          showModalStatus: true
        }
      );
    }
  },

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

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

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