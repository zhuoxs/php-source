var app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    tabs: [
      {
        name: "达人圈",
        tabimgsrc: "../../../../byjs_sun/resource/images/interactive/icon-talent.png",
        imgclass: "moving-nav-talent",
      },
   
    ],
    activeIndex: 0,
    sliderOffset: 0,
    sliderLeft: 0,
    commentimgsrc:'../../../resource/images/find/icon-comment.png',
    status: 0,//0关注1已关注
    lovestatus: 0,//点赞0灰色1红色
    loveimgsrc1: "../../../../byjs_sun/resource/images/find/icon-love.png",//点赞灰色背景路径
    loveimgsrc2: "../../../../byjs_sun/resource/images/find/icon-love-1.png",//点赞红色背景路径
    lovenum: 0,//点赞数字
    lovenumadd1: 1,
    talent:[],
    gowith: [],
    seeall:"全文",
    hideall: "收起",
    page:1,
    tabBarList: [
     
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // 设置底部图标
    this.setData({
      tabBarList: app.globalData.tabbar4
    })
    var that = this;
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
  

    //设置顶部背景色和字体颜色
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })

    var activeIndex = app.globalData.aci;//判断是否结伴行过来页面
    var url = wx.getStorageSync('url');
    var user_id = wx.getStorageSync('users').id;
    
    // 获取底部图标
    app.util.request({
      'url': 'entry/wxapp/Tab',
      'cachetime': 30,
      success: function (res) {
        var data1 = [{
          state: false,
          url: 'goIndex',
          publish: false,
          text: res.data.data.index,
          iconPath: res.data.data.indeximg,
          selectedIconPath: res.data.data.indeximgs,
        },
        {

          state: false,
          url: 'goChargeIndex',
          publish: false,
          text: res.data.data.coupon,
          iconPath: res.data.data.couponimg,
          selectedIconPath: res.data.data.couponimgs,
        },
        {
          state: false,
          url: 'goPublishTxt',
          publish: true,
          text: res.data.data.fans,
          iconPath: res.data.data.fansimg,
          selectedIconPath: res.data.data.fansimgs,
        },
        {
          state: true,
          url: 'goFindIndex',
          publish: false,
          text: res.data.data.find,
          iconPath: res.data.data.findimg,
          selectedIconPath: res.data.data.findimgs,
        },
        {
          state: false,
          url: 'goMy',
          publish: false,
          text: res.data.data.mine,
          iconPath: res.data.data.mineimg,
          selectedIconPath: res.data.data.mineimgs,
        },
        ]
        // 是否显示
        app.util.request({

          'url': 'entry/wxapp/SwitchBar',
          'cachetime': 0,
          success: function (res) {
            // console.log(res.data.is_fbopen+'sss')
            let is_fbopen = res.data.is_fbopen
            if (is_fbopen == "0") {
              data1.splice(2, 2)
              that.setData({
                tabBarList: data1
              })
            } else {
              that.setData({
                tabBarList: data1
              })
            }

          }
        })

      }
    })
   
        // 获取达人圈
        app.util.request({
          'url': 'entry/wxapp/getExpert',
          'cachetime': '0',
          data: {
            user_id: user_id
          },
          success(res) {
            console.log(res.data);
            that.setData({
              talent: res.data,
              url: url,
              page: 1,
              activeIndex: 0
            })
          }
        }),
    

    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
  },
  goIndex: function (e) {
    wx.redirectTo({
      url: '../../product/index/index'
    })
  },
  goChargeIndex: function (e) {
    wx.redirectTo({
      url: '../../charge/chargeIndex/chargeIndex'
    })
  },
  goPublishTxt: function (e) {
    wx.redirectTo({
      url: '../../publishInfo/publish/publishTxt'
    })
  },
  goFindIndex: function (e) {
    wx.redirectTo({
      url: '../../find/findIndex/findIndex'
    })
  },
  goMy: function (e) {
    wx.redirectTo({
      url: '../../myUser/my/my'
    })
  },
  //20180425  切换显示全部内容或者部分内容
  showalltitle:function(e){
    var that = this;
    var f_index = e.currentTarget.dataset.f_index;
    var activeIndex = that.data.activeIndex;
    if (activeIndex==1){
      var arrdata = that.data.gowith;//结伴行
    }else{
      var arrdata = that.data.talent;//达人圈
    }
    var status = arrdata[f_index].status;
    if (status==1){
      arrdata[f_index].status = 0;
    }else{
      arrdata[f_index].status = 1;
    }
    if(activeIndex==1){
      that.setData({
        gowith: arrdata
      })
    }else{
      that.setData({
        talent: arrdata
      })
    }
  },
  //20180425 @淡蓝海寓 显示达人圈图片
  seetalentimg:function(e){
    var that = this;
    var url = wx.getStorageSync('url');
    var f_index = e.currentTarget.dataset.f_index,
      s_index = e.currentTarget.dataset.s_index;
    var activeIndex = that.data.activeIndex;
    if (activeIndex == 1) {
      var arrdata = that.data.gowith;//结伴行
    } else {
      var arrdata = that.data.talent;//达人圈
    }
    var currentpre = url + arrdata[f_index].img[s_index];
    var imgarr = arrdata[f_index].img;
    var urlspre = [];
    for (var i = 0; i < imgarr.length;i++){
      urlspre[i] = url+imgarr[i];
    }
    // //图片预览
    wx.previewImage({
      current: currentpre,     //当前图片地址
      urls: urlspre,               //所有要预览的图片的地址集合 数组形式
    }) 
    
  },
  //切换达人圈和结伴行
  tabClick: function (e) {
    this.setData({
      sliderOffset: e.currentTarget.offsetLeft,
      activeIndex: e.currentTarget.id
    });
    //禁用下拉刷新,在点击切换时进行刷新
    var user_id = wx.getStorageSync('users').id;
    var that = this;
    if (e.currentTarget.id == 1) {
      //获取结伴行数据
      app.util.request({
        'url': 'entry/wxapp/getGowith',
        'cachetime': '0',
        data:{
          user_id: user_id
        },
        success(res){
          //app.globalData.aci的数据
          app.globalData.aci = 1;
          that.setData({
            gowith: res.data,
            page:1
          })
        }
      })
    }else{
      //清除app.globalData.aci的数据
      app.globalData.aci = "";
      that.onLoad();
    }
  },
  //页面跳转（详情）
  gointeractiveInfoone: function (e) {
    var expert_id = e.currentTarget.dataset.id; //获取内容id
    wx.navigateTo({
      url: '../interactive/interactiveInfoone/interactiveInfoone?id=' + expert_id,
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
     that.onLoad();
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
    app.globalData.aci = 0
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
    wx.showNavigationBarLoading(); //在标题栏中显示加载
    var that = this;
    that.onShow();
    wx.hideNavigationBarLoading();
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  //20180426 @淡蓝海寓 
  onReachBottom: function () {
    var that = this;
    var url = wx.getStorageSync('url');
    var user_id = wx.getStorageSync('users').id;
    var page = that.data.page;
    var activeIndex = that.data.activeIndex;
    if (activeIndex == 1) {
      var arrdata = that.data.gowith;//结伴行
      var dataurl = "entry/wxapp/GetGowith";
    } else {
      var arrdata = that.data.talent;//达人圈
      var dataurl = "entry/wxapp/getExpert";
    }
    wx.showLoading({
      title: '数据加载中',
    })
    // 获取数据
    app.util.request({
      'url': dataurl,
      'cachetime': '0',
      data: {
        user_id: user_id,
        page:page
      },
      success(res) {
        if( res.data==2){
          wx.showToast({
            title: '已经没有内容了哦！！！',
            icon: 'none',
          })
        }else{
          console.log(res.data);
          var newdata = res.data;
          arrdata = arrdata.concat(newdata);
          console.log(arrdata);
          if (activeIndex == 1) {
            //结伴行
            that.setData({
              gowith: arrdata,
              url: url,
              page: page + 1
            })
          } else {
            //达人圈
            that.setData({
              talent: arrdata,
              url: url,
              page: page + 1
            })
          }
        }
        wx.hideLoading();
      }
    })
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },
  /*发现-关注 20180425 @淡蓝海寓*/
  attention: function (e) {
    var that = this
    var att_user_id = e.currentTarget.dataset.id; //获取达人圈用户id
    var user_id = wx.getStorageSync('users').id; //获取当前登录用户的id
    //user_id = user_id ? user_id : 10;//给一个默认用户id，必须数据库有的，无appid使用
    //var tag = this.data.activeIndex; //获取顶部标识,为1标识在达人圈页面,为0标识在结伴行页面
    var url = wx.getStorageSync('url');
    var f_index = e.currentTarget.dataset.f_index;
    //var talent = that.data.talent;
    var allattentionstatus = 0;

  
     var talent = that.data.talent;//达人圈

    
    if (user_id == att_user_id) {
      wx.showToast({
        title: '不能关注自己',
        icon: 'none'
      })
      //return false;
    }else{
      //判断关注还是取消关注
      if (talent[f_index].is_attention == 1) {//取消
        talent[f_index].is_attention = 0;
      } else {//关注
        talent[f_index].is_attention = 1;
        allattentionstatus = 1;
      }
      app.util.request({
        'url': 'entry/wxapp/Attention',
        'cachetime': '0',
        data: {
          att_user_id: att_user_id,
          user_id: user_id
        },
        success(res) {
          //console.log(res.data);
          if (res.data == 1) {
            console.log(talent);
            //更改页面数据中已关注用户按钮显示
            for (var i = 0; i < talent.length;i++){
              if (talent[i].user_id==att_user_id){
                talent[i].is_attention = allattentionstatus;
              }
            }
           
              that.setData({
                talent: talent//达人圈
              })
            
          } else {
            wx.showToast({
              title: '关注失败，网络延迟！！！',
              icon: 'none',
            })
          }
        },
        fail(res) {
          wx.showToast({
            title: '关注失败，网络延迟！！！',
            icon: 'none',
          })
        }
      })
    }
  },
  /*发现-点赞*/
  //20180425 @淡蓝海寓
  lovefun: function (e) {
    var that = this
    var att_user_id = e.currentTarget.dataset.id; //获取达人圈用户id
    var user_id = wx.getStorageSync('users').id; //获取当前登录用户的id
   // var tag = this.data.activeIndex; //获取顶部标识,为1标识在达人圈页面,为0标识在结伴行页面
    var id = e.currentTarget.dataset.id;  //点赞的动态的id
    var url = wx.getStorageSync('url');
    var f_index = e.currentTarget.dataset.f_index;
    var arrdata = that.data.talent;//达人圈
 
    
    //判断点赞还是取消点赞
    if (arrdata[f_index].is_love == 1) {//取消
      arrdata[f_index].is_love = 0;
      arrdata[f_index].collect_num = parseInt(arrdata[f_index].collect_num) - 1;
    } else {//点赞
      arrdata[f_index].is_love = 1;
      arrdata[f_index].collect_num = parseInt(arrdata[f_index].collect_num) + 1;
    }
    app.util.request({
      'url': 'entry/wxapp/lovefun',
      'cachetime': '0',
      data: {
       
        id: id,
        user_id: user_id
      },
      success(res) {
        if (res.data == 1) {
         
            that.setData({
              talent: arrdata   //达人圈
            })
          
        } else {
          wx.showToast({
            title: '点赞失败，网络延迟！！！',
            icon: 'none',
          })
        }
      },
      fail(res) {
        wx.showToast({
          title: '点赞失败，网络延迟！！！',
          icon: 'none',
        })
      }
    })
  },

})