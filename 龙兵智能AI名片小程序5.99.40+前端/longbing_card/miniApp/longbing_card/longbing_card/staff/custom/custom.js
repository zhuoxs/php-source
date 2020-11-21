const app = getApp();
import * as echarts from '../../templates/ec-canvas/echarts';
var getAppGlobalData = require('../../templates/copyright/copyright.js');
import util from '../../resource/js/xx_util.js';
import { userModel, baseModel } from '../../resource/apis/index.js'

Page({
  data: {
    globalData: {},
    Unchanged: [],//标签
    avatarUrl: '',
    old: [],
    ec: {
      lazyLoad: true // 延迟加载
    },
    tabList: [{ status: 'customer', name: '新增客户' }, { status: 'follow', name: '跟进中' }, { status: 'deal', name: '已成交' }],
    currentIndex: 0,
    lists: [],
    pages: 1,
    total_page: '',//zongyeshu
    typeindex: 1,
    echartslist: [],
    echartsdata: [
      { value: '6', name: '' },
      { value: '4', name: '' },
      { value: '2', name: '' },
    ],
    Record: false,
    Record_label: '0',
    Record_blur: '0',
    Record_input_value: '',
    Record_list: [],
    more: true,
    loading: false,
    show: false,
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    if (status == 'toCopyright') {
      app.util.goUrl(e)
    } else {
      let id = e.currentTarget.dataset.id
      let types
      if (this.data.currentIndex == 0) {
        types = '新客户'
      } else if (this.data.currentIndex == 1) {
        types = '跟进中'
      } else {
        types = '已完成'
      }
      wx.navigateTo({
        url: `/longbing_card/staff/custom/detail/detail?id=${id}&&type=${types}`
      })
    }

  },
  PostRequest: function (url, page, typeindex) {
    var that = this;
    app.util.request({
      'url': `entry/wxapp/${url}`,
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: page,
        type: typeindex
      },
      success: function (res) {
        // console.log(res)
        if (!res.data.errno) {
          let list = res.data.data.list
          if (list) {
            let timestamp = Date.parse(new Date());
            timestamp = (timestamp.toString()).substring(0, 10);
            let oldlist = that.data.lists
            if (that.data.onPullDownRefresh == true) {
              oldlist = []
            }
            // console.log(list)
            for (let i in list) {
              if (list[i].last_time > 0) {
                let aa = timestamp - list[i].last_time
                let bb = aa / 86400
                if (bb > 1) {
                  list[i].days = parseInt(bb)
                } else {
                  list[i].hours = parseInt(bb * 24)
                }
                oldlist.push(list[i])
              } else {
                oldlist.push(list[i])
              }
            }
            // console.log(oldlist)
            that.setData({
              lists: oldlist,
              total_page: res.data.data.total_page,
              onPullDownRefresh: false
            })
            //  console.log(that.data.lists)
          }
          else {
            //   wx.showToast({
            //     title:'暂时没有数据'
            //   })

            that.setData({
              more: false,
              loading: false,
              show: true
            })
          }
        }
      }
    })
  },
  onLoad: function (options) {
    let that = this
    app.util.showLoading(1);
    getAppGlobalData.getAppGlobalData(that, baseModel, util);

    wx.hideShareMenu();
    that.PostRequest('clientList', this.data.pages, this.data.typeindex)

    for (let i = 0; i < this.total_page + 1; i++) {
      if (that.data.lists.length < 7) {
        that.onReachBottom()
      } else {
        i = this.total_page + 1
      }
    }

    let page = this.data.page
    //获取员工信息
    app.util.request({
      'url': 'entry/wxapp/Staff',
      'cachetime': '30',
      'method': 'POST',
      'data': {},
      success: function (res) {
        // console.log(res)
        that.setData({
          job_id: res.data.data.info.job_id
        })
      }
    })

    that.getTurnoverRateTotal();
    wx.hideLoading();
  },
  getTurnoverRateTotal: function () {
    var self = this;
    //获取用户跟进以及成交总用户数
    app.util.request({
      'url': 'entry/wxapp/turnoverRateTotal',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        if (!res.data.errno) {
          let list = res.data.data
          console.log(res.data.data)

          if (self.data.onPullDownRefresh == true) {
            self.setData({
              echartslist: [],
              echartsdata: [],
            })
          }

          let datas = self.data.echartslist

          let dfu = []
          dfu.push(list.deals)
          dfu.push(list.follows)
          dfu.push(list.users)

          let dfu2 = []
          dfu2.push(60)
          dfu2.push(80)
          dfu2.push(100)

          let setVal = ['成交数量:', '跟进数量:', '总用户数:']

          for (let i in setVal) {
            datas.push({ name: setVal[i] + dfu[i], value: dfu2[i] })
          }

          self.setData({
            echartsdata: datas
          })
          // console.log(datas)
          // 页面初始化 options为页面跳转所带来的参数 
          self.barComponent = self.selectComponent('#mychart');
          self.init_bar(); //执行init_bar方法
          // console.log(that.data.echartsdata)
        }
      }
    })
  },
  //点击搜索
  searchclick: function (e) {
    let old = wx.getStorageSync(this.data.job_id)
    if (old) {
      // console.log(old)
      this.setData({
        old: old,
      })
    }

    this.setData({
      Record: true,
    })
    var that = this;

    app.util.request({
      'url': 'entry/wxapp/oftenLabel',
      'cachetime': '30',
      'method': 'POST',
      'data': {},
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
          that.setData({
            Unchanged: res.data.data
          })
        }
      }
    })
  },
  searchover: function (e) {
    this.setData({
      Record: false,
      Record_label: '0',
      Record_blur: '0',
      Record_input_value: '',
      moreSearch: true,
      isEmptySearch: false,
      showSearch: false
    })
  },
  //搜索框
  Record_focuse: function (e) {
    this.setData({
      Record_label: '1',
      Record_list: []
    })
  },
  Record_blur: function (e) {
    var that = this;
    if (!e.detail.value) {
      this.setData({
        Record_label: '0',
        Record_list: []
      })
    } else {
      let old = that.data.old
      if (old[0]) {

        let aa = false
        old.forEach(val => {
          if (val == e.detail.value) {
            aa = true
          }
        })
        if (!aa) {
          if (old.length < 3) {
            old.push(e.detail.value)
          } else {
            old.push(e.detail.value)
            old = old.slice(-3)
          }
        }
      } else {
        old.push(e.detail.value)
      }

      wx.setStorageSync(that.data.job_id, old)

      this.setData({
        Record_input_value: e.detail.value,
        Record_blur: '1',
        Record_label: '1',
        old: old
      })

      var keyword = e.detail.value;
      that.toGetSearchList(keyword);

    }
  },
  clickUnchanged: function (e) {
    var that = this;
    console.log(e)
    this.setData({
      Record_input_value: e.currentTarget.dataset.name,
      Record_blur: '1',
      Record_label: '1'
    })

    var keyword = e.currentTarget.dataset.name;
    that.toGetSearchList(keyword);
  },
  toGetSearchList: function (keyword) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/search',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        type: '1',
        keyword: keyword
      },
      success: function (res) {
        console.log("entry/wxapp/aiTime ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          if (tmpData.length == 0) {
            that.setData({
              moreSearch: false,
              isEmptySearch: true,
              showSearch: true
            })
            return false;
          }
          var tmpRecordList = that.data.Record_list;
          tmpRecordList = tmpData.data;
          that.setData({
            Record_list: tmpRecordList
          })
        }
      }
    })
  },
  init_bar: function () {
    var self = this;
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
  },
  getBarOption: function () {
    // console.log(JSON.stringify(this.data.tatallData));
    // console.log(this.data.echartslist)
    let list = this.data.echartslist
    let data = this.data.echartsdata.reverse()
    // console.log(list)
    // console.log(data)
    var that = this;
    return {
      legend: {
        data: list,
        top: '10',
      },
      color: ["#91c7ae", "#d48265", "#c23531"],
      calculable: true,
      funnelAlign: 'left',
      series: [
        {
          name: '漏斗图',
          type: 'funnel',
          top: '50',
          bottom: '20',
          left: '20%',
          min: 40,
          max: 100,
          minSize: '40%',
          maxSize: '100%',
          width: '60%',
          sort: 'descending',
          legendHoverLink: true,
          gap: 2,
          label: {
            normal: {
              show: true,
              position: 'inside'
            },
            emphasis: {
              textStyle: {
                fontSize: 20
              }
            }
          },
          data: data
        }
      ]
    }
  },
  onReady: function () {
    // console.log("页面渲染完成")

  },
  onShow: function () {
    // 页面显示 

  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  // console.log("监听用户下拉动作") 
  onPullDownRefresh: function () {

    var that = this;
    that.setData({
      pages: 1,
      onPullDownRefresh: true
    })
    that.getTurnoverRateTotal();
    that.PostRequest('clientList', this.data.pages, this.data.typeindex);
    wx.showNavigationBarLoading();
    wx.stopPullDownRefresh();

  },
  // console.log("监听页面上拉触底") 
  onReachBottom: function () {
    var that = this;
    let page = this.data.pages
    page++
    if (page > this.data.total_page) {
      // wx.showToast({
      //   title:'没有更多了'
      // })
      that.setData({
        more: false,
        loading: false,
        show: true
      })
    } else {
      this.setData({
        pages: page
      })
      this.PostRequest('clientList', this.data.pages, this.data.typeindex)
    }

  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  },
  formSubmit: function (e) {

    this.setData({
      pages: 1,
      lists: []
    })

    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    // that.toSaveFormIds(formId);

    that.setData({
      currentIndex: index,
    })
    if (status == 'customer') {
      this.setData({
        typeindex: 1
      })
      that.PostRequest('clientList', this.data.pages, this.data.typeindex)
      // console.log("新增客户") 
    } else if (status == 'follow') {
      this.setData({
        typeindex: 2
      })
      that.PostRequest('clientList', this.data.pages, this.data.typeindex)
      // console.log("跟进中") 
    } else if (status == 'deal') {
      this.setData({
        typeindex: 3
      })
      that.PostRequest('clientList', this.data.pages, this.data.typeindex)
      // console.log("已成交") 
    } else if (status == 'toHome') {
      console.log("返回首页")
      wx.reLaunch({
        // wx.navigateTo({
        url: '/longbing_card/pages/index/index?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard'
      })
    }
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
      }
    })
  }
})