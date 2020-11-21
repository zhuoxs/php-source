//初始化数据
function tabbarinit() {
  return [
    { 
      "current":0,
      "pagePath": "../index/index",
      "text": "首页",
      "iconPath": "../../resource/images/tabbar/index.png",
      "selectedIconPath": "../../resource/images/tabbar/index_s.png"
    },
    {
      "current": 0,
      "pagePath": "../seller/seller",
      "text": "商家",
      "iconPath": "../../resource/images/tabbar/seller.png",
      "selectedIconPath": "../../resource/images/tabbar/seller_s.png"
    },
    {
      "current": 0,
      "pagePath": "../fabu/fabu",
      "text": "发布",
      "iconPath": "../../resource/images/tabbar/fabu.png",
      "selectedIconPath": "../../resource/images/tabbar/fabu.png"
    },
    {
      "current": 0,
      "pagePath": "../circle/circle",
      "text": "圈子",
      "iconPath": "../../resource/images/tabbar/circle.png",
      "selectedIconPath": "../../resource/images/tabbar/circle_s.png"
    },
    {
      "current": 0,
      "pagePath": "../mine/mine",
      "text": "我的",
      "iconPath": "../../resource/images/tabbar/mine.png",
      "selectedIconPath": "../../resource/images/tabbar/mine_s.png"
    }
  ]
}
function aaa(res,url){
  console.log(1);
  console.log(res);
  console.log(2);
  var key = res.data.key;
  if (key==0) {
    var tabar = [{}, {}, {}, {}, {}];
    tabar[2].current = 0;
    tabar[2].pagePath = '../fabu/fabu';
    tabar[2].text = res.data.db_name3;
    tabar[2].iconPath = url + res.data.pic_three;
    tabar[2].selectedIconPath = url + res.data.pic_three1;

    tabar[3].current = 0;
    tabar[3].pagePath = '../circle/circle';
    tabar[3].text = res.data.db_name4;
    tabar[3].iconPath = url + res.data.pic_four;
    tabar[3].selectedIconPath = url + res.data.pic_four1;

    tabar[4].current = 0;
    tabar[4].pagePath = '../mine/mine';
    tabar[4].text = res.data.db_name5;
    tabar[4].iconPath = url + res.data.pic_five;
    tabar[4].selectedIconPath = url + res.data.pic_five1;
  } else {
    var tabar = [{}, {}, {}];
    // tabar[2].current = 0;
    // tabar[2].pagePath = '../circle/circle';
    // tabar[2].text = res.data.db_name4;
    // tabar[2].iconPath = url + res.data.pic_four;
    // tabar[2].selectedIconPath = url + res.data.pic_four1;

    tabar[2].current = 0;
    tabar[2].pagePath = '../mine/mine';
    tabar[2].text = res.data.db_name5;
    tabar[2].iconPath = url + res.data.pic_five;
    tabar[2].selectedIconPath = url + res.data.pic_five1;
  }
  tabar[0].current = 0;
  tabar[0].pagePath = '../index/index';
  tabar[0].text = res.data.db_name1;
  tabar[0].iconPath = url+res.data.pic_one;
  tabar[0].selectedIconPath = url+res.data.pic_one1;

  tabar[1].current = 0;
  tabar[1].pagePath = '../seller/seller';
  tabar[1].text = res.data.db_name2;
  tabar[1].iconPath = url+res.data.pic_tow;
  tabar[1].selectedIconPath = url+res.data.pic_tow1;

  return tabar;
}
/**
 * tabbar主入口
 * @param  {String} bindName 
 * @param  {[type]} id       [表示第几个tabbar，以0开始]
 * @param  {[type]} target   [当前对象]
 */
function tabbarmain(bindName = "tabdata", id, target, tabar,url) {
  var that = target;
  var bindData = {};
  console.log(url)
  var otabbar = aaa(tabar,url);
  otabbar[id]['iconPath'] = otabbar[id]['selectedIconPath']//换当前的icon
  otabbar[id]['current'] = 1;
  bindData[bindName] = otabbar;
  bindData['url'] = url;
  console.log(bindData);
  that.setData({ bindData});

}


module.exports = {
  tabbar: tabbarmain
}