var goodsVue = new Vue({
    el: '#listContent',
    data: {
        modularList:commonVue.getModular(),//获取模块信息列表
        goods_type: 0,//商品类型：1=团购(groupon)，2=抢购(rush)，3=拼团(wlfightgroup)，4=砍价(bargain)
        type_name: '团购',//当前商品类型名称
        infoData: [],//商品信息数组
        page:1,//当前页
        page_num:1,//总页数
        statusList:[],//状态列表
        classList:[],//分类列表
        getGoodsLink: '',//获取商品信息列表的请求地址
        copyGoodsLink: '',//复制商品请求地址
        setGoodsSale: '',//设置商品上架/下架请求地址
        toExamineLink: '',//商品审核请求地址
        deleteGoodsLink:'',//删除商品请求地址
    },
    methods: {
        //获取默认商品类型
        goodClass(){
            let goods_type = common.getUrlParam("goods_type");
            if(goods_type > 0){
                this.goods_type = goods_type;
            }else{
                if(this.modularList['groupon'] == 1){
                    this.goods_type = 1;
                }else if(this.modularList['rush'] == 1){
                    this.goods_type =  2;
                }else if(this.modularList['wlfightgroup'] == 1){
                    this.goods_type =  3;
                }else if(this.modularList['bargain'] == 1){
                    this.goods_type =  4;
                }
            }
        },
        //获取商品信息列表
        goodsList(){
            //获取搜索的条件
            let params = {
                page:this.page,
                name:$("[name='name']").val(),
                status:$("[name='status']").val(),
                goods_id:$("[name='goods_id']").val(),
                shop_name:$("[name='shop_name']").val(),
                cate_id:$("[name='cate_id']").val(),
                shop_id:$("[name='shop_id']").val()
            };
            //获取请求的地址
            if(this.getGoodsLink){
                //请求获取商品列表
                let res = commonVue.requestAjax(this.getGoodsLink,params);
                //重新赋值
                this.infoData = res['list'];
                this.page_num = res['page_num'];
            }else{
                this.infoData = [];
                this.page_num = 0;
            }
        },
        //更换商品按钮被点击  更换操作开始
        changeGoods(params){
            this.goods_type = params;
        },
        //进行翻页操作
        changePage (index) {
            this.page = index;
        },
        //清空搜索内容
        delSearch(state = false){
            $("[name='name']").val('');
            $("[name='status']").val(-1);
            $("[name='goods_id']").val('');
            $("[name='shop_name']").val('');
            $("[name='cate_id']").val(-1);
            $("[name='shop_id']").val('');
            if(state){
                this.goodsList();
            }
        },
        //返回移动端的完整链接信息
        appUrl(path,params){
            return common.appUrl(path, params,true)
        },
        //返回后台的完整链接信息
        webUrl(path,params){
            return common.webUrl(path, params,true)
        },
        //推荐商品 目前仅团购商品由此功能
        goodsRecommend(id){
            tip.confirm( '确认将此商品设置为推荐商品？',function () {
                let res = commonVue.requestAjax('groupon/active/recommend',{id:id});
                goodsVue.goodsList();//重新获取信息列表
            });
        },
        //商品信息复制
        goodCopying(id){
            tip.confirm( '确认复制该活动？被复制的活动会在已下架中显示',function () {
                let res = commonVue.requestAjax(goodsVue.copyGoodsLink,{id:id});
                goodsVue.goodsList();//重新获取信息列表
            });
        },
        //商品的上下架管理
        isSale(id,status){
            let statushtml = (status == 4) ? "上架" : "下架";
            tip.confirm( '确认将此商品'+statushtml+'？',function () {
                let res = commonVue.requestAjax(goodsVue.setGoodsSale,{id:id,status:status});
                goodsVue.goodsList();//重新获取信息列表
            });
        },
        //审核商品是否通过
        goodsToExamine(id,flag){
            let statushtml = (flag == 1) ? "通过" : "不通过";
            tip.confirm( '确认商品审核'+statushtml+'？',function () {
                let res = commonVue.requestAjax(goodsVue.toExamineLink,{id:id,flag:flag});
                goodsVue.goodsList();//重新获取信息列表
            });
        },
        //删除商品信息
        deleteGoodsInfo(id){
            tip.confirm( '此操作会删除当前商品，同时会导致订单商品数据缺失或其他问题，确定要删除吗？',function () {
                let res = commonVue.requestAjax(goodsVue.deleteGoodsLink,{id:id});
                goodsVue.goodsList();//重新获取信息列表
            });
        },
        //改变基本信息 商品类型：1=团购，2=抢购，3=拼团，4=砍价
        changeInfo() {
            //配置当前商品的基本操作信息
            switch (this.goods_type) {
                case 1:case '1':
                    //商品类型 - 团购
                    this.type_name = '团购';
                    //获取团购商品状态列表
                    this.statusList = [
                        {'name':'未上架','status':0},
                        {'name':'未开始','status':1},
                        {'name':'进行中','status':2},
                        {'name':'已结束','status':3},
                        {'name':'下架中','status':4},
                        {'name':'待审核','status':5},
                        {'name':'未通过','status':6},
                        {'name':'已抢完','status':7},
                    ];
                    //获取团购商品的分类列表(可使用的分类)
                    this.classList = commonVue.requestAjax('groupon/active/getClassList');
                    //获取团购商品信息列表的请求地址
                    this.getGoodsLink = 'groupon/active/groupList';
                    //复制团购商品的请求地址
                    this.copyGoodsLink = 'groupon/active/copygood';
                    //设置团购商品上架/下架请求地址
                    this.setGoodsSale = 'groupon/active/delete';
                    //团购商品审核请求地址
                    this.toExamineLink = 'groupon/active/examine';
                    //删除团购商品请求地址
                    this.deleteGoodsLink = 'groupon/active/delall';
                    break;
                case 2:case '2':
                    //商品类型 - 抢购
                    this.type_name = '抢购';
                    //获取抢购商品状态列表
                    this.statusList = [
                        {'name':'待开始','status':1},
                        {'name':'进行中','status':2},
                        {'name':'已结束','status':3},
                        {'name':'已下架','status':4},
                        {'name':'待审核','status':5},
                        {'name':'未通过','status':6},
                        {'name':'已抢完','status':7},
                    ];
                    //获取抢购商品的分类列表(可使用的分类)
                    this.classList = commonVue.requestAjax('rush/active/getClassList');
                    //获取抢购商品信息列表的请求地址
                    this.getGoodsLink = 'rush/active/rushList';
                    //复制抢购商品的请求地址
                    this.copyGoodsLink = 'rush/active/copygood';
                    //设置抢购商品上架/下架请求地址
                    this.setGoodsSale = 'rush/active/delete';
                    //抢购商品审核请求地址
                    this.toExamineLink = 'rush/active/examine';
                    //删除抢购商品请求地址
                    this.deleteGoodsLink = 'rush/active/delall';
                    break;
                case 3:case '3':
                    //商品类型 - 拼团
                    this.type_name = '拼团';
                    //获取拼团商品状态列表
                    this.statusList = [
                        {'name':'未上架','status':0},
                        {'name':'销售中','status':1},
                        {'name':'已删除','status':4},
                        {'name':'审核中','status':5},
                        {'name':'未通过','status':6},
                    ];
                    //获取拼团商品的分类列表(可使用的分类)
                    this.classList = commonVue.requestAjax('wlfightgroup/fightgoods/getClassList');
                    //获取拼团商品信息列表的请求地址
                    this.getGoodsLink = 'wlfightgroup/fightgoods/fightList';
                    //复制拼团商品的请求地址
                    this.copyGoodsLink = 'wlfightgroup/fightgoods/copygood';
                    //设置拼团商品上架/下架请求地址
                    this.setGoodsSale = 'wlfightgroup/fightgoods/delete';
                    //拼团商品审核请求地址
                    this.toExamineLink = 'wlfightgroup/fightgoods/toExamine';
                    //删除拼团商品请求地址
                    this.deleteGoodsLink = 'wlfightgroup/fightgoods/deleteGoods';
                    break;
                case 4:case '4':
                    //商品类型 - 砍价
                    this.type_name = '砍价';
                    //获取砍价商品状态列表
                    this.statusList = [
                        {'name':'未上架','status':0},
                        {'name':'未开始','status':1},
                        {'name':'进行中','status':2},
                        {'name':'已结束','status':3},
                        {'name':'下架中','status':4},
                        {'name':'待审核','status':5},
                        {'name':'未通过','status':6},
                    ];
                    //获取砍价商品的分类列表(可使用的分类)
                    this.classList = commonVue.requestAjax('bargain/bargain_web/getClassList');
                    //获取砍价商品信息列表的请求地址
                    this.getGoodsLink = 'bargain/bargain_web/bargainList';
                    //复制砍价商品的请求地址
                    this.copyGoodsLink = 'bargain/bargain_web/copygood';
                    //设置砍价商品上架/下架请求地址
                    this.setGoodsSale = 'bargain/bargain_web/changestatus';
                    //砍价商品审核请求地址
                    this.toExamineLink = 'bargain/bargain_web/pass';
                    //删除砍价商品请求地址
                    this.deleteGoodsLink = 'bargain/bargain_web/delall';
                    break;
            }
            //使用jq方法 遍历需要复制链接的内容
            common.copyLink();
        },
    },
    watch: {
        //goods_type 被改变
        goods_type(){
            this.delSearch();//清空搜索内容
            this.changeInfo();//改变基本配置信息
            this.goodsList();//从新获取商品信息列表
        },
        //page 被改变
        page(){
            this.goodsList();
        },
    },
    //进入页面请求获取信息
    mounted() {
        this.goodClass();//改变默认商品类型


    }
});