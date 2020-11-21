var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    talent:
    {
      img: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
      name: '卡若不弃',
      release_time: '12月10日',
      gender: 0,  //0男，1女
      userId: '123',
      talentImg: ['http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png'],
      talentText: '世纪东方看水电费上课的飞机上课的房间上课的房间开始的九分裤世纪东方开始的减肥上课京东方',
      talentLove: '12',
      talentComment: '1',
      iddata: 1,//0无评论，1有评论。
    },
    lovestatus: 0,//点赞0灰色1红色
    loveimgsrc1: '../../../../../byjs_sun/resource/images/find/icon-love.png',//点赞灰色背景路径
    loveimgsrc2: '../../../../../byjs_sun/resource/images/find/icon-love-1.png',//点赞红色背景路径
    lovenum: 0,//点赞数字
    lovenumadd1: 1,
    releaseFocus: false,
    fixbottomFocus: true,
    expert_id:"",

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this; 
    //设置顶部背景色和字体颜色
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })

    var expert_id = options.id;
    var url = wx.getStorageSync('url');
    var user_id = wx.getStorageSync('users').id;
    //user_id = user_id ? user_id:10;//在没有appid的情况下，默认一个用户id
    //获取达人圈详情
    app.util.request({
      'url': 'entry/wxapp/GetExpertDetail',
      'cachetime': '0',
      data: {
        expert_id: expert_id,
        user_id: user_id
      },
      success(res) {
        console.log(res.data);
        that.setData({
          talent: res.data,
          url: url,
          expert_id: expert_id
        })
      }
    })
  },
  /*点赞*/
  lovefun: function (e) {
    var that = this
    var id = this.data.expert_id; //获取达人圈id
    var tag = 0; //达人圈标识为0
    var user_id = wx.getStorageSync('users').id;
    var talent = that.data.talent;

    //判断点赞还是取消点赞
    if (talent.is_love == 1) {//取消
      talent.is_love = 0;
      talent.collect_num = parseInt(talent.collect_num) - 1;
    } else {//点赞
      talent.is_love = 1;
      talent.collect_num = parseInt(talent.collect_num) + 1;
    }
    app.util.request({
      'url': 'entry/wxapp/lovefun',
      'cachetime': '0',
      data: {
        tag: tag,
        id: id,
        user_id: user_id
      },
      success(res) {
        if (res.data == 1) {
          that.setData({
            talent: talent
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
  //图片预览
  previewImage: function (e) {
    var that = this;
    var url = wx.getStorageSync('url');
    var img = e.currentTarget.dataset.img;
    var talent = that.data.talent;//结伴行
    var imgarr = talent.img;
    var urlspre = [];
    for (var i = 0; i < imgarr.length; i++) {
      urlspre[i] = url + imgarr[i];
    }
    // //图片预览
    wx.previewImage({
      current: img,     //当前图片地址
      urls: urlspre,               //所有要预览的图片的地址集合 数组形式
    }) 
  },
  //点击回复出现输入框
  bindReply: function (e) {
    console.log(e);
    console.log(this.data)
    this.setData({
      releaseFocus: true
    })
  },
  //点击隐藏输入框
  displaycom: function (e) {
    this.setData({
      releaseFocus: false,
      fixbottomFocus: true,
    })
  },
  //20180426 @淡蓝海寓 弹出发布评论
  addcom: function (e) {
    var talent = this.data.talent;
    //console.log(talent);
    this.setData({
      releaseFocus: true,
      fixbottomFocus: false,
      releaseName: talent.name,
    })
  },
  //20180426 @淡蓝海寓 发布评论数据
  tacomformSubmit:function(e){
    var that = this;
    var talent = that.data.talent;
    var user_id = wx.getStorageSync('users').id;
    var expert_id = that.data.expert_id;
    let formdata = e.detail.value;
    var commenttext = formdata.commenttext;
    if (!commenttext) {
      wx.showToast({
        title: '内容不能为空！！！',
        icon: 'none',
      })
      return false;
    }
    app.util.request({
      'url': 'entry/wxapp/Addcomment',
      'cachetime': '0',
      data: {
        expert_id: expert_id,
        user_id: user_id,
        content: commenttext
      },
      success(res) {
        var talentcom = talent.comment;
        console.log(talentcom);
        var newdata = {
            img: wx.getStorageSync('users').img,
            gender: wx.getStorageSync('users').gender,
            name: wx.getStorageSync('users').name,
            content: commenttext,
            release_time:0
          };
        //console.log(res.data);
        if(res.data.id>0){
          newdata.release_time = res.data.data.release_time;
          talentcom.unshift(newdata);
          talent.comment = talentcom;
          //console.log(talent);
          that.setData({
            releaseFocus: false,
            fixbottomFocus: true,
            talent: talent
          })

        }
      }
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

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})