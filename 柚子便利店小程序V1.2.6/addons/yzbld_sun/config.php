<?php

return [
    "upload.file" =>__DIR__."/../../attachment/images/",
    "upload.image" =>__DIR__."/../../attachment/images/",
    "template_cache_dir" =>base_path()."/../../data/tpl/template_c",
    "uploadUrl"=>\App\Lib\Storage::instance()->getUploadUrl(),
    "menu" =>[
        ["title"=>"平台数据","icon"=>"fa-bar-chart","url"=>\Encore\Admin\Url::index('index'),
            "children"=>[]
        ],
        ["title"=>"商品管理","icon"=>"fa-hdd-o","url"=>"/",
            "children"=>[
                ["title"=>"商品列表","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('goods')],
                ["title"=>"商品分类","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('goods_class')],
                //["title"=>"商品添加","icon"=>"fa-bars","url"=>\Encore\Admin\Url::create('goods')],
            ]
        ],
        ["title"=>"门店管理","icon"=>"fa-bank","url"=>"/",
            "children"=>[
                ["title"=>"门店列表","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('store')],
                ["title"=>"门店商品","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('store_goods')],
                ["title"=>"门店轮播图","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('store_images')],
            ]
        ],
        ["title"=>"营销管理","icon"=>"fa-gift","url"=>"/",
            "children"=>[
               ["title"=>"限时抢购","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('limit_time_activity')],
               ["title"=>"每日秒杀","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('sec_kill_activity')],
               ["title"=>"活动商品","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('activity_goods')],
                ["title"=>"优惠券","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('coupon')],
            ]
        ],
        ["title"=>"财务管理","icon"=>"fa-bank","url"=>"/",
            "children"=>[
                ["title"=>"提现设置","icon"=>"fa-bars","url"=>\Encore\Admin\Url::show('withdraw_setting',
                    \App\Model\WithdrawSetting::instance()->first()->id)],
                ["title"=>"提现列表","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('dis_withdraw')],
                ["title"=>"资金明细","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('dis_amount_log')],
            ]
        ],
        ["title"=>"订单管理","icon"=>"fa-sliders","url"=>\Encore\Admin\Url::index('order')],
        ["title"=>"会员管理","icon"=>"fa-user","url"=>"/",
            "children"=>[
                ["title"=>"会员列表","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('user')],
                ["title"=>"会员优惠券","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('user_coupon')],
                ["title"=>"充值记录","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('recharge_log')],
            ]
        ],
        ["title"=>"广告管理","icon"=>"fa-life-ring","url"=>"/",
            "children"=>[
//                ["title"=>"首页轮播图","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('banner')],
                ["title"=>"公告管理","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('announcement')],
            ]
        ],
        ["title"=>"配送管理","icon"=>"fa-map-marker","url"=>"/",
            "children"=>[
                //["title"=>"配送员","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('dis_user')],
                ["title"=>"配送订单","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('dis_order')],
                ["title"=>"配送轮播图","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('dis_banner')],
                ["title"=>"配送费设置","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('distribution')],
            ]
        ],

        ["title"=>"系统设置","icon"=>"fa-cogs","url"=>"/",
            "children"=>[
                ["title"=>"首页导航菜单","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('nav')],
                ["title"=>"底部菜单","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('bottom_tab')],
                ["title"=>"小程序配置","icon"=>"fa-bars","url"=>\Encore\Admin\Url::show('system_info',
                    \App\Model\SystemInfo::instance()->first()->id)],
                ["title"=>"技术支持","icon"=>"fa-bars","url"=>\Encore\Admin\Url::show('tech',
                    \App\Model\SystemInfo::instance()->first()->id)],
                ["title"=>"充值配置","icon"=>"fa-bars","url"=>\Encore\Admin\Url::index('recharge')],
                ["title"=>"模板消息","icon"=>"fa-bars","url"=>\Encore\Admin\Url::show('msg_template',
                    \App\Model\SystemInfo::instance()->first()->id)],
                ["title"=>"短信配置","icon"=>"fa-bars","url"=>\Encore\Admin\Url::show('sms',
                    \App\Model\SystemInfo::instance()->first()->id)],
                ["title"=>"远程附件配置","icon"=>"fa-bars","url"=>\Encore\Admin\Url::show('storage',
                    \App\Model\SystemInfo::instance()->first()->id)],
            ]
        ],



    ],
    "actions"=>[
        "scanCode"=>"扫一扫",
        "index/seckill/seckill"=>"每日秒杀",
        "index/timebuy/timebuy"=>"限时抢购",
        "index/cards/cards"=>"领券中心",
        "index/branch/branch"=>"更多分店",
        "carts/carts"=>"购物车",
        "user/user"=>"我的",
        "classify/classify"=>"分类",
        "index/index"=>"首页",
        "user/myorder/myorder"=>"我的订单",
        "user/recharge/recharge"=>"充值",
        "classify/search/search"=>"搜索",
        "user/cards/cards"=>"用户优惠券",
        "user/shop/shop"=>"本店详情",
        "user/contact/contact"=>"联系店家",
    ]

];