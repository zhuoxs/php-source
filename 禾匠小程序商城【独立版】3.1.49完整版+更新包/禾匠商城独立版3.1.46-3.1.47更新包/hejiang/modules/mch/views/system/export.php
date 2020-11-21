<?php
/**
 * Created by PhpStorm.
 * User: 风哀伤
 * Date: 2019/7/9
 * Time: 15:58
 * @copyright: ©2019 浙江禾匠信息科技
 * @link: http://www.zjhejiang.com
 */
$this->title = $title = '商城导出';
$urlManager = Yii::$app->urlManager;
?>
<style>
    .export-content div {
        width: 160px;
        margin: 20px 0 0 20px;
    }
</style>
<div class="panel mb-3">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <div class="mb-3 clearfix" id="app">
            <div style="background-color: #fce9e6;width: 100%;border-color: #edd7d4;color: #e55640;border-radius: 2px;padding: 15px;margin-bottom: 20px;">
                注：为了服务器性能和用户体验考虑，请在用户少的时候进行导出数据操作！！！
            </div>
            <form class="auto-form" method="post" v-if="loading" target="_blank" :action="url">
                <div style="margin-bottom: 24px;">导出内容</div>
                <div class="card" v-for="item in list" style="margin-bottom: 16px;">
                    <div class="card-header" style="height: 50px;background-color: #f3f5f6">
                        {{item.name}}
                    </div>
                    <div class="card-body export-content" flex="dir:left" style="flex-wrap: wrap;padding-bottom: 20px;">
                        <div v-for="value in item.content">{{value.name}}</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" href="javascript:">导出</button>
            </form>
        </div>
    </div>
</div>
<script>
    const app = new Vue({
        el: '#app',
        data() {
            return {
                loading: true,
                url: '<?= $urlManager->createUrl(["mch/system/export"])?>',
                list: [
                    {
                        name: '基本数据',
                        content: [
                            {
                                name: '微信基本配置',
                            },
                            {
                                name: '轮播图',
                            },
                            {
                                name: '导航图标',
                            },
                            {
                                name: '图片魔方',
                            },
                            {
                                name: '导航栏',
                            },
                            {
                                name: '首页布局',
                            },
                            {
                                name: '用户中心',
                            },
                            {
                                name: '版权设置',
                            },
                            {
                                name: '商城设置-基本设置',
                            },
                            {
                                name: '商城设置-图标设置',
                            },
                        ]
                    },
                    {
                        name: '用户数据',
                        content: [
                            {
                                name: '会员等级'
                            },
                            {
                                name: '用户管理'
                            },
                            {
                                name: '分销数据'
                            },
                        ]
                    },
                    {
                        name: '商品信息',
                        content: [
                            {
                                name: '商城商品分类'
                            },
                            {
                                name: '商城商品'
                            },
                            {
                                name: '秒杀商品'
                            },
                            {
                                name: '拼团商品'
                            },
                            {
                                name: '拼团商品分类'
                            },
                            {
                                name: '预约商品分类'
                            },
                            {
                                name: '预约商品'
                            },
                            {
                                name: '积分商城商品'
                            },
                            {
                                name: '积分商城商品分类'
                            },
                        ]
                    }
                ]
            }
        },
        methods: {}
    });
</script>
