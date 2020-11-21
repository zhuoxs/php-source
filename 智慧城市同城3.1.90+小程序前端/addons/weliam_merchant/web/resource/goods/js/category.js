var goodsCateVue = new Vue({
    el: '#listContent',
    data: {
        modularList:commonVue.getModular(),//获取模块信息列表
        cate_type: 0,//分类类型：1=团购(groupon)，2=抢购(rush)，3=拼团(wlfightgroup)，4=砍价(bargain)
        type_name: '团购',//当前分类类型名称
        infoData: [],//分类列表信息数组
        page:1,//当前页
        page_num:1,//总页数
        getCateLink: '',//获取商品信息列表的请求地址
        categoryParent:[],//上级分类列表
    },
    methods: {
        //获取默认分类类型
        goodClass(){
            let cate_type = common.getUrlParam("cate_type");
            if(cate_type > 0){
                this.cate_type = cate_type;
            }else{
                if(this.modularList['groupon'] == 1){
                    this.cate_type = 1;
                }else if(this.modularList['rush'] == 1){
                    this.cate_type =  2;
                }else if(this.modularList['wlfightgroup'] == 1){
                    this.cate_type =  3;
                }else if(this.modularList['bargain'] == 1){
                    this.cate_type =  4;
                }
            }
        },
        //更换类型按钮被点击  更换操作开始
        changeCate(params){
            this.cate_type = params;
        },
        //进行翻页操作
        changePage (index) {
            this.page = index;
        },
        //清空搜索内容
        delSearch(state = false){
            $("[name='name']").val('');
            if(state){
                this.cateList();
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
        //获取分类信息列表
        cateList(){
            //获取搜索的条件
            let params = {
                page:this.page,
                cate_type:this.cate_type,
                name: $("[name='name']").val(),
            };
            //请求获取列表信息
            let res = commonVue.requestAjax('goods/Goods/getCateList',params);
            //重新赋值
            this.infoData = res['list'];
            this.page_num = res['page_num'];
        },
        //改变基本信息 商品类型：1=团购，2=抢购，3=拼团，4=砍价
        changeInfo() {
            //配置当前商品的基本操作信息
            switch (this.cate_type) {
                case 1:case '1':
                    //分类类型 - 团购
                    this.type_name = '团购';
                    break;
                case 2:case '2':
                    //分类类型 - 抢购
                    this.type_name = '抢购';
                    break;
                case 3:case '3':
                    //分类类型 - 拼团
                    this.type_name = '拼团';
                    break;
                case 4:case '4':
                    //分类类型 - 砍价
                    this.type_name = '砍价';
                    break;
            }
        },
        //修改分类的开启&关闭
        updateSwitch(id,value){
            //请求修改内容
            let params = {
                id: id,
                cate_type: this.cate_type,
                field: 'is_show',
                value: value,
            };
            let res = commonVue.requestAjax('goods/Goods/updateGoodsCate',params,true);
            //重新渲染列表信息
            this.cateList();//从新获取分类信息列表
        },
        //删除分类信息
        deleteCate(id){
            //参数配置
            let params = {
                id: id,
                cate_type: this.cate_type,
            };
            //请求删除
            tip.confirm( '此操作会删除当前分类，同时会导致商品分类数据缺失或其他问题，确定要删除吗？',function () {
                let res = commonVue.requestAjax('goods/Goods/delGoodsCate',params,true);
                if(res.status == 0){
                    tip.msgbox.err(res.result.message);
                }else{
                    tip.msgbox.suc(res.result.message);
                    goodsCateVue.cateList();//重新渲染列表信息
                }
            });
        },
        //添加/编辑分类信息
        edit(state){
            //团购时获取所有的一级分类
            if(this.cate_type == 1){
                //获取搜索的条件
                let params = {
                    page:1,
                    cate_type:this.cate_type,
                    index:100,
                };
                //请求获取列表信息
                let res = commonVue.requestAjax('goods/Goods/getCateList',params);
                //重新赋值
                this.categoryParent = res['list'];
            }
            //弹出表单内容
            $("#editGoodsCate").modal();
        }
    },
    watch: {
        //cate_type 被改变
        cate_type(){
            this.delSearch();//清空搜索内容
            this.changeInfo();//改变基本配置信息
            this.cateList();//从新获取分类信息列表
        },
        //page 被改变
        page(){
            this.cateList();
        },
    },
    //进入页面请求获取信息
    mounted() {
        this.goodClass();//改变默认商品类型
    }
});