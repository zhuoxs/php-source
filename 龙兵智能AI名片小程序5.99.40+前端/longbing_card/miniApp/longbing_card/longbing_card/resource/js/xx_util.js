
import Validate from './validate.js';
export default {
  Validate,
  //格式化时间
  formatTime(date, format) {
    let newFormat = format || 'YY-M-D h:m:s';
    let formatNumber = this.formatNumber;
    let newDate = date || new Date();
    if (Object.prototype.toString.call(newDate).slice(8, -1) !== "Date") {
      newDate = new Date(date);
    }
    let week = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', '日', '一', '二', '三', '四', '五', '六'];
    return newFormat.replace(/YY|Y|M|D|h|m|s|week|星期/g, function (a) {
      switch (a) {
        case 'YY':
          return newDate.getFullYear();
        case 'Y':
          return (newDate.getFullYear() + '').slice(2);
        case 'M':
          return formatNumber(newDate.getMonth() + 1);
        case 'D':
          return formatNumber(newDate.getDate());
        case 'h':
          return formatNumber(newDate.getHours());
        case 'm':
          return formatNumber(newDate.getMinutes());
        case 's':
          return formatNumber(newDate.getSeconds());
        case '星期':
          return "星期" + week[newDate.getDay() + 7];
        case 'week':
          return week[newDate.getDay()];
      }
    })
  },
  //格式化数字
  formatNumber(n) {
    n = n.toString();
    return n[1] ? n : '0' + n
  },

  /**
   * 人性话格式时间
   */
  ctDate(date) {
    const minute = 1000 * 60;
    const hour = minute * 60;
    const day = hour * 24;
    const month = day * 30;


    if (!date) return "";
    const now = Date.now();
    let diffValue;
    let result;
    date = typeof date === "number" ? date : +(new Date(date));
    diffValue = now - date;

    let monthC = diffValue / month;
    let weekC = diffValue / (7 * day);
    let dayC = diffValue / day;
    let hourC = diffValue / hour;
    let minC = diffValue / minute;

    if (monthC >= 1) {
      result = parseInt(monthC) + "个月前";
    }
    else if (weekC >= 1) {
      result = parseInt(weekC) + "个星期前";
    }
    else if (dayC >= 1) {
      result = parseInt(dayC) + "天前";
    }
    else if (hourC >= 1) {
      result = parseInt(hourC) + "个小时前";
    }
    else if (minC >= 1) {
      result = parseInt(minC) + "分钟前";
    } else {
      result = "刚刚发表";
    }

    return result;
  },

  //返回类型
  typeOf(param) {
    return Object.prototype.toString.call(param).slice(8, -1)
  },
  //判断是否为空
  isEmpty(param) {

    //基本类型为空
    let condition1 = param === '' || param === null || param === undefined || param === "NaN";
    let condition2;
    let condition3
    //引用类型为空
    if (!condition1) {
      condition2 = this.typeOf(param) === "Object" && Object.keys(param).length < 1;
      condition3 = this.typeOf(param) === "Array" && param.length < 1;
    }


    return condition1 || condition2 || condition3;
  },
  
  //检查授权
  checkAuth(name) {
    let that = this;
    return new Promise((resove, reject) => {
      wx.getSetting({
        success(res) {
          if (res.authSetting[`scope.${name}`]) {
            resove(true)
          } else {
            resove(false)
          }
        },
        fail() {
          that.networkError()
        }
      })
    })
  },
  getLocation(){
    let that=this;
    return new Promise((resove, reject)=>{
      wx.getLocation({
        success: function (res) {
          resove(res)
        },
        fail: function (res) {
          console.log(res)
          let errMsg = res.errMsg;
          if (errMsg.indexOf('fail auth deny') > -1) that.authFail("地理位置")
        }
      })
    })
  },
  authFail(msg){
    wx.showModal({
      title: '未授权',
      content: `获得${msg}权限才可以使用该功能，去设置中开启?`,
      showCancel: true,
      success: function(res) {
        if(res.confirm){
          wx.navigateTo({
            url: '/pages/common/auth/auth?openType=openSetting',
          })
        }
      }
    })
  },
  //网络错误提示
  networkError({ msg = "网络错误" } = {}) {
    console.log()
    this.hideAll();
    if (this.getPage().onPullDownRefresh) {
      wx.showModal({
        title: "网络提示",
        content: `${msg},请检查网络后刷新`,
        confirmText: '立即刷新',
        cancelText: '等会刷新',
        success(res) {
          if (res.confirm) {
            wx.startPullDownRefresh()
          }
        }
      })
    }else{
      this.showFail(msg)
    }
    
  },
  /* 打开提示信息 */
  showModal({ title = '提示', content = "服务器错误" } = {}) {
    wx.showModal({
      title,
      content,
      showCancel: false
    })
  },
  showModalText(title,content) {
    wx.showModal({
      title,
      content,
      showCancel: false
    })
  },
  showLoading({title = "加载中",mask=true}={}) {
    wx.showLoading({
      title,
      mask
    })
  },
  showSuccess(title = "操作成功") {
    wx.showToast({
      title,
    })
  },
  showFail(title = "操作失败") {
    wx.showToast({
      title,
      icon: 'none'
    })
  },
  hideLoading() {
    wx.hideLoading()
  },
  /* 隐藏所有提示信息 */
  hideAll() {
    wx.hideLoading();
    wx.stopPullDownRefresh();
    wx.hideNavigationBarLoading();
  },
  
  //获取标签上data
  getData(e) {
    return e.currentTarget.dataset
  },
  //获取标签上data
  getFromData(e) {
    return e.detail.target.dataset
  },
  //跳转
  goUrl(e,isFrom = false) {
    let { url, method } = isFrom ? this.getFromData(e) : this.getData(e);
    method = method || "navigateTo";
    if (!url) {
      return;
    }
    
	//聊天界面复制内容
	if (url.indexOf('copy:') > -1) {
		url = url.split(':')[1];
		var reg = /^\d{7,23}$/;
		if (reg.test(url)) {
			console.log("纯数字")
			wx.showActionSheet({
				itemList: ['呼叫', '复制', '添加到手机通讯录'],
				success: function (res) {
					if (res.tapIndex == 0) {
						console.log("呼叫")
						wx.makePhoneCall({
							phoneNumber: url,
						})
					} else if (res.tapIndex == 1) {
						console.log("复制")
						wx.setClipboardData({
							data: url,
							success: function (res) {
								console.log(res)
								wx.getClipboardData({
									success: function (res) {
										console.log('复制文本成功 ==>>', res.data);
									}
								});
							}
						});
					} else if (res.tapIndex == 2) {
						console.log("添加到手机通讯录")
						wx.addPhoneContact({
							firstName: ' ',
							mobilePhoneNumber: url,
							success: function (res) {
								console.log("添加到手机通讯录 ==> ", res)
							},
							fail: function (res) {
								console.log("添加到手机通讯录fail ==> ", res)
							}
						})
					}
				}
			})
		} else {
			console.log("纯文本")
			wx.setClipboardData({
				data: url,
				success: function (res) {
					wx.getClipboardData({
						success: function (res) {
							console.log('复制文本成功 ==>>', res.data);
						}
					});
				}
			});
		}
		return;
	}
	//复制文本
	if (url.indexOf('toCopy:') > -1) {
		url = url.split(':')[1],
			wx.setClipboardData({
				data: url,
				success: function (res) {
					wx.getClipboardData({
						success: function (res) {
							console.log('复制文本成功 ==>>', res.data);
						}
					});
				}
			});
		return;
	}
	//拨打电话
	if (url.indexOf('tel:') > -1) {
		wx.makePhoneCall({
			phoneNumber: url.split(':')[1],
		})
		return;
	}
	//网页跳转
	if (url.indexOf('http') > -1) {
		url = encodeURIComponent(url);
		// console.log("网页跳转 util")
		wx.navigateTo({
			url: `/longbing_card/common/webview/webview?url=${url}`,
		})
		return;
	}
	//小程序跳转
	if (url.indexOf('wx') == 0) {
		var appIdData, pathData = '', envVersionData = 'release';

		var urlArr = url.split(':');
		if (urlArr.length == 1) {
			appIdData = urlArr[0];
		} else if (urlArr.length == 2) {
			appIdData = urlArr[0];
			pathData = urlArr[1];
		} else if (urlArr.length == 3) {
			appIdData = urlArr[0];
			pathData = urlArr[1];
			envVersionData = urlArr[2];
		}

		wx.navigateToMiniProgram({
			appId: appIdData,
			path: pathData,
			extraData: {
				lb: 'longbing'
			},
			envVersion: envVersionData,
			success(res) {
				// 打开成功
			},
      complete(res){
        console.log("跳转小程序",res)
      }
		})


		return;
	}
	//正常页面跳转
	wx[method]({
		url
    })
  },
  //获表单控件值
  getValue(e) {
    return e.detail.value
  },
  //格式化参数对象
  setOptions(o) {
    return encodeURIComponent(JSON.stringify(o))
  },
  //解析参数对象
  getOptions(o) {
    return JSON.parse(decodeURIComponent(o))
  },
  //获取页面对象，0时为当前页面
  getPage(index = 0) {
    let pages = getCurrentPages();
    let page = pages[pages.length - 1 + index]
    return page
  },
  //动态设置上导航信息
  setNavbar(navbar) {
    if (this.isEmpty(navbar)) {
      return;
    }
    let { frontColor, backgroundColor, title } = navbar
    if (!this.isEmpty(title)) {
      wx.setNavigationBarTitle({
        title
      })
    }
    if (!this.isEmpty(backgroundColor) && !this.isEmpty(frontColor)) {
      wx.setNavigationBarColor({
        frontColor,
        backgroundColor,
      })
    }
  },
  //动态设置下导航信息
  setTabbar(tabbar) {
    if (this.isEmpty(tabbar)) {
      return;
    }
    let { color, selectedColor, backgroundColor, borderStyle, list } = tabbar;
    wx.setTabBarStyle({
      color,
      selectedColor,
      backgroundColor,
      borderStyle
    })
    for (let i in list) {
      let { id, text, iconPath, selectedIconPath } = list[i]
      wx.setTabBarItem({
        index:id-1,
        text,
        iconPath,
        selectedIconPath
      })
    }
  },
  //发起支付
  pay(orderInfo) {
    return new Promise((resove, reject) => {
      wx.requestPayment({
        timeStamp: orderInfo.timeStamp,
        nonceStr: orderInfo.nonceStr,
        'package': orderInfo.package,
        signType: orderInfo.signType,
        paySign: orderInfo.paySign,
        success: function (res) {
          resove(true)
        },
        fail: function (res) {
          resove(false)
        },
        complete: function (res) {
          console.log(res)
        },
      })
    })
  },
  
  //获取当前页面配置
  getPageConfig(pages) {
    if (this.isEmpty(pages)) {
      return false;
    }
    let route = this.getPage().route
    let currentPageConfig = pages[route] || false;
    return currentPageConfig

  },
  //深拷贝
  deepCopy(o) {
    let that=this;
    if (o instanceof Array) {
      var n = [];
      for (var i = 0; i < o.length; ++i) {
        n[i] = that.deepCopy(o[i]);
      }
      return n;
    } else if (o instanceof Function) {
      var n = new Function("return " + o.toString())();
      return n
    } else if (o instanceof Object) {
      var n = {}
      for (var i in o) {
        n[i] = that.deepCopy(o[i]);
      }
      return n;
    } else {
      return o;
    }
  },
 
  //根据数据获取id字符串
  getIds: function (o) {
    let ids = [];
    o = o || [];
    o.forEach((item) => {
      ids.push(item.id)
    })
    return ids.join(',');
  },
  // getLocation:function(){
  //   //定位
  //   let that=this;
  //   let bmap = require('./bmap-wx.min.js');
  //   let BMap = new bmap.BMapWX({ ak: 'GoI7BxLpfvBEyf1TcMXCloi99Vov7flZ'});
  //   return new Promise((resolve,reject)=>{
  //     BMap.regeocoding({
  //       success: function (data) {
  //         let addressInfo = data.originalData.result;
  //         //成功回调
  //         resolve(addressInfo)
  //       },
  //       fail: function (info) {
  //         console.log(info)
  //         //失败回调
  //         resolve(false)
  //       }
  //     })
  //   })
  // },
  searchSubStr: function (str, subStr){
    let positions = [];
    let pos = str.indexOf(subStr);
    while (pos > -1) {
      positions.push(pos);
      pos = str.indexOf(subStr, pos + 1);
    }
    return positions
  },
  //将一个数组根据规则分为两个
  partition:function(arr, isValid){
    arr.reduce(
      ([pass, fail], elem) =>
        isValid(elem) ? [[...pass, elem], fail] : [pass, [...fail, elem]],
      [[], []],
    )
  },
  /*
  * 获取链接某个参数
  * url 链接地址
  * name 参数名称
  */
  getUrlParam: function (url, name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象  
    var r = url.split('?')[1].match(reg);  //匹配目标参数  
    if (r != null) return unescape(r[2]); return null; //返回参数值  
  }
  

}