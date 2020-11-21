require.config({
    // baseUrl: '../addons/kundian_farm/resource/home/js/',
    paths: {
        'jquery': '../../../../addons/kundian_farm/resource/home/jquery.min',
        'Vue': '../../../../addons/kundian_farm/resource/home/js/vue',
        'VueDragging': '../../../../addons/kundian_farm/resource/home/js/vue-dragging.es5',
        'VueLazyload': '../../../../addons/kundian_farm/resource/home/js/vue-lazyload'
    }
});

require([
    'jquery',
    'Vue',
    'VueDragging',
    'VueLazyload'
],  function ($, Vue, VueDragging,VueLazyload){
    Vue.use(VueDragging)
    Vue.use(VueLazyload, {
        preLoad: 1.3,
        error: '../../../../addons/kundian_farm/resource/home/images/default.jpg',
        loading: '../../../../addons/kundian_farm/resource/home/images/default.jpg',
        attempt: 1
    })
    var VM = new Vue({
        el: '#app',
        data: {
            defaultTypes: [//所有类型的默认数据
                {
                    id: 0,
                    type: 'banner',
                    imgUrl: [{
                        img: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                        url: '1'
                    }],
                    focus: true,
                    focusColor: '#ffffff',
                    swiperHeight: 375
                },
                {
                    id: 0,
                    type: 'navigation',
                    column: 4,
                    fontColor: "#333333",
                    fontSize: 12,
                    radius: 50,
                    list: [{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    },{
                        title: '按钮文字1',
                        url: '../../../../addons/kundian_farm/resource/home/images/icon-1.png',
                        direction: '../index/index'
                    }

                    ]
                },
                {
                    id: 0,
                    type: 'blank',
                    bgColor: '#eeeeee',
                    height: 20
                },
                {
                    id: 0,
                    type: 'headline',
                    text: '这是标题',
                    fontColor: '#333333',
                    fontSize: 15,
                    bgColor: '#999999',
                    padTb: 10,
                    padLr: 10,
                    align: 'left',
                    link: '',
                    link_title:'',
                    link_type:'',
                    link_param:'',
                    icon: ''
                },
                {
                    id: 0,
                    type: 'search',
                    searchColor: '#ffffff',
                    bgColor: '#ffffff',
                    fontColor: '#333333',
                    hotSearch: '请输入关键字进行搜索',
                    mtb: 10,
                    mlr: 10,
                    radius: 10
                },
                {
                    id: 0,
                    type: 'line',
                    styles: 'solid',
                    lineColor: '#000000',
                    bgColor: '#ffffff',
                    lineHeight: 1,
                    height: 10
                },
                {
                    id: 0,
                    type: 'glossary',
                    styles: 1,
                    titleSize: 18,
                    titleColor: '#000000',
                    bgColor: '#ffffff',
                    lists: [{
                        img: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                        title: '我是标题',
                        innerText: '我是图文内容',
                        direction: ''
                    }]
                },
                {
                    id: 0,
                    type: 'button',
                    parma: {
                        text: '我是按钮',
                        radius: 50,
                        border: false,
                        icon: true,
                        url: 'https://wx.cqkundian.com/addons/ybgw_001/core/public/menu/images/kefu.png',
                        link: '',
                        fontColor: '#ffffff',
                        bgColor: '#0da3f9',
                        borderColor: '#ff0000'
                    }
                },
                {
                    id: 0,
                    type: 'pictureList',
                    styles: 1,
                    column: 2,
                    radius: 0,
                    lists: [{
                        img: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                        title: '我是标题',
                        direction: ''
                    }]
                },
                {
                    id: 0,
                    type: 'fixed',
                    bottom: 90,
                    left: 80,
                    opacity: 1,
                    bgColor: '#808080',
                    img: 'https://wx.cqkundian.com/addons/ybgw_001/core/public/menu/images/kefu.png',
                    direction: ''
                },
                {
                    id: 0,
                    type: 'video',
                    src: 'http://wxsnsdy.tc.qq.com/105/20210/snsdyvideodownload?filekey=30280201010421301f0201690402534804102ca905ce620b1241b726bc41dcff44e00204012882540400&bizid=1023&hy=SH&fileparam=302c020101042530230204136ffd93020457e3c4ff02024ef202031e8d7f02030f42400204045a320a0201000400',
                    poster: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                    autoPlay: false
                },
                {
                    id: 0,
                    type: 'audio',
                    poster: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                    src: 'http://ws.stream.qqmusic.qq.com/M500001VfvsJ21xFqb.mp3?guid=ffffffff82def4af4b12b3cd9337d5e7&uin=346897220&vkey=6292F51E1E384E06DCBDC9AB7C49FD713D632D313AC4858BACB8DDD29067D3C601481D36E62053BF8DFEAF74C0A5CCFADD6471160CAF3E6A&fromtag=46',
                    name: '此时此刻',
                    author: '许巍',
                },
                {
                    id: 0,
                    type: 'advert',
                    selectType: 1,
                    height: 150,
                    adLists: [{
                        img: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                        width: 50,
                        direction: ''
                    }]
                },
                {
                    id: 0,
                    type: 'coupon',
                    height: 150,
                    adLists: [{
                        img: '../addons/kundian_farm/resource/home/images/coupon-img.png',
                    }],
                },
                {
                    id: 0,
                    type: 'weather',
                    height: 150,
                    adLists: [{
                        img: '../addons/kundian_farm/resource/home/images/weather-img.png',
                    }],
                },
                {
                    id: 0,
                    type: 'information',
                    height: 150,
                    adLists: [{
                        img: '../addons/kundian_farm/resource/home/images/article-img.png',
                    }],
                },
                {
                    id: 0,
                    type: 'btnclounm',
                    height: 240,
                    adLists: [{
                        img: '../addons/kundian_farm/resource/home/images/three-img.png',
                    }],
                },
                {
                    id: 0,
                    type: 'team',
                    height: 240,
                    adLists: [{
                        img: '../addons/kundian_farm/resource/home/images/team-img.png',
                    }],
                },
                {
                    id: 0,
                    type: 'prolist',
                    fontColor: '#333333',
                    priceColor: '#333333',
                    btnColor: '#333333',
                    listType:1,
                    selectType: 1,
                    selectGroup: 1,
                    selectNum: 2,
                    lists: [],
                    newList: [{
                        cover: '../../../../addons/kundian_farm/resource/home/images/goods-1.jpg',
                        goods_name: '这里是商品标题(商品从设定商品中读取)',
                        price: '20.00',
                        goods_remark:'商品简单说明',
                    },
                        {
                            cover: '../../../../addons/kundian_farm/resource/home/images/goods-1.jpg',
                            goods_name: '这里是商品标题(商品从设定商品中读取)',
                            price: '20.00',
                            goods_remark:'商品简单说明',
                        }
                    ]
                },
                {
                    id: 0,
                    type: 'active',
                    lists: [
                        {
                            cover:"../../../../addons/kundian_farm/resource/home/images/goods-3.jpg",
                            title:"这是一个活动标题",
                            person_count:20,
                            min_price:0
                        }
                    ]
                },
                {
                    id:0,
                    type: 'crowd',
                    selectType:1,
                    lists:[
                        {
                            cover:"../../../../addons/kundian_farm/resource/home/images/goods-3.jpg",
                            project_name:"这是一个众筹标题",
                            cycle:20,
                            min_price:0,
                            target_money:1000,
                            return_percent:15
                        }
                    ]
                },
                {
                    id:0,
                    type: 'official',
                    lists:[]
                }
            ],
            allLists: [],//所有数据
            currentType: '',//当前的类型
            currentId:0, //当前类型id
            MaxId:0,//用来设置新增类型的id
            showLinkDialog:false,  //是否显示链接选择弹框
            currentDeleteId: 0,//当前需要删除的组件Id
            iconList: [],//存储图标数组
            loading: false,//是否正在加载中
            shopList: [], //后端获取的商品列表
            currentReplaceShopId: 0,//当前需要替换的商品Id
            isAddOrReplace: 0,//判断商品列表是新增还是替换，1为替换， 2为新增
            alertText: '',//提示文字
            activeList:[],//获取的活动列表
            crowdList: [], //获取的众筹列表
        },

        //初始化页面获取数据
        created() {
            $.ajax({
                url: url,
                type: 'Get',
                success:function(res){
                    var page=JSON.parse(res);
                    if(page.pageData){
                        VM.allLists=page.pageData;
                        VM.MaxId=page.maxId;
                    }
                }
            })
        },
        mounted: function() {
            this.$dragging.$on('dragged', function(data) {
            })
        },
        computed: {
            bannerHeight: {//设置banner的高度
                get() {
                    let height
                    this.allLists.map(item => {
                        if (item.type === 'banner' && item.id === this.currentId) {
                            height = item.swiperHeight
                        }
                    })
                    return height
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'banner' && item.id === this.currentId) {
                            item.swiperHeight = newValue
                        }
                    })
                }
            },
            setBannerFocusColor: {//设置轮播焦点的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'banner' && item.id === this.currentId) {
                            color = item.focusColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'banner' && item.id === this.currentId) {
                            item.focusColor = newValue
                        }
                    })
                }
            },
            blank_bgColor: {//设置空白的背景颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'blank' && item.id === this.currentId) {
                            color = item.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'blank' && item.id === this.currentId) {
                            item.bgColor = newValue
                        }
                    })
                }
            },
            setBlankHeight: {//设置辅助空白的高度
                get() {
                    let height
                    this.allLists.map(item => {
                        if (item.type === 'blank' && item.id === this.currentId) {
                            height = item.height
                        }
                    })
                    return height
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'blank' && item.id === this.currentId) {
                            item.height = newValue
                        }
                    })
                }
            },
            setNavRdadius: {//设置导航图标的radius
                get() {
                    let radius
                    this.allLists.map(item => {
                        if (item.type === 'navigation' && item.id === this.currentId) {
                            radius = item.radius
                        }
                    })
                    return radius
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'navigation' && item.id === this.currentId) {
                            item.radius = newValue
                        }
                    })
                }
            },
            setNavFontColor: {//设置导航文字的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'navigation' && item.id === this.currentId) {
                            color = item.fontColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'navigation' && item.id === this.currentId) {
                            item.fontColor = newValue
                        }
                    })
                }
            },


            setHeadLineText: {//设置标题的文字
                get() {
                    let text
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            text = item.text
                        }
                    })
                    return text
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.text = newValue
                        }
                    })
                }
            },

            setHeadLineAppid: {//设置标题跳转的appid
                get() {
                    let appid
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            appid = item.appid
                        }
                    })
                    return appid
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.appid = newValue
                        }
                    })
                }
            },

            getHeaderLink() {
                let link
                this.allLists.map(item => {
                    if (item.type === 'headline' && item.id === this.currentId) {
                        console.log(item.link_title);
                        console.log(item.link);
                        link = item.link_title
                    }
                })
                return link
            },
            setHeadLineBgColor: {//设置标题的背景颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            color = item.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.bgColor = newValue
                        }
                    })
                }
            },
            setHeadLineColor: {//设置标题文字的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            color = item.fontColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.fontColor = newValue
                        }
                    })
                }
            },

            setHeadlineFontSize: {//设置标题的文字大小
                get() {
                    let size
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            size = item.fontSize
                        }
                    })
                    return size
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.fontSize = newValue
                        }
                    })
                }
            },

            setHeadlineMtb: {//设置标题的上下边距
                get() {
                    let size
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            size = item.padTb
                        }
                    })
                    return size
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.padTb = newValue
                        }
                    })
                }
            },
            setHeadlineMlr: {//设置标题的左右边距
                get() {
                    let size
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            size = item.padLr
                        }
                    })
                    return size
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'headline' && item.id === this.currentId) {
                            item.padLr = newValue
                        }
                    })
                }
            },

            setSearchColor: {//设置搜索框的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            color = item.searchColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            item.searchColor = newValue
                        }
                    })
                }
            },
            setSearchBgColor: {//设置搜索框的背景颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            color = item.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            item.bgColor = newValue
                        }
                    })
                }
            },
            setSearchFontColor: {//设置搜索文字的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            color = item.fontColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            item.fontColor = newValue
                        }
                    })
                }
            },
            hotSearch: {//热搜词的双向绑定
                get() {
                    let words
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            words = item.hotSearch
                        }
                    })
                    return words
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            item.hotSearch = newValue
                        }
                    })
                }
            },
            setSearchMtb: {//设置搜索的上下边距
                get() {
                    let mtb
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            mtb = item.mtb
                        }
                    })
                    return mtb
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            item.mtb = newValue
                        }
                    })
                }
            },
            setSearchMlr: {//设置搜索的左右边距
                get() {
                    let mlr
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            mlr = item.mlr
                        }
                    })
                    return mlr
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'search' && item.id === this.currentId) {
                            item.mlr = newValue
                        }
                    })
                }
            },

            setLineColor: {//设置分割线颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            color = item.lineColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            item.lineColor = newValue
                        }
                    })
                }
            },
            setLineBgColor: {//设置分割线的背景颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            color = item.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            item.bgColor = newValue
                        }
                    })
                }
            },
            setLineHeight: {//设置分割线的高度
                get() {
                    let height
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            height = item.lineHeight
                        }
                    })
                    return height
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            item.lineHeight = newValue
                        }
                    })
                }
            },
            setLinpadding: {//设置分割线的上下边距
                get() {
                    let height
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            height = item.height
                        }
                    })
                    return height
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'line' && item.id === this.currentId) {
                            item.height = newValue
                        }
                    })
                }
            },
            getListTitleColor: {//设置图文集标题的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'glossary' && item.id === this.currentId) {
                            color = item.titleColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'glossary' && item.id === this.currentId) {
                            item.titleColor = newValue
                        }
                    })
                }
            },
            getListBgColor: {//设置图文集的背景颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'glossary' && item.id === this.currentId) {
                            color = item.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'glossary' && item.id === this.currentId) {
                            item.bgColor = newValue
                        }
                    })
                }
            },
            setBtnTitle: {//按钮的文字双向绑定
                get() {
                    let words
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            words = item.parma.text
                        }
                    })
                    return words
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            item.parma.text = newValue
                        }
                    })
                }
            },
            setBtnRadius: {
                get() {
                    let radius
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            radius = item.parma.radius
                        }
                    })
                    return radius
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            item.parma.radius = newValue
                        }
                    })
                }
            },
            setBtnTitleColor: {//设置按钮标题的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            color = item.parma.fontColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            item.parma.fontColor = newValue
                        }
                    })
                }
            },
            setBtnBgolor: {//设置按钮背景的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            color = item.parma.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            item.parma.bgColor = newValue
                        }
                    })
                }
            },
            setBtnBorderolor: {//设置边框的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            color = item.parma.borderColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'button' && item.id === this.currentId) {
                            item.parma.borderColor = newValue
                        }
                    })
                }
            },
            CurrentBtnIcon() {//获取当前按钮的icon
                let img
                this.allLists.map(item => {
                    if (item.type === 'button' && item.id === this.currentId) {
                        img = item.parma.url
                    }
                })
                return img
            },
            setPicRadius: {//设置图文的圆角比例
                get() {
                    let radius
                    this.allLists.map(item => {
                        if (item.type === 'pictureList' && item.id === this.currentId) {
                            radius = item.radius
                        }
                    })
                    return radius
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'pictureList' && item.id === this.currentId) {
                            item.radius = newValue
                        }
                    })
                }
            },
            setFixBottom: {//设置悬浮图标距离底部的位置
                get() {
                    let bottom
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            bottom = item.bottom
                        }
                    })
                    return bottom
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            item.bottom = newValue
                        }
                    })
                }
            },
            setFixLeft: {//设置悬浮图标距离左边的位置
                get() {
                    let left
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            left = item.left
                        }
                    })
                    return left
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            item.left = newValue
                        }
                    })
                }
            },
            setFixOpacity: {//设置悬浮图标的透明度
                get() {
                    let opacity
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            opacity = item.opacity
                        }
                    })
                    return opacity
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            item.opacity = newValue
                        }
                    })
                }
            },
            setFixBgColor: {//设置悬浮图标的背景颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            color = item.bgColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'fixed' && item.id === this.currentId) {
                            item.bgColor = newValue
                        }
                    })
                }
            },
            getFixBgImg() {//获取悬浮图标的背景图片
                let img
                this.allLists.map(item => {
                    if (item.type === 'fixed' && item.id === this.currentId) {
                        img = item.img
                    }
                })
                return img
            },
            setVideoLink: {//设置视频的播放链接
                get() {
                    let link
                    this.allLists.map(item => {
                        if (item.type === 'video' && item.id === this.currentId) {
                            link = item.src
                        }
                    })
                    return link
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'video' && item.id === this.currentId) {
                            item.src = newValue
                        }
                    })
                }
            },
            getVideoPoster: {//获取视频的封面
                get() {
                    let poster
                    this.allLists.map(item => {
                        if (item.type === 'video' && item.id === this.currentId) {
                            poster = item.poster
                        }
                    })
                    return poster
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'video' && item.id === this.currentId) {
                            item.poster = newValue
                        }
                    })
                }
            },
            setAudioLink: {//设置视频的播放链接
                get() {
                    let link
                    this.allLists.map(item => {
                        if (item.type === 'audio' && item.id === this.currentId) {
                            link = item.src
                        }
                    })
                    return link
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'audio' && item.id === this.currentId) {
                            item.src = newValue
                        }
                    })
                }
            },
            getAudioPoster() {//获取音频封面
                let poster
                this.allLists.map(item => {
                    if (item.type === 'audio' && item.id === this.currentId) {
                        poster = item.poster
                    }
                })
                return poster
            },
            setAudioName: {//设置音频名称
                get() {
                    let name
                    this.allLists.map(item => {
                        if (item.type === 'audio' && item.id === this.currentId) {
                            name = item.name
                        }
                    })
                    return name
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'audio' && item.id === this.currentId) {
                            item.name = newValue
                        }
                    })
                }
            },
            setAudioAuthor: {//设置音频作者
                get() {
                    let author
                    this.allLists.map(item => {
                        if (item.type === 'audio' && item.id === this.currentId) {
                            author = item.author
                        }
                    })
                    return author
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'audio' && item.id === this.currentId) {
                            item.author = newValue
                        }
                    })
                }
            },
            setAdvertHeight: {//设置广告位的高度
                get() {
                    let height
                    this.allLists.map(item => {
                        if (item.type === 'advert' && item.id === this.currentId) {
                            height = item.height
                        }
                    })
                    return height
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'advert' && item.id === this.currentId) {
                            item.height = newValue
                        }
                    })
                }
            },

            // ----------------新增商品列表和活动------------------
            currentListType() {//获取当前商品列表的样式类型
                let currentType
                this.allLists.map(item => {
                    if (item.type === 'prolist' && item.id === this.currentId) {
                        currentType = item.listType
                    }
                })
                return currentType
            },
            setProTitleColor: {//设置商品名称的字体颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            color = item.fontColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            item.fontColor = newValue
                        }
                    })
                }
            },
            setPriceColor: {//设置商品价格的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            color = item.priceColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            item.priceColor = newValue
                        }
                    })
                }
            },
            setBtnColor: {//设置商品按钮的颜色
                get() {
                    let color
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            color = item.btnColor
                        }
                    })
                    return color
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            item.btnColor = newValue
                        }
                    })
                }
            },
            currentProSelectType() {//获取商品列表的商品选择类型
                let selectType = 0
                this.allLists.map(item => {
                    if (item.type === 'prolist' && item.id === this.currentId) {
                        selectType = item.selectType
                    }
                })
                return selectType
            },
            currentProSelectGroup() {//当商品列表选择类型为选择分类时，获取其选择商品分组的类型
                let groupType = ''
                this.allLists.map(item => {
                    if (item.type === 'prolist' && item.id === this.currentId) {
                        selectType = item.selectGroup
                    }
                })
                return selectType
            },
            setShopListNum: {//当商品来源为选择分类时，设置显示商品的数量
                get() {
                    let num
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            num = item.selectNum
                        }
                    })
                    return num
                },
                set(newValue) {
                    this.allLists.map(item => {
                        if (item.type === 'prolist' && item.id === this.currentId) {
                            item.selectNum = newValue
                        }
                    })
                }
            },
            // -----------------新增商品列表和活动-----------------
            getAdvertSelectType() {
                let selectType= 0
                this.allLists.map(item => {
                    if (item.type === 'advert' && item.id === this.currentId) {
                        selectType = item.selectType
                    }
                })
                return selectType
            },
            currentCrowType() {
                let crowTyppe = 0
                this.allLists.map(item => {
                    if (item.type === 'crowd' && item.id === this.currentId) {
                        crowTyppe = item.selectType
                    }
                })
                return crowTyppe
            },
        },
        methods: {

            //图片上传
            showImageDialog(elm,index,options) {
                require(["util"], function(util){

                    var btn = $(elm);
                    var ipt = btn.parent().prev();
                    var val = ipt.val();
                    var img = ipt.parent().next().children();
//                options = '.str_replace('"', '\'', json_encode($options)).';
                    util.image(val, function(url){
                        if(url.url){
                            if(img.length > 0){
                                img.get(0).src = url.url;
                            }
                            VM.allLists.map(ops=>{
                                if(ops.id===VM.currentId){
                                    if(ops.type=='advert'){           //广告位
                                        ops.adLists[index].img=url.url;
                                    }else if(ops.type=='glossary'){         //图文集
                                        ops.lists[index].img=url.url;
                                    }else if(ops.type=='pictureList'){      //图片列表
                                        ops.lists[index].img=url.url;
                                    }else if(ops.type=='video'){
                                        ops.poster=url.url;
                                    }
                                }
                            })

                            ipt.val(url.attachment);
                            ipt.attr("filename",url.filename);
                            ipt.attr("url",url.url);
                        }
                        if(url.media_id){
                            if(img.length > 0){
                                img.get(0).src = "";
                            }
                            ipt.val(url.media_id);
                        }
                    }, options);
                });
            },
            focus(boolean) {//是否显示banner的焦点
                this.allLists.map((item, index) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.focus = boolean
                    }
                })
            },
            setIsFocus(boolean) {//渲染是否显示焦点选中的样式
                let booleans
                this.allLists.map((item) => {
                    if (item.type == this.currentType  && item.id === this.currentId) {
                        if(item.focus === boolean){
                            booleans = true
                        }else{
                            booleans = false
                        }
                    }
                })
                return booleans
            },
            addBanner() {//新增一个banner图
                this.allLists.map((item, index) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        let img = {
                            "img": "http://vip.ly100.wang//public/upload/6/goods/be5c9f32cb3ffac15d3f8301736b5f2d.jpg",
                            url: '123'
                        }
                        item.imgUrl.push(img)
                    }
                })
            },
            deleteBanner(index) {//删除某张banner图
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.imgUrl.map((list, indexs) => {
                            if (indexs === index) {
                                item.imgUrl.splice(indexs, 1)
                            }
                        })
                    }
                })
            },

            //给轮播图banner添加链接
            addLink(link_type,title,url) {
                VM.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if(item.type=='banner'){
                            item.imgUrl.map((list, indexs) => {
                                if (indexs === item.opeartion_imgs_id) {
                                    list.link_type = link_type;
                                    list.title=title;
                                    list.link_param=url;
                                }

                            })
                        }else if(item.type=='advert'){
                            item.adLists.map((list,indexs)=>{
                                if (indexs === item.opeartion_imgs_id) {
                                    list.link_type = link_type;
                                    list.title=title;
                                    list.link_param=url
                                }
                            })
                        }else if(item.type=='navigation'){
                            item.list.map((lists,indexs)=>{
                                if(indexs==item.opeartion_imgs_id){
                                    lists.link_type=link_type;
                                    lists.link_title=title;
                                    lists.link_param=url;
                                }
                            })
                        }else if(item.type=='glossary'){
                            item.lists.map((list,indexs)=>{
                                if(indexs==item.opeartion_imgs_id){
                                    list.link_type=link_type;
                                    list.link_title=title;
                                    list.link_param=url;
                                }
                            })
                        }else if(item.type=='pictureList'){
                            item.lists.map((list,indexs)=>{
                                if(indexs==item.opeartion_imgs_id){
                                    list.link_type=link_type;
                                    list.link_title=title;
                                    list.link_param=url;
                                }
                            })
                        }else if(item.type=='headline'){
                            item.link=link_type;
                            item.link_title=title;
                            item.link_param=url;
                            // item.lists.map((list,indexs)=>{
                            //     if(indexs==item.opeartion_imgs_id){
                            //         list.link=link_type;
                            //         list.link_title=title;
                            //         list.link_param=url;
                            //     }
                            // })
                        }
                    }
                })
                VM.showLinkDialog=false;  //选择完成后关闭弹框
                this.$refs.modelCont.style.display="none";
                document.documentElement.style.overflow='auto';
            },

            //打开跳转链接选择
            pickLink(index){
                VM.showLinkDialog=true; //显示链接选择器弹框
                this.$refs.modelCont.style.display="block";
                VM.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.opeartion_imgs_id=index;  //当前操作的imgUrl的id
                    }
                })
                document.documentElement.style.overflow='hidden';
            },

            //select框选择
            selectLink(index){

            },

            //关闭跳转链接选择
            closeLinkModel(){
                VM.showLinkDialog=false; //关闭链接选择器弹框
                this.$refs.modelCont.style.display="none";
                document.documentElement.style.overflow='auto';
            },


            setNavColumnStyle(num) {//渲染导航选中的样式
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.column === num) style = 'isColumn'
                        else style = 'noColumn';
                    }
                })
                return style
            },
            setNavColumn(columns) {//设置导航几列
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.column = columns
                    }
                })
            },
            setNavFontStyle(num) {//渲染导航字体选中的样式
                let boolean
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.fontSize === num) boolean = true
                        else boolean = false
                    }
                })
                return boolean
            },
            setNavFont(num) {//设置导航字体大小
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.fontSize = num
                    }
                })
            },
            deleteNav(index) {//删除选中的导航
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.list.map((list, indexs) => {
                            if (indexs === index) {
                                item.list.splice(indexs, 1)
                            }
                        })
                    }
                })
            },
            selectNavImg(index) {//更改导航的图标
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.list.map((ops, indexs) => {
                            if (indexs === index) {
                                ops.url = 'https://wx.cqkundian.com/addons/ybgw_001/core/public/menu/images/Lb2.png'
                            }
                        })
                    }
                })
            },
            addNav() {//新增一个导航
                this.allLists.map((item, index) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        let nav = {
                            'title': '烧菜',
                            "url": "https://wx.cqkundian.com/addons/ybgw_001/core/public/menu/images/Lb2.png",
                            'direction': '123'
                        }
                        item.list.push(nav)
                    }
                })
            },



            getHeadLineStyle(num) {//渲染标题样式选中的样式
                let boolean
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.style === num) boolean = true
                        else boolean = false
                    }
                })
                return boolean
            },
            setHeadLine(num) {//设置标题样式
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.style = num
                    }
                })
            },
            getHeadLineFontSize(num) {//渲染标题字体选中的样式
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.fontSize === num) style = true
                        else style = false
                    }
                })
                return style
            },
            setHeadLineFontSize(num) {//设置标题字体大小
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.fontSize = num
                    }
                })
            },



            getSearchBor(num) {//获取搜索框的圆角
                let radius
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        if (item.radius === num) radius = true
                        else radius = false
                    }
                })
                return radius
            },
            setSearchBor(num) {//设置搜索框的圆角
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.radius = num
                    }
                })
            },
            getLineStyle(num) {//渲染分割线实虚线选中的样式
                let style
                let line = num === 1 ? 'solid' : 'dashed';
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.styles === line) style = true
                        else style = false
                    }
                })
                return style
            },
            setLineStyle(num) {//设置分割线的样式
                let line = num === 1 ? 'solid' : 'dashed';
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.styles = line
                    }
                })
            },
            getListcurrentStyle(num) {//渲染图文集样式选中
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.styles === num) style = true
                        else style = false
                    }
                })
                return style
            },
            setListcurrentStyle(num) {//选择图文集的样式
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.styles = num
                    }
                })
            },
            getListFontStyle(num) {//渲染图文集中文字大小
                let size
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.titleSize === num) size = true
                        else size = false
                    }
                })
                return size
            },
            setListFontStyle(num) {//设置图文集标题文字的大小
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.titleSize = num
                    }
                })
            },
            deleteList(index) {//删除图文集的某一项
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.lists.map((list, indexs) => {
                            if (indexs === index) {
                                item.lists.splice(indexs, 1)
                            }
                        })
                    }
                })
            },
            addPicList() {//图文集新增一项
                this.allLists.map((item, index) => {
                    if (item.type == this.currentType  && item.id === this.currentId) {
                        let list = {
                            "img": "../../../../addons/kundian_farm/resource/home/images/goods-3.jpg",
                            'title': '我是标题1',
                            'innerText': '我是内容1',
                            'direction': ''
                        }
                        item.lists.push(list)
                    }
                })
            },
            selectListImg(index) {//更改选中图文集的图片
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.lists.map((ops, indexs) => {
                            if (indexs === index) {
                                ops.img = '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg'
                            }
                        })
                    }
                })
            },
            getBtnborderShow(boolean) {//显示是否隐藏按钮的边框
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.parma.border === boolean) style = true
                        else style = false
                    }
                })
                return style
            },
            setBtnborderShow(boolean) {//设置是否显示边框
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.parma.border = boolean
                    }
                })
            },
            getBtnIconShow(boolean) {//显示是否隐藏按钮的图标
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.parma.icon === boolean) style = true
                        else style = false
                    }
                })
                return style
            },
            setBtnIconShow(boolean) {//设置是否显示图标
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.parma.icon = boolean
                    }
                })
            },
            setCurrentBtnImg(elm,options) {//设置按钮的图标
                require(["util"], function(util){
                    var btn = $(elm);
                    var ipt = btn.parent().prev();
                    var val = ipt.val();
                    var img = ipt.parent().next().children();
//                options = '.str_replace('"', '\'', json_encode($options)).';
                    util.image(val, function(url){
                        if(url.url){
                            if(img.length > 0){
                                img.get(0).src = url.url;
                            }
                            VM.allLists.map(item => {
                                if (item.type === 'button'  && item.id === VM.currentId) {
                                    item.parma.url = url.url;
                                }
                            })
                            ipt.val(url.attachment);
                            ipt.attr("filename",url.filename);
                            ipt.attr("url",url.url);
                        }
                        if(url.media_id){
                            if(img.length > 0){
                                img.get(0).src = "";
                            }
                            ipt.val(url.media_id);
                        }
                    }, options);
                });

            },
            getPicStyle(num) {//显示图文列表的选中样式
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.styles === num) style = true
                        else style = false
                    }
                })
                return style
            },
            setPicStyle(num) {//设置图文的样式
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.styles = num
                    }
                })
            },
            getPicColumn(num) {//显示图文列表排版的选中样式
                let style
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        if (item.column === num) style = 'isColumn'
                        else style = 'noColumn'
                    }
                })
                return style
            },
            setPicColumn(num) {//设置图文的排版
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.column = num
                    }
                })
            },
            deletePic(index) {//删除某一项图文
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.lists.map((list, indexs) => {
                            if (indexs === index) {
                                item.lists.splice(indexs, 1)
                            }
                        })
                    }
                })
            },
            addPic() {//新增一项图文
                this.allLists.map((item, index) => {
                    if (item.type == this.currentType  && item.id === this.currentId) {
                        let pic = {
                            'img': '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                            'title': '我是标题',
                            'direction': ''
                        }
                        item.lists.push(pic)
                    }
                })
            },
            setFixBgImg(elm,options) {//设置悬浮图标的icon
                require(["util"], function(util){
                    var btn = $(elm);
                    var ipt = btn.parent().prev();
                    var val = ipt.val();
                    var img = ipt.parent().next().children();
//                options = '.str_replace('"', '\'', json_encode($options)).';
                    util.image(val, function(url){
                        if(url.url){
                            if(img.length > 0){
                                img.get(0).src = url.url;
                            }
                            VM.allLists.map(item => {
                                if (item.type === 'fixed'  && item.id === VM.currentId) {
                                    item.img = url.url;
                                }
                            })
                            ipt.val(url.attachment);
                            ipt.attr("filename",url.filename);
                            ipt.attr("url",url.url);
                        }
                        if(url.media_id){
                            if(img.length > 0){
                                img.get(0).src = "";
                            }
                            ipt.val(url.media_id);
                        }
                    }, options);
                });
            },
            setVideoPoster(elm,options) {//设置视频封面
                require(["util"], function(util){
                    var btn = $(elm);
                    var ipt = btn.parent().prev();
                    var val = ipt.val();
                    var img = ipt.parent().next().children();
//                options = '.str_replace('"', '\'', json_encode($options)).';
                    util.image(val, function(url){
                        if(url.url){
                            if(img.length > 0){
                                img.get(0).src = url.url;
                            }
                            VM.allLists.map(item => {
                                if (item.type === 'video'  && item.id === VM.currentId) {
                                    item.poster = url.url;
                                }
                            })
                            ipt.val(url.attachment);
                            ipt.attr("filename",url.filename);
                            ipt.attr("url",url.url);
                        }
                        if(url.media_id){
                            if(img.length > 0){
                                img.get(0).src = "";
                            }
                            ipt.val(url.media_id);
                        }
                    }, options);
                });
            },
            setAudioPoster(elm,options) {//设置音频封面
                require(["util"], function(util){
                    var btn = $(elm);
                    var ipt = btn.parent().prev();
                    var val = ipt.val();
                    var img = ipt.parent().next().children();
//                options = '.str_replace('"', '\'', json_encode($options)).';
                    util.image(val, function(url){
                        if(url.url){
                            if(img.length > 0){
                                img.get(0).src = url.url;
                            }
                            VM.allLists.map(item => {
                                if (item.type === 'audio'  && item.id === VM.currentId) {
                                    item.poster = url.url;
                                }
                            })
                            ipt.val(url.attachment);
                            ipt.attr("filename",url.filename);
                            ipt.attr("url",url.url);
                        }
                        if(url.media_id){
                            if(img.length > 0){
                                img.get(0).src = "";
                            }
                            ipt.val(url.media_id);
                        }
                    }, options);
                });
            },
            addAdvert() {//新增一个广告
                this.allLists.map((item, index) => {
                    if (item.type == this.currentType  && item.id === this.currentId) {
                        let list = {
                            img: '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg',
                            width: 100,
                            direction: ''
                        }
                        item.adLists.push(list)
                    }
                })
            },
            deleteAdvert(index) {//删除一个广告位
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.adLists.map((list, indexs) => {
                            if (indexs === index) {
                                item.adLists.splice(indexs, 1)
                            }
                        })
                    }
                })
            },
            selectAdvImg(index) {//设置广告位的图片
                this.allLists.map((item) => {
                    if (item.type === this.currentType  && item.id === this.currentId) {
                        item.adLists.map((list, indexs) => {
                            if (indexs === index) {
                                list.img = '../../../../addons/kundian_farm/resource/home/images/goods-3.jpg'
                            }
                        })
                    }
                })
            },
            // AddDom(parma) {//新增一个节点
            //     let index = parma
            //     let MaxId = this.MaxId
            //     let types = JSON.parse(JSON.stringify(this.defaultTypes));
            //     types.map((item) => {
            //         if(item.type === index) {
            //             MaxId+=1
            //             item.id = MaxId
            //             this.MaxId = MaxId
            //             this.allLists.push(item)
            //             this.currentType = item.type
            //             this.currentId = MaxId;
            //
            //         }
            //     })
            //     // localStorage.setItem('allLists',JSON.stringify(this.allLists));
            // },

            addList(parma) {
                let index = parma
                let MaxId = this.MaxId
                let types = JSON.parse(JSON.stringify(this.defaultTypes));
                types.map((item) => {
                    if (item.type === index) {
                        let timeId=new Date().getTime();
                        item.id = timeId;
                        this.MaxId = MaxId
                        this.allLists.push(item)
                        this.currentType = item.type
                        this.currentId = timeId;
                    }
                })

            },
            AddDom(parma) {//新增一个节点
                if(parma == 'prolist' || parma == 'active' || parma == 'crowd') {
                    let indexs = this.allLists.find((value) => {
                        return value.type == parma
                    })
                    // if(indexs){
                    //     this.alertText = '该类型只能添加一次,当前列表已存在该类型'
                    //     this.$refs.modelContent.style['transform'] = 'scale(1)'
                    //     setTimeout(() => {
                    //         this.$refs.modelContent.style['transform'] = 'scale(0)'
                    //     }, 1000)
                    // }else{
                    //     this.addList(parma)
                    // }
                    this.addList(parma)
                }else{
                    this.addList(parma)
                }
            },



            showDeleteWrapper(id) {//显示删除弹框
                this.$refs.model.style.display = 'block'
                this.$refs.modelContent.style['transform'] = 'scale(1)'
                this.currentDeleteId = id
            },
            cancelDelete() {//取消删除节点
                this.$refs.model.style.display = 'none'
                this.$refs.modelContent.style['transform'] = 'scale(0)'
                this.currentDeleteId = 0
            },
            // deleteDom() {//删除节点
            //     this.allLists.map((item, index) => {
            //         if (item.id === this.currentDeleteId) this.allLists.splice(index, 1)
            //     })
            //     this.$refs.model.style.display = 'none'
            //     this.$refs.modelContent.style['transform'] = 'scale(0)'
            //     this.currentDeleteId = 0
            // },

            deleteDom() {//删除节点
                this.allLists.map((item, index) => {
                    if (item.id === this.currentDeleteId) {
                        if(item.type == 'prolist' && this.shopList.length > 0) {
                            this.shopList.map(item => {
                                item.select = false
                            })
                        }else if(item.type == 'active' && this.activeList.length > 0) {
                            this.activeList.map(item => {
                                item.select = false
                            })
                        }else if(item.type == 'crowd' && this.crowdList.length > 0) {
                            this.crowdList.map(item => {
                                item.select = false
                            })
                        }
                        this.allLists.splice(index, 1)
                        this.currentId = 0
                        this.currentType = ''
                    }
                })
                this.$refs.model.style.display = 'none'
                this.$refs.modelContent.style['transform'] = 'scale(0)'
                this.currentDeleteId = 0
            },

            selectIcon() {//弹出图标列表
                if (this.iconList.length == 0) {
                    $.getJSON("../addons/kundian_farm/resource/home/js/iconfont.json", (data) => {
                        this.iconList = data
                    })
                }
                this.$refs.model.style.display = 'block'
                this.$refs.icons.style['transform'] = 'scale(1)'
            },
            closeSeleceIcon() {//关闭图标框
                this.$refs.model.style.display = 'none'
                this.$refs.icons.style['transform'] = 'scale(0)'
            },
            selectCurrentIcon(item) {//选择图标
                let icon = item.class
                this.allLists.map((item) => {
                    if (item.id === this.currentId && item.type == 'headline') {
                        item.icon = icon
                        this.$refs.model.style.display = 'none'
                        this.$refs.icons.style['transform'] = 'scale(0)'
                    }
                })
            },
            clearIcon() {//清除图标
                this.allLists.map((item) => {
                    if (item.id === this.currentId && item.type == 'headline') {
                        item.icon = ''
                    }
                })
            },
            save() {//保存
                let data  = JSON.stringify(this.allLists)
                $.ajax({
                    url: save_url,
                    data:{list:data},
                    type: 'POST',
                    success:function(res){
                        var data=JSON.parse(res);
                        console.log(data);
                        alert(data.msg);
                    }
                })
                // localStorage.setItem('list',data)
            },
            saveToMyTemplate() {//保存到我的模板

            },


            selectHeaderLink() {//设置标题的链接
                this.allLists.map((item, index) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.link = 'www.baidu.com'
                    }
                })
            },

            clearHeaderLink() {//清除标题的链接
                this.allLists.map((item, index) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.link = ''
                    }
                })
            },

            getHeadlineAlign(align) {//获取标题文字水平位置
                let direction
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        if (item.align === align) direction = true
                        else direction = false
                    }
                })
                return direction
            },
            setHeadlineAlign(align) {//设置标题文字水平位置
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.align = align
                    }
                })
            },

            // -------------------- 商品列表和活动、众筹 --------------------
            setListType(num) {//设置当前商品列表的类型
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.listType = num
                    }
                })
            },

            setProSelectType(num) {//设置商品选择的类型
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.selectType = num
                    }
                })
            },
            deleteProItem(index, type) {//删除商品列表的某一项
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.lists.map((list, indexs) => {
                            if (indexs === index) {
                                if(type == 'shop') {
                                    this.shopList.map(res => {
                                        if (res.id == list.id) {
                                            res.select = false
                                        }
                                    })
                                }else if(type == 'active') {
                                    this.activeList.map(res => {
                                        if (res.id == list.id) {
                                            res.select = false
                                        }
                                    })
                                }else if(type == 'crowd') {
                                    this.crowdList.map(res => {
                                        if (res.id == list.id) {
                                            res.select = false
                                        }
                                    })
                                }
                                item.lists.splice(indexs, 1)
                            }
                        })
                    }
                })
            },
            setProSelectGroup(num) {//设置商品列表为选择分类时，其显示的商品从哪种分类获取
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.selectGroup = num
                    }
                })
            },
            crowdItemState(list) {//渲染每条众筹的状态
                if(list.state == 0) {
                    return '预售中'
                }else{
                    return '众筹成功'
                }
            },
            setCuurentShopItem(num, id) {//选择商品时，弹出获取的商品列表弹框
                // let url = 'https://www.easy-mock.com/mock/5b59601d2d340a0cf16733f3/components/index/shopList'
                this.getData(goods_list_url, num, id, this.shopList, 'shoplist')
            },
            selectCurrentActive(num, id){//选择活动，弹出获取的活动列表
                // let url = 'https://www.easy-mock.com/mock/5b59601d2d340a0cf16733f3/components/index/active'
                this.getData(active_list_url, num, id, this.activeList, 'activeList')
            },
            selectCurrentCrowd(num, id){//选择众筹，弹出获取的众筹列表
                // let url = 'https://www.easy-mock.com/mock/5b59601d2d340a0cf16733f3/components/index/crowd'
                this.getData(funding_list_url, num, id, this.crowdList, 'crowdList')
            },
            getData(url, num, id, list,type){//获取商品、活动列表的数据
                if (id) {
                    this.currentReplaceShopId = id
                }
                this.isAddOrReplace = num
                this.$refs.model.style.display = 'block'
                if (list.length == 0) {
                    this.loading = true
                    $.ajax({
                        url: url,
                        success: res => {
                            let dataRes = JSON.parse(res)
                            let data=dataRes.lists;
                            this.$refs.shopList.style['transform'] = 'scale(1) translateX(-50%)'
                            this.loading = false
                            if(type == 'shoplist'){
                                this.shopList = data
                                this.getHadSelect(this.shopList)
                            }else if(type == 'activeList') {
                                this.activeList = data
                                this.getHadSelect(this.activeList)
                            }else if(type == 'crowdList') {
                                this.crowdList = data
                                this.getHadSelect(this.crowdList)
                            }
                        }
                    })
                } else {
                    this.$refs.shopList.style['transform'] = 'scale(1) translateX(-50%)'
                    this.getHadSelect(list)
                }
            },
            selectShopItem(index, type) {//点击商品弹框的某件商品
                let currentItem = {}
                if(type == 'shop') {
                    currentItem = this.shopList[index]
                }else if(type == 'active'){
                    currentItem = this.activeList[index]
                }else if(type == 'crowd'){
                    currentItem = this.crowdList[index]
                }
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {

                        let result = item.lists.findIndex((value) => {
                            return value.id === currentItem.id
                        })
                        if (this.isAddOrReplace == 1) {
                            if (result > -1) {
                                this.alertText = '该项已被选中，不能再选择了'
                                this.$refs.modelContent.style['transform'] = 'scale(1)'
                                setTimeout(() => {
                                    this.$refs.modelContent.style['transform'] = 'scale(0)'
                                }, 1000)
                            } else {
                                let index = item.lists.findIndex((value) => {
                                    return value.id === this.currentReplaceShopId
                                })
                                item.lists.splice(index, 1, currentItem)
                                this.closeShopList()
                            }
                        } else if (this.isAddOrReplace == 2) {
                            if(result >-1){
                                item.lists.splice(result, 1)
                            }else{
                                item.lists.push(currentItem)
                            }
                        }

                    }
                })
                if(type == 'shop') {
                    this.getHadSelect(this.shopList)
                }else if(type == 'active'){
                    this.getHadSelect(this.activeList)
                }else if(type == 'crowd'){
                    this.getHadSelect(this.crowdList)
                }
            },
            getHadSelect(list2) {//判断商品是否一杯选中
                let indexs = this.allLists.findIndex((value) => {
                    return value.id == this.currentId
                })
                let list1 = this.allLists[indexs].lists
                list2.map(list => {
                    list.select = false
                    list1.map(item => {
                        if (list.id == item.id) {
                            list.select = true
                        }
                    })
                })
            },
            closeShopList() {//关闭商品列表弹框
                this.$refs.model.style.display = 'none'
                this.$refs.shopList.style['transform'] = 'scale(0) translateX(-50%)'
                this.currentReplaceShopId = 0
            },
            // -------------------- 商品列表和活动、众筹 --------------------

            //设置新的广告图样式
            setAdvertSelectType(num) {
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        item.selectType = num
                    }
                })
            },
            setCrowType(num) {//设置众筹的样式
                this.allLists.map((item) => {
                    if (item.type === this.currentType && item.id === this.currentId) {
                        console.log(item)
                        item.selectType = num
                    }
                })
            },
        },
        watch:　{
            currentId(newValue, oldValue) {
                console.log(newValue)
            },
            currentType(newValue) {
                console.log(newValue)
            },
            allLists(newValue,oldValue){
                // console.log(newValue);
                // console.log(oldValue);
            }

        }
    })

// 优惠券
    Vue.component('coupon', {
        props: ['id','height', 'adLists'],
        template: '<div @click="select" class="coupon clearfix" ref="coupon" :style="heights"><div v-for="(item,index) in adLists" :key="index" class="advert_img_wrapper" :style="' + "'width:100%;height:140px;'" + "" + '"><img width="100%" height="100%" :src="item.img"/></div></div>',
        computed: {
            heights() {
                return `height: ${140}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'coupon',
                    VM.currentId = this.id
            },
        }
    })
// 天气
    Vue.component('weather', {
        props: ['id','height', 'adLists'],
        template: '<div @click="select" class="weather clearfix" ref="coupon" :style="heights"><div v-for="(item,index) in adLists" :key="index" class="advert_img_wrapper" :style="' + "'width:100%;height:80px;'" + "" + '"><img width="100%" height="100%" :src="item.img"/></div></div>',
        computed: {
            heights() {
                return `height: ${80}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'weather',
                    VM.currentId = this.id
            },
        }
    })
// 资讯
    Vue.component('information', {
        props: ['id','height', 'adLists'],
        template: '<div @click="select" class="information clearfix" ref="coupon" :style="heights"><div v-for="(item,index) in adLists" :key="index" class="advert_img_wrapper" :style="' + "'width:100%;height:68px;'" + "" + '"><img width="100%" height="100%" :src="item.img"/></div></div>',
        computed: {
            heights() {
                return `height: ${68}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'information',
                    VM.currentId = this.id
            },
        }
    })
// 底部
    Vue.component('btnclounm', {
        props: ['id','height', 'adLists'],
        template: '<div @click="select" class="btnclounm clearfix" ref="coupon" :style="heights"><div v-for="(item,index) in adLists" :key="index" class="advert_img_wrapper" :style="' + "'width:100%;height:236px;'" + "" + '"><img width="100%" height="100%" :src="item.img"/></div></div>',
        computed: {
            heights() {
                return `height: ${236}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'btnclounm',
                    VM.currentId = this.id
            },
        }
    })
// 底部
    Vue.component('team', {
        props: ['id','height', 'adLists'],
        template: '<div @click="select" class="team clearfix" ref="coupon" :style="heights"><div v-for="(item,index) in adLists" :key="index" class="advert_img_wrapper" :style="' + "'width:100%;height:50px;'" + "" + '"><img width="100%" height="100%" :src="item.img"/></div></div>',
        computed: {
            heights() {
                return `height: ${50}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'team',
                    VM.currentId = this.id
            },
        }
    })

    Vue.component('banner', {
        props: ['id', 'focus', 'focusColor', 'imgUrl', 'swiperHeight'],
        template: '<div @click="select" class="swiper" :style="height"><img :src="imgUrl[currentIndex].img"/><div v-if="focus" class="dots"><span  class="dot" :style="dotColor(index)" v-for="(item, index) in imgUrl" :key="index" @click="select_dot(index)"></span></div></div>',
        data() {
            return {
                currentIndex: 0,
            }
        },
        computed: {
            height() {
                return `height: ${this.swiperHeight}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'banner',
                    VM.currentId = this.id
            },
            select_dot(index) {
                this.currentIndex = index
            },
            dotColor(index) {
                if (index === this.currentIndex) {
                    return `background: ${this.focusColor}`
                }
            }
        }
    })
// 辅助空白
    Vue.component('blank', {
        props: ['id', 'bgColor', 'height'],
        template: '<div @click="select" class="blank" :style="style"></div>',
        computed: {
            style() {
                return `background: ${this.bgColor}; height:${this.height}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'blank',
                    VM.currentId = this.id
            },
        }
    })
// 广告位
    Vue.component('advert', {
        props: ['id', 'height', 'adLists', 'selectType'],
        template: '<div @click="select" class="advert clearfix"><template v-if="selectType === 1"><div class="advert_typeOne" v-for="(item, index) in adLists" :key="index"><img :src="item.img" width="100%" height="100%"/></div></template><template v-if="selectType === 2"><div class="advert_typeTwo"><div class="advert_typeTwo_item" v-for="(item, index) in adLists" :key="index"> <img :src="item.img" width="100%" height="100%"/></div></div></template><template v-if="selectType === 3"><div class="advert_typeThr"><div class="advert_typeThr_mian"><img :src="adLists[0].img" width="100%" height="100%"/></div><div class="advert_typeThr_sub"><div class="advert_typeThr_subItem"><img :src="adLists[1].img" width="100%" height="100%"/></div><div class="advert_typeThr_subItem"><img :src="adLists[2].img" width="100%" height="100%"/></div></div></div></template><template v-if="selectType === 4"><div class="advert_typeOne"><img :src="adLists[0].img" width="100%" height="100%"/></div> <div class="advert_typeFour"><div v-for="(item, index) in adLists" v-if="index > 0 && index <= 3" class="advert_typeFour_item"><img :src="item.img" width="100%" height="100%"/> </div></div></template></div>',
        methods: {
            select() {
                VM.currentType = 'advert',
                    VM.currentId = this.id
            },
        }
    })
// 宮格导航
    Vue.component('navigation', {
        props: ['id', 'column', 'fontColor', 'fontSize', 'radius', 'list'],
        template: '<div @click="select" class="navigation clearfix"><div class="setPage" v-show="needPage"><span v-for="(item, index) in pageNum" :key="index"></span></div><div v-for="(item, index) in list" :key="index" v-if="index < column * 2" class="navigation_item center" :style="width"><img :style="imgRadius" :src="item.url"/><div class="padtop5" :style="fontStyle" v-text="item.title"></div></div></div>',
        computed: {
            width() {
                const column = this.column
                let width = 0
                if (column === 2) width = 50
                else if (column === 3) width = 33.3
                else if (column === 4) width = 25
                else width = 20
                return `width:${width}%;`
            },
            imgRadius() {
                return `border-radius: ${this.radius}%`
            },
            fontStyle() {
                return `font-size:${this.fontSize}px; color:${this.fontColor}`
            },
            needPage() {
                const column = this.column
                const list = this.list
                let page = false
                if (list.length > 4 && column === 2) page = true
                else if (list.length > 6 && column === 3) page = true
                else if (list.length > 8 && column === 4) page = true
                else if (list.length > 10 && column === 5) page - true
                return page
            },
            pageNum() {
                const column = this.column
                const list = this.list.length
                let page = Math.ceil(list / (column * 2))
                return page
            }
        },
        methods: {
            select() {
                VM.currentType = 'navigation',
                    VM.currentId = this.id
            },
        }
    })
// 标题
    Vue.component('headline', {
        props: ['id', 'text', 'padTb', 'padLr', 'align', 'fontColor', 'fontSize', 'bgColor', 'link', 'icon'],
        template: '<div @click="select" class="headline_wrapper" :style="currentStyle"><span class="iconfont" :class="icon"></span>{{text}}</div>',
        computed: {
            currentStyle() {
                return `font-size:${this.fontSize}px;color:${this.fontColor};background:${this.bgColor}; text-align: ${this.align}; padding: ${this.padTb}px ${this.padLr}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'headline',
                    VM.currentId = this.id
            },
        }
    })
// 搜索框
    Vue.component('search', {
        props: ['id', 'styles', 'searchColor', 'bgColor', 'fontColor', 'hotSearch', 'mtb', 'mlr', 'radius'],
        template: '<div @click="select" class="search" :style="wrapperBg"><div :style="input" class="search_input" ><span class="iconfont icon-sousuo"></span><span>{{hotSearch}}</span></div></div>',
        computed: {
            wrapperBg() {
                return `background:${this.bgColor}`
            },
            input() {
                return `background:${this.searchColor}; color:${this.fontColor}; margin: ${this.mtb}px ${this.mlr}px; border-radius:${this.radius}px`
            },
        },
        methods: {
            select() {
                VM.currentType = 'search',
                    VM.currentId = this.id
            },
        }
    })
//分割线
    Vue.component('lines', {
        props: ['id', 'styles', 'lineColor', 'bgColor', 'lineHeight', 'height'],
        template: '<div @click="select" class="line" :style="lineStyle"><div :style="hrStyle"></div></div>',
        computed: {
            lineStyle() {
                return `height: ${this.height}px; background: ${this.bgColor}`
            },
            hrStyle() {
                return `border-top: ${this.lineHeight}px ${this.styles} ${this.lineColor}`
            }
        },
        methods: {
            select() {
                VM.currentType = 'line',
                    VM.currentId = this.id
            },
        }
    })
// 图文集
    Vue.component('glossary', {
        props: ['id', 'styles', 'titleSize', 'titleColor', 'bgColor', 'lists'],
        template: '<div @click="select" class="glossarys"> <div v-if="styles === 1" v-for="(item, index) in lists" :key="index" class="itemWrapper clearfix" :style="wrapperColor"><img :src="item.img" class="style1_img"/><div class="style1_content"><div v-text="item.title" :style="title" class="glossary_title"></div><div class="glossary_innerText" v-text="item.innerText"></div></div></div><div v-if="styles === 2" v-for="(item, index) in lists" :key="index" class="itemWrapper" :style="wrapperColor"><img :src="item.img" class="style2_img""/><div  v-text="item.title" :style="title" class="glossary_title"></div><div class="glossary_innerText" v-text="item.innerText"></div></div></div>',
        computed: {
            wrapperColor() {
                return `background: ${this.bgColor}`
            },
            title() {
                return `fontSize: ${this.titleSize}px; color:${this.titleColor}`
            }
        },
        methods: {
            select() {
                VM.currentType = 'glossary',
                    VM.currentId = this.id
            },
        }
    })
// 按钮
    Vue.component('buttons', {
        props: ['id', 'parma'],
        template: '<div @click="select" class="buttons_wrapper"><div class="buttons" :style="buttonStyle"><img v-if="parma.icon" :src="parma.url"/><span v-text="parma.text"></span></div></div>',
        computed: {
            buttonStyle() {
                return this.parma.border ? `border:1px solid ${this.parma.borderColor}; background:${this.parma.bgColor};color:${this.parma.fontColor}; border-radius:${this.parma.radius}px` : `background:${this.parma.bgColor};color:${this.parma.fontColor}; border-radius:${this.parma.radius}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'button',
                    VM.currentId = this.id
            },
        }
    })
// 图片列表
    Vue.component('picture-list', {
        props: ['id', 'styles', 'column', 'radius', 'lists'],
        template: '<div @click="select"><div v-if="styles === 1" class="pictureList clearfix"><div class="fl picWrapper" v-for="(item, index) in lists" :key="index" :style="listStyle"><img :style="rad" :src="item.img" /><div v-text="item.title" class="title"></div></div></div><div v-if="styles === 2" class="pictureList clearfix"><div class="fl picWrapper"  v-for="(item, index) in lists" :key="index" :style="listStyle"><img :style="rad" :src="item.img" /><div v-text="item.title" class="titles"></div></div></div><div v-if="styles === 3" class="pictureList clearfix"><div class="fl picWrapper"  v-for="(item, index) in lists" :key="index" :style="listStyle"><img :style="rad" :src="item.img" /></div></div></div>',
        computed: {
            listStyle() {
                const column = this.column
                let width = 0
                if (column === 1) width = 100
                else if (column === 2) width = 50
                else if (column === 3) width = 33.3
                else width = 25
                return `width:${width}%;`
            },
            rad() {
                return `border-radius:${this.radius}%`
            }
        },
        methods: {
            select() {
                VM.currentType = 'pictureList',
                    VM.currentId = this.id
            },
        }
    })
// 悬浮图标
    Vue.component('fixed', {
        props: ['id', 'bottom', 'left', 'opacity', 'bgColor', 'img'],
        template: '<div @click="select" class="fixed_wrapper"><div  class="fixed" :style="currentStyle"><img :src="img"/></div></div>',
        computed: {
            currentStyle() {
                return `bottom: ${this.bottom}%; left:${this.left}%; opacity:${this.opacity}; background:${this.bgColor}`
            }
        },
        methods: {
            select() {
                VM.currentType = 'fixed',
                    VM.currentId = this.id
            },
        }
    })
// 视频
    Vue.component('videos', {
        props: ['id', 'poster', 'src', 'autoPlay'],
        template: '<div @click="select"><video :src="src" :poster="poster" :autoplay="autoPlay" width="100%" height="182px" controls="controls"></video></div>',
        methods: {
            select() {
                VM.currentType = 'video',
                    VM.currentId = this.id
            },
        }
    })
// 音频
    Vue.component('audios', {
        props: ['id', 'poster', 'src', 'name', 'author'],
        template: '<div @click="select" class="audioWrapper clearfix"><div class="posterWrapper fl"><img :src="poster"/><img @click="togglePlat" src="../addons/kundian_farm/resource/home/images/play.png" class="play"/></div><div class="inner_content"><div class="clearfix audio_title"><div class="fl " v-text="name"></div><div class="fr" v-text="currentTime"></div></div><div v-text="author" class="author"></div></div><audio ref="audio" :src="src" @timeupdate="updateTime"></audio></div>',
        data() {
            return {
                isPlay: false,
                currentTime: '0:00'
            }
        },
        methods: {
            select() {
                VM.currentType = 'audio',
                    VM.currentId = this.id
            },
            togglePlat() {
                let audio = this.$refs.audio
                if (this.isPlay) {
                    audio.pause()
                }
                else {
                    audio.play()
                }
                this.isPlay = !this.isPlay
            },
            updateTime(e) {
                let interval = e.target.currentTime
                let time = this.format(interval)
                this.currentTime = time
            },
            format(interval) {
                interval = interval | 0
                const minute = interval / 60 | 0
                const second = this._pad(interval % 60)
                return `${minute}:${second}`
            },
            _pad(num, n = 2) {
                let len = num.toString().length
                while (len < n) {
                    num = '0' + num
                    len++
                }
                return num
            },
        }
    })


    // 商品列表
    Vue.component('prolists', {
        props: ['id', 'list', 'fontColor', 'priceColor', 'btnColor', 'selectType', 'selectGroup', 'newList', 'listType'],
        template: '<div @click="select"><div v-if="listType == 1"><type-one :list="list" :fontColor="fontColor" :priceColor="priceColor" :btnColor="btnColor" :selectType="selectType" :selectGroup="selectGroup" :newList="newList"></type-one></div><div v-if="listType == 2"><type-two :list="list" :fontColor="fontColor" :priceColor="priceColor" :btnColor="btnColor" :selectType="selectType" :selectGroup="selectGroup" :newList="newList"></type-two></div><div v-if="listType == 3"><type-four :list="list" :fontColor="fontColor" :priceColor="priceColor" :btnColor="btnColor" :selectType="selectType" :selectGroup="selectGroup" :newList="newList"></type-four></div></div>',
        methods: {
            select() {
                VM.currentType = 'prolist',
                    VM.currentId = this.id
            }
        }
    })

    // 商品列表样式一
    Vue.component('typeOne', {
        props: ['list', 'fontColor', 'priceColor', 'btnColor', 'selectType', 'selectGroup', 'newList'],
        template: '<div class="proList"><div v-if="selectType == 1" class="clearfix proList_wrapper" :style="setWidth"><div v-for="(item, index) in list" :key="index" class="proItem"><div class="proItem_content"><img :src="item.cover" /><p :style="setTitleColor" v-text="item.goods_name" class="proTitle"></p></div></div></div><div v-if="selectType == 2" class="clearfix proList_wrapper"><div v-for="(item, index) in newList" :key="index" class="proItem" style="width:33.3%"><div class="proItem_content"><img :src="item.cover" /><p :style="setTitleColor" v-text="item.goods_name" class="proTitle"></p></div></div></div></div>',
        computed: {
            setWidth() {
                return `width:${this.list.length * 33.3}%`
            },
            setTitleColor() {
                return `color: ${this.fontColor}`
            },
            setPriceColor() {
                return `color: ${this.priceColor}`
            },
            setCarColor() {
                return `color: ${this.btnColor}`
            }
        }
    })
    // 商品列表样式二
    Vue.component('typeTwo', {
        props: ['list', 'fontColor', 'priceColor', 'btnColor', 'selectType', 'selectGroup', 'newList'],
        template: '<div><div class="type_wrapper"  v-if="selectType == 1"><div class="type_item" v-for="(item, index) in list"><img :src="item.cover"/><p :style="setTitleColor" v-text="item.goods_name" class="proTitle"></p><div class="buy_wrapper"><div :style="setPriceColor">￥{{item.price}}</div><div :style="setCarColor" class="iconfont icon-shopcar shopIcon"></div></div></div></div><div class="type_wrapper"  v-if="selectType == 2"><div class="type_item" v-for="(item, index) in newList"><img :src="item.cover"/><p :style="setTitleColor" v-text="item.goods_name" class="proTitle"></p><div class="buy_wrapper"><div :style="setPriceColor">￥{{item.price}}</div><div :style="setCarColor" class="iconfont icon-shopcar shopIcon"></div></div></div></div></div>',
        computed: {
            setTitleColor() {
                return `color: ${this.fontColor}`
            },
            setPriceColor() {
                return `color: ${this.priceColor}`
            },
            setCarColor() {
                return `color: ${this.btnColor}`
            }
        }
    })
    // 商品列表样式四
    Vue.component('typeFour', {
        props: ['list', 'fontColor', 'priceColor', 'btnColor', 'selectType', 'selectGroup', 'newList'],
        template: '<div class="types_wrapper"><div v-if="selectType == 1"><div v-for="(item, index) in list" class="types_item"><img :src="item.cover"/><div class="item_info"><p :style="setTitleColor" v-text="item.goods_name"></p><div class="item_info_desc">{{item.goods_remark}}</div><div class="buy_wrapper"><div :style="setPriceColor">￥{{item.price}}</div><div class="item_info_btn" :style="btnBg">马上抢</div></div></div></div></div> <div v-if="selectType == 2"><div v-for="(item, index) in newList" class="types_item"><img :src="item.cover"/><div class="item_info"><p :style="setTitleColor" v-text="item.goods_name"></p><div  class="item_info_desc">{{item.goods_remark}}</div><div class="buy_wrapper"><div :style="setPriceColor">￥{{item.price}}</div><div class="item_info_btn" :style="btnBg">马上抢</div></div></div></div></div></div>',
        computed: {
            setTitleColor() {
                return `color: ${this.fontColor}`
            },
            setPriceColor() {
                return `color: ${this.priceColor}`
            },
            setCarColor() {
                return `color: ${this.btnColor}`
            },
            btnBg() {
                return `background: ${this.btnColor}`
            }
        }
    })

    // 活动列表
    Vue.component('actives', {
        props: ['id', 'list'],
        template: '<div @click="select" class="list_wrapper"><div v-for="(item, index) in list" :key="index" class="list_item"><div class="item_img_wrapper"><div class="item_active_time">活动时间:{{item.end_time}}~{{item.end_time}}</div><img :src="item.cover"/></div><div class="item_info_wrapper"><div v-text="item.title" class="item_info_desc"></div><div class="item_join_wrapper"><div><span class="iconfont icon-yonghu"></span><span>参加人数{{item.person_count}}</span></div><div class="item_join_free" v-if="item.min_price > 0">￥{{item.min_price}}起</div><div v-else class="item_join_free">免费</div></div></div></div></div>',
        methods: {
            select() {
                VM.currentType = 'active',
                    VM.currentId = this.id
            }
        },
        filters: {
            formTime(value) {
                let times = value.split('-')
                times.splice(0, 1)
                return times.join('/')
            }
        }
    })
    Vue.component('official', {
        props: ['id', 'list'],
        template: '<div @click="select" class="official_wrapper" style="height: 50px;line-height: 50px;">这是个公众号展示板块</div>',
        methods: {
            select() {
                VM.currentType = 'official',
                    VM.currentId = this.id
            }
        },
    })

    //新活动
    Vue.component('newActives', {
        props: ['id', 'list'],
        template: `<div @click="select" class="new_list_wrapper clearfix" >
                <div v-for="(item, index) in list" :key="index" class="new_list_item">
                    <img :src="item.cover" width="100%" height="124px"/>
                    <div class="new_list_info">
                        <div>
                            <p class="new_list_title">{{item.title}}</p>
                            <p>参加人数:{{item.person_count}}人</p>
                        </div>
                        <div class="new_list_price" v-if="item.price > 0">￥{{item.min_price}}</div>
                        <div class="new_list_price" v-else>免费</div>
                    </div>
                </div>
            </div>`,
        computed:{
            getContentWidth() {
                return `width: ${this.list.length * 252}px`
            }
        },
        methods: {
            select() {
                VM.currentType = 'active',
                    VM.currentId = this.id
            }
        }
    })
    // 众筹
    Vue.component('crowds', {
        props: ['id', 'list'],
        template: '<div @click="select" class="crowd_wrapper"><div class="crowd_wrapper_item" v-for="(item, index) in list" :key="index"><img :src="item.img" /><div class="crowd_info_wrapper"><div class="crowd_info_wrappers"><div class="crowd_info_title" v-text="item.title"></div><div v-if="item.state == 0" class="crowd_info_state">预售中</div><div v-if="item.state == 1" class="crowd_info_state item_states">众筹成功</div></div><div class="crowd_info_wrappers"><div><p class="crowd_info_raise">周期:{{item.cycle}}</p><p class="crowd_info_raise">目标金额:{{item.total}}</p><p class="crowd_info_raise">认筹档位:{{item.price}}</p></div><div class="crowd_item_rate"><p>{{item.Rate}}</p><p>年化收益率</p></div></div></div></div></div>',
        methods: {
            select() {
                VM.currentType = 'crowd',
                    VM.currentId = this.id
            }
        },
    }),
    //新众筹
    Vue.component('newCrowds', {
        props:['id', 'list', 'selectType'],
        template: '<div @click="select" class="new_crowd_wrapper"> <div v-show="selectType === 1"> <div v-for="(item, index) in list" :key="index" class="new_crowd_item"><div class="new_crowd_rata">{{item.return_percent}}%</div><div class="new_crowd_text">往期同化</div><div class="new_crowd_term">众筹期限<span>{{item.end_time}}</span>个月</div><button class="new_crowd_join">立即加入</button></div> </div><div v-show="selectType === 2"><div v-for="(item, index) in list" :key="index" class="new_crowd_items"><div class="new_crowd_name">{{item.project_name}}</div><div class="new_crowd_content"><div class="item"><div>{{item.min_price}}</div><div>认筹金额</div></div><div class="item"><div>{{item.target_money}}</div><div>众筹目标</div></div><div class="item"><div>{{item.cycle}}天</div><div>众筹周期</div></div></div><div class="new_crowd_progress"><div class="new_crowd_progress-bar" :style="width(item.progress)"></div></div><div class="new_crowd_process"><div>剩余金额{{item.residue_money}}元</div><div>{{item.progress}}%</div></div></div></div></div>',
        methods: {
            select() {
                VM.currentType = 'crowd',
                    VM.currentId = this.id
            },
            width(progress) {
                return `width: ${progress}%`
            }
        },
    })

    // 新的搜索框
    Vue.component('newSearch', {
        template: `<div class="new_search_box">
            <input disabled placeholder="请输入关键词"/>
            <span class="iconfont icon-search"></span>
        </div>`
    })
})


