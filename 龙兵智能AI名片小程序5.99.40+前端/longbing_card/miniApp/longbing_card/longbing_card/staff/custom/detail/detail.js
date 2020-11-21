const app = getApp();
import * as echarts from '../../../templates/ec-canvas/echarts';
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { userModel, baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
    globalData: [],
    tabList: [{ status: 'browse', name: '浏览记录' }, { status: 'follow', name: '跟进记录' }, { status: 'analysis', name: 'AI分析' }],
    currentIndex: 0,
    currentTab: 'browse',
    Customer: [],//客户的基本信息
    currEditInd: -1,
    toFolledit: 'toSave',
    content: '',
    date: '',
    startDate: '',
    page: 1,
    dateindex: 0, //浏览记录加载
    dateindex2: 0, //跟进记录加载
    content: '', //添加跟进记录内容
    BrowseList: [], //浏览记录
    show: false,
    pageBrowse: 1,
    moreBrowse: true,
    isEmptyBrowse: false,
    followList: [], //跟进记录
    toFollowType: [],
    page: 1,
    more: true,
    isEmpty: false,
    index1: '2', //客户活跃度默认时间
    index2: '2', //客户互动默认时间
    Labellist: [],//已有标签
    errno: 0,//该客户是否成交
    types: '',//客户页面传过来的新增还是跟进或者成交
    ai_Interest: [],
    ai_Interest_x: [],
    ai_Interest_y: [],
    ai_active_x: [],
    ai_active_y: [],
    ai_Interaction: [],
    setInterest: [{ name: "今日" }, { name: "近7天" }, { name: "近30天" }, { name: "本月" }],
    interest: 2,
    setActivity: [{ name: "近7天" }, { name: "近30天" }],
    activity: 1,
    setClient: [{ name: "今日" }, { name: "近7天" }, { name: "近30天" }, { name: "本月" }, { name: "全部" }],
    client: 2,
    firstTime: '',//客户第一次使用时间
    RecordShow: false, //跟进记录层
    vagueShow: false, //模糊层
    textValue: '', //跟进记录输入内容
    ec: {
      lazyLoad: true // 延迟加载
    },
    isShowFooter: true
  },
  // 页面初始化 options为页面跳转所带来的参数 
  onLoad: function (options) {
    // console.log(options)
    app.util.showLoading(1);
    wx.hideShareMenu();
    options.type ? this.setData({
      types: options.type
    }) : ''

    let param = {};
    if (options.id) { 
      param.id = options.id;
    }
    if (options.fromstatus) { 
      param.fromstatus = options.fromstatus;
    }
    this.setData({
      param
    })

    this.getDealDate();
    this.getRate();
    this.firsttime()


    //判断客户是否已成交
    this.ifOK()

    let that = this;



    if (that.data.currentTab == 'browse') {
      console.log("浏览记录")
      that.setData({
        onPullDownRefreshBrowse: true
      })
      that.getBrowse();
    } else if (that.data.currentTab == 'follow') {
      console.log("跟进记录")
      that.setData({
        onPullDownRefresh: true
      })
      that.getFollow();
    } else if (that.data.currentTab == 'analysis') {
      console.log("AI分析")
      that.setData({
        isShowFooter: false
      })
      that.getAnalysis();
    }

    var date = new app.util.date();
    var create_time = (date.dateToLong(new Date) / 1000).toFixed(0);
    create_time = date.dateToStr('yyyy-MM-DD', date.longToDate(create_time * 1000));
    that.setData({
      startDate: create_time,
      globalData: app.globalData
    })


    app.util.request({
      'url': 'entry/wxapp/Staff',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        target_id: that.data.param.id
      },
      success: function (res) {
        // console.log(that.data.Customer)
        //  console.log(res)
        let img2 = res.data.data.avatarUrl
        that.setData({
          img2: img2
        })
      }
    })

    wx.hideLoading();

  },
  onReady: function () {

  },
  // 页面显示 
  onShow: function (e) {
    //获取客户信息
    var that = this;
    that.shuaxin()
    //获取用户标签
    that.biaoqian()
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  // console.log("监听用户下拉动作")  
  onPullDownRefresh: function () {

    app.util.showLoading(1);
    var that = this;
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that, baseModel, util);
    if (that.data.currentTab == 'browse') {
      that.setData({
        onPullDownRefreshBrowse: true,
      })
      that.getBrowse();
    }
    if (that.data.currentTab == 'follow') {
      that.setData({
        onPullDownRefresh: true
      })
      that.getFollow();
    }
    wx.stopPullDownRefresh();
    wx.hideLoading();
  },
  // console.log("监听页面上拉触底")
  onReachBottom: function () {
    var that = this;
    console.log('触底')
    app.util.showLoading(1);
    if (that.data.currentTab == 'browse') {
      console.log(that.data.currentTab)
      if (that.data.isEmptyBrowse == false) {
        console.log(that.data.isEmptyBrowse)
        that.setData({
          pageBrowse: that.data.pageBrowse + 1
        })
        that.getBrowse();
      }
    } else if (that.data.currentTab == 'follow') {
      if (that.data.isEmpty == false) {
        console.log(that.data.isEmpty)
        that.setData({
          page: that.data.page + 1
        })
        that.getFollow();
      }
    }
    wx.hideLoading();
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享") 
  },
  pickerSelected: function (e) {
    let that = this;
    let status = e.currentTarget.dataset.status;
    if (status == 'interest') {
      that.setData({
        interest: e.detail.value
      })
      that.getInterest();
    } else if (status == 'activity') {
      that.setData({
        activity: e.detail.value
      })
      that.getActivity();
    } else if (status == 'client') {
      that.setData({
        client: e.detail.value
      })
      that.getClientInteraction();
    }
  },
  listenerDatePickerSelected: function (e) {
    let that = this;
    let tmpData = e.detail.value;
    var tmpArr = tmpData.split('-');
    that.setData({
      date: tmpData,
      year: tmpArr[0],
      month: tmpArr[1],
      day: tmpArr[2],
      content: '将预计成交日期更改为' + tmpData,
    })
    that.getDealDate();
    that.adds();
  },
  getDealDate: function () {
    var that = this;
    let paramObj = {
      client_id: that.data.param.id,
    }
    if (that.data.date) {
      paramObj.date = that.data.date
    }
    app.util.request({
      'url': 'entry/wxapp/DealDate',
      'cachetime': '30',

      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/DealDate ==> ", res)
        if (!res.data.errno) {
          if (res.data.data.date) {
            let tmpData = res.data.data.date;
            var tmpArr = tmpData.split('-');
            that.setData({
              date: tmpData,
              year: tmpArr[0],
              month: tmpArr[1],
              day: tmpArr[2]
            })
          }
        }
      }
    })
  },
  getRate: function () {
    var that = this;
    let paramObj = {
      client_id: that.data.param.id,
    }
    app.util.request({
      'url': 'entry/wxapp/Rate',
      'cachetime': '30',

      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/Rate ==> ", res)
        if (!res.data.errno) {
          that.setData({
            rate: res.data.data.rate
          })
        }
      }
    })
  },
  //修改编辑客户信息
  Edit: function (e) {
    let tmp_url = `/longbing_card/staff/custom/editInfo/editInfo?id=${this.data.param.id}`;
   if(this.data.param.fromstatus){
    tmp_url = tmp_url + `&fromstatus=${this.data.param.fromstatus}`
   }
    wx.navigateTo({
      url: tmp_url
    })
  },
  //跳转添加标签页面
  addslables: function (e) {
    wx.navigateTo({
      url: `/longbing_card/staff/custom/tag/tag?id=${this.data.param.id}`,
    })
  },
  //点击添加跟进记录按钮
  addsRecord: function (e) {
    this.setData({
      RecordShow: true, //跟进记录层
      vagueShow: true, //模糊层
      content: ''
    })
  },
  //跟进记录input
  textValue: function (e) {
    // console.log(e.detail.value)
    this.setData({
      content: e.detail.value
    })
  },
  //取消
  cancel: function (e) {
    this.setData({
      RecordShow: false, //跟进记录层
      vagueShow: false, //模糊层
      textValue: '', //跟进记录输入内容
      content: ''
    })
  },
  //保存
  adds: function (e) {
    let that = this
    that.setData({
      RecordShow: false, //跟进记录层
      vagueShow: false, //模糊层
    })
    if (that.data.toFolledit == 'toSave') {

      var paramObj = {
        client_id: that.data.param.id,
        content: this.data.content
      }
      if (that.data.content.indexOf('将预计成交日期更改为') > -1) {
        paramObj.type = 2
      }
      app.util.request({
        'url': 'entry/wxapp/followInsert',
        'cachetime': '30',

        'method': 'POST',
        'data': paramObj,
        success: function (res) {
          // console.log("entry/wxapp/formid ==>", res)
          if (!res.data.errno) {
            that.setData({
              page: 1,
              currentIndex: 1,
              currentTab: 'follow',
              onPullDownRefresh: true
            })
            that.getFollow()
            that.setData({
              content: ''
            })
          }
        }
      })
    } else {
      that.getFollowEdit();
    }


  },
  index99: function (e) {
    this.setData({
      RecordShow: false, //跟进记录层
      vagueShow: false, //模糊层
      textValue: '', //跟进记录输入内容
    })
  },
  BottomOK: function (e) {
    let that = this
    if (that.data.errno == 1) {
      app.util.request({
        'url': 'entry/wxapp/Deal',
        'cachetime': '30',

        'method': 'POST',
        'data': {
          client_id: that.data.param.id
        },
        success: function (res) {

          if (!res.data.errno) {
            that.setData({
              errno: 0
            })
          }
        }
      })
    } else if (that.data.errno == 0) {

      app.util.request({
        'url': 'entry/wxapp/CancelDeal',
        'cachetime': '30',

        'method': 'POST',
        'data': {
          client_id: that.data.param.id
        },
        success: function (res) {
          console.log("entry/wxapp/DealDate ==> ", res)
          if (!res.data.errno) {
            that.setData({
              errno: 1
            })
          }
        }
      })

    }

    that.setData({
      onPullDownRefresh: true
    })
    that.getFollow();
  },

  ifOK: function (e) {
    let that = this
    app.util.request({
      'url': 'entry/wxapp/CheckDeal',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        client_id: that.data.param.id
      },
      success: function (res) {
        if (!res.data.errno) {
          let aa = res.data.message == '未成交' ? '1' : '0'
          that.setData({
            errno: aa
          })
        }
      }
    })
  },

  init_bar: function (e) {
    var self = this;
    if (e == '1') {
      //pre
      this.barComponent.init(function (canvas, width, height) {
        // 初始化图表
        const barChart = echarts.init(canvas, null, {
          width: width,
          height: height
        });
        barChart.setOption(self.getBarOption());
        // 注意这里一定要返回 chart 实例，否则会影响事件处理等
        return barChart;
      })
    }
    if (e == '2') {
      //line
      this.barComponent2.init(function (canvas, width, height) {
        // 初始化图表
        const barChart = echarts.init(canvas, null, {
          width: width,
          height: height
        });
        barChart.setOption(self.getBarOption2());
        // 注意这里一定要返回 chart 实例，否则会影响事件处理等
        return barChart;
      })
    }


  },
  getBarOption: function () {
    // console.log(JSON.stringify(this.data.tatallData));
    var that = this;
    // console.log(that.data.ai_Interest_y)
    // console.log(that.data.ai_Interest_x)

    return {
      legend: {
        orient: 'vertical',
        top: '10%',
        right: '10%',
        data: that.data.ai_Interest_x
      },
      series: [{
        type: 'pie',
        center: ['30%', '40%'],
        radius: ['40%', '60%'],
        avoidLabelOverlap: false,
        label: {
          normal: {
            show: false,
            position: 'center'
          },
          // emphasis: {
          //   show: true,
          //   textStyle: {
          //     fontSize: '30',
          //     fontWeight: 'bold'
          //   }
          // }
        },
        data: that.data.ai_Interest_y
      }]
    }
  },
  getBarOption2: function () {
    // console.log(JSON.stringify(this.data.tatallData));
    var that = this;
    return {
      grid: {
        left: '15%',
        right: '15%',
        top: '10%',
        bottom: '15%'
      },
      xAxis: {
        type: 'category',
        minInterval: '100',
        boundaryGap: false,
        minInterval: '1',
        data: that.data.ai_active_x,
        axisLabel: {
          showMinLabel: true
        }
      },
      yAxis: {
        type: 'value'
      },

      series: [{
        symbol: 'none',
        data: that.data.ai_active_y,
        type: 'line',
        areaStyle: {
          color: '#e89e9e',
        }
      }]
    }
  },


  //浏览记录
  getBrowse: function () {
    let that = this;
    app.util.request({
      'url': 'entry/wxapp/clientView',
      'cachetime': '30',
      // 
      'method': 'POST',
      'data': {
        client_id: that.data.param.id,
        page: that.data.pageBrowse
      },
      success: function (res) {
        // console.log("entry/wxapp/clientView ==> *****************************",res)
        var tmpData = res.data.data.list;
        if (tmpData.length == 0) {
          that.setData({
            moreBrowse: false,
            loading: false,
            isEmptyBrowse: true,
            show: true
          })
          return false;
        }

        that.setData({
          loading: true
        })

        var tmpListData = that.data.BrowseList;

        if (that.data.onPullDownRefreshBrowse == true) {
          tmpListData = []
        }
        var date = new app.util.date();

        for (let i in tmpData) {
          if (tmpData[i].create_time && tmpData[i].create_time.length < 12) {
            tmpData[i].create_time = date.dateToStr('MM-DD HH:mm', date.longToDate(tmpData[i].create_time * 1000));
          }


          if (tmpData[i].sign == 'praise') {
            if (tmpData[i].type == 2) {
              // console.log("查看名片")
              if (tmpData[i].count == 1) {
                tmpData[i].countText = '，TA正在了解你'
              }
              if (tmpData[i].count == 2 || tmpData[i].count == 3 || tmpData[i].count == 4) {
                tmpData[i].countText = '，你成功的吸引了TA'
              }
              if (tmpData[i].count > 4) {
                tmpData[i].countText = '，高意向客户立刻主动沟通'
              }
            }
          }

          if (tmpData[i].sign == 'view') {
            if (tmpData[i].type == 1) {
              // console.log("查看商城列表"")
              if (tmpData[i].count == 1) {
                tmpData[i].countText = '，尽快把握商机'
              }
              if (tmpData[i].count == 2) {
                tmpData[i].countText = '，潜在购买客户'
              }
              if (tmpData[i].count == 3) {
                tmpData[i].countText = '，高意向客户成交在望'
              }
              if (tmpData[i].count > 3) {
                tmpData[i].countText = '，购买欲望强烈'
              }
            }
            if (tmpData[i].type == 3 || tmpData[i].type == 6) {
              // console.log("查看动态列表"")
              if (tmpData[i].count == 2) {
                tmpData[i].countText = '，赶快主动沟通'
              }
              if (tmpData[i].count > 2) {
                tmpData[i].countText = '，高意向客户成交在望'
              }
            }
            if (tmpData[i].type == 6) {
              // console.log("查看公司官网")
              if (tmpData[i].count == 1) {
                tmpData[i].countText = '，看来TA对公司感兴趣'
              }
            }
          }


          tmpListData.push(tmpData[i]);
        }

        that.setData({
          BrowseList: tmpListData,
          onPullDownRefreshBrowse: false
        })
      }
    })
  },


  getFollow: function () {
    let that = this;
    app.util.request({
      'url': 'entry/wxapp/followList',
      'cachetime': '30',
      // 
      'method': 'POST',
      'data': {
        client_id: that.data.param.id,
        page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/followList ==> ", res)

        if (!res.data.errno) {
          // if (!res.data.errno && res.data.data.data.length > 0) { 
          var tmpData = res.data.data.list;
          if (tmpData.length == 0) {
            that.setData({
              more: false,
              loading: false,
              isEmpty: true,
              show: true
            })
            return false;
          }
          that.setData({
            loading: true
          })

          var tmpListData = that.data.followList;
          if (that.data.onPullDownRefresh == true) {
            tmpListData = []
          }
          var date = new app.util.date();

          for (let i in tmpData) {
            if (tmpData[i].create_time && tmpData[i].create_time.length < 12) {
              tmpData[i].create_time = date.dateToStr('MM-DD HH:mm', date.longToDate(tmpData[i].create_time * 1000));
            }

            tmpListData.push(tmpData[i]);
          }
          var tmpType = that.data.toFollowType;
          for (let i in tmpListData) {
            tmpType.push(0)
          }
          that.setData({
            followList: tmpListData,
            toFollowType: tmpType,
            onPullDownRefresh: false
          })


        }
      }
    })
  },


  getInterest: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Interest',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        client_id: that.data.param.id,
        type: that.data.interest * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          // console.log('1')
          // console.log(res)
          let data = res.data.data
          console.log(data)
          let xx = []
          let yy = []

          if (data.qr) {
            xx.push(`名片${data.qr.count}(${data.qr.rate}%)`)
            yy.push({ value: data.qr.count, name: `名片${data.qr.count}(${data.qr.rate}%)` })
          }
          if (data.timeline) {
            xx.push(`动态${data.timeline.count}(${data.timeline.rate}%)`)
            yy.push({ value: data.timeline.count, name: `动态${data.timeline.count}(${data.timeline.rate}%)` })
          }
          if (data.goods) {
            xx.push(`产品${data.goods.count}(${data.goods.rate}%)`)
            yy.push({ value: data.goods.count, name: `产品${data.goods.count}(${data.goods.rate}%)` })
          }
          if (data.custom_qr) {
            xx.push(`自定义码${data.custom_qr.count}(${data.custom_qr.rate}%)`)
            yy.push({ value: data.custom_qr.count, name: `自定义码${data.custom_qr.count}(${data.custom_qr.rate}%)` })
          }

          if(xx.length == 0){
            xx.push(`暂无数据(100%)`)
            yy.push({ value: 100, name: `暂无数据(100%)` })
          }
          that.setData({
            ai_Interest_x: xx,
            ai_Interest_y: yy
          })

          that.barComponent = that.selectComponent('#mychart');
          that.init_bar('1'); //执行init_bar方法
        }
      }
    })
  },

  getActivity: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Activity',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        client_id: that.data.param.id,
        type: that.data.activity * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          // console.log('2')
          // console.log(res)
          let data = res.data.data.reverse()
          let xx = []
          let yy = []

          data.forEach(val => {
            let aa = val.date
            xx.push(aa.slice(5))
            yy.push(val.count)
          })
          that.setData({
            ai_active_x: xx,
            ai_active_y: yy,
          })
          that.barComponent2 = that.selectComponent('#mychart2');
          that.init_bar('2'); //执行init_bar方法
        }
      }
    })
  },

  getClientInteraction: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/clientInteraction',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        client_id: that.data.param.id,
        type: that.data.client * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          // console.log('3')
          // console.log(res)
          let data = res.data.data
          for (let i in data) {
            let width = parseInt(data[i].rate / 100 * 200)
            data[i].width = width
          }
          // console.log(data)
          that.setData({
            ai_Interaction: data
          })
        }
      }
    })
  },


  getAnalysis: function () {
    let that = this;
    that.getInterest();
    that.getActivity();
    that.getClientInteraction();
  },

  //用户信息
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
        console.log("entry/wxapp/clientInfo ==>", res)
        if (!res.data.errno) {

          let data = res.data.data
          if (data.is_new == '1') {
            data.value1 = '新客户'
          } else if (data.is_new == '2') {
            data.value1 = '跟进中'
          } else if (data.is_new == '3') {
            data.value1 = '已成交'
          }
          that.setData({
            Customer: data
          })
          // console.log(data)
        }
      }
    })
  },
  firsttime: function () {
    let that = this
    app.util.request({
      'url': 'entry/wxapp/firstTime',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        client_id: that.data.param.id
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          // console.log(res)
          that.setData({
            firstTime: res.data.data.time
          })
        }
      }
    })
  },
  biaoqian: function () {
    let that = this
    app.util.request({
      'url': 'entry/wxapp/Labels',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        target_id: that.data.param.id
      },
      success: function (res) {
        // console.log(res)
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          that.setData({
            Labellist: res.data.data
          })
        }
      }
    })
  },
  qq: function () {
    let that = this
    let id = that.data.param.id
    let name = that.data.Customer.nickName
    let img1 = that.data.Customer.avatarUrl
    let clientPhone = that.data.Customer.phone

    app.util.request({
      'url': 'entry/wxapp/Staff',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        target_id: that.data.param.id
      },
      success: function (res) {
        // console.log(that.data.Customer)
        //  console.log(res)
        let img2 = res.data.data.avatarUrl
        wx.navigateTo({
          url: `/longbing_card/chat/staffChat/staffChat?chat_to_uid=${id}&contactUserName=${name}&chatAvatarUrl=${img1}&toChatAvatarUrl=${img2}`
        })
      }
    })
  },
  getFollowEdit: function () {
    var that = this;
    let paramObj = {
      id: that.data.toFolledit,
      content: that.data.content,
    }
    app.util.request({
      'url': 'entry/wxapp/FollowUpdate',
      'cachetime': '30',

      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/FollowUpdate ==> ", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'none',
            title: '已成功修改跟进记录！',
            duration: 1000
          })
          var tmpData = that.data.followList;
          var index = that.data.toFolledit;
          for (let i in tmpData) {
            if (index == tmpData[i].id) {
              tmpData[i].content = that.data.content;
            }
          }
          that.setData({
            followList: tmpData,
            toFolledit: 'toSave',
            currEditInd: '-1',
            content: ''
          })
        }
      }
    })
  },
  getFollowDelete: function (index) {
    var that = this;
    let paramObj = {
      id: that.data.followList[index].id,
    }
    app.util.request({
      'url': 'entry/wxapp/FollowDelete',
      'cachetime': '30',

      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/FollowDelete ==> ", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'none',
            title: '已成功删除跟进记录！',
            duration: 1000
          })
          var tmpData = that.data.followList;
          tmpData.splice(index, 1);
          that.setData({
            followList: tmpData
          })
        }
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var type = e.currentTarget.dataset.type;
    var content = e.currentTarget.dataset.content;

    if (status == 'toCopyright') {
      app.util.goUrl(e)
    }

    if (status == 'toCall') {
      console.log("联系客户")
      if (!content) {
        return false;
      } else {
        wx.makePhoneCall({
          phoneNumber: content,
          success: function (res) {
            // console.log('拨打电话成功 ==>>', res.data);
            if (app.globalData.to_uid != wx.getStorageSync("userid")) {
              that.toCopyRecord(type);
            }
          }
        });
      }
    } else if (status == "toFollowEdit") {
      console.log("编辑")
      var curInd;
      var tmpType = that.data.toFollowType;
      if (type == 1) {
        curInd = '-1';
        tmpType[index] = 0
      }
      if (type == 0) {
        curInd = index;
        tmpType[index] = 1
      }
      that.setData({
        currEditInd: curInd,
        toFollowType: tmpType
      })
    } else if (status == "toFolledit") {
      console.log("修改")
      that.addsRecord();
      that.setData({
        toFolledit: that.data.followList[index].id,
        content: that.data.followList[index].content
      })
    } else if (status == "toFolldelete") {
      console.log("删除")
      that.getFollowDelete(index);
    } else if (status == "toStarMark") {
      console.log("设为星标")
      // that.getFollowDelete(index);
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    var tmpShowStatus = true;
    if (status == 'analysis') {
      tmpShowStatus = false
    }

    that.setData({
      currentIndex: index,
      currentTab: status,
      isShowFooter: tmpShowStatus
    })


    app.util.showLoading(1);
    if (status == 'browse') {
      console.log("浏览记录")
      that.setData({
        onPullDownRefreshBrowse: true
      })
      that.getBrowse();
    } else if (status == 'follow') {
      console.log("跟进记录")
      that.setData({
        onPullDownRefresh: true
      })
      that.getFollow();
    } else if (status == 'analysis') {
      console.log("AI分析")
      that.getAnalysis();
    }
    wx.hideLoading();
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