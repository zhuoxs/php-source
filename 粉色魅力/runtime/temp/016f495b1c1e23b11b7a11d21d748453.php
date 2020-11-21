<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"/www/wwwroot/testxt.com/application/admin/view/system/config.html";i:1545657334;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/head.html";i:1522628860;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?> - 苹果CMS</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/admin_style.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script>
        var ROOT_PATH="",ADMIN_PATH="<?php echo $_SERVER['SCRIPT_NAME']; ?>", MAC_VERSION='v10';
    </script>
</head>
<body>

<div class="page-container">

    <div class="showpic" style="display:none;"><img class="showpic_img" width="120" height="160"></div>

    <form class="layui-form layui-form-pane" action="">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">基本设置</li>
                <li>性能优化</li>
                <li>预留参数</li>
            </ul>
            <div class="layui-tab-content">

                <div class="layui-tab-item layui-show">
                <div class="layui-form-item">
                    <label class="layui-form-label">网站名称：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_name]" placeholder="xxx在线视频网站" value="<?php echo $config['site']['site_name']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站域名：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_url]" placeholder="如：www.maccms.com,不要加http://" value="<?php echo $config['site']['site_url']; ?>" class="layui-input">
                    </div>
                </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机站域名：</label>
                        <div class="layui-input-block">
                            <input type="text" name="site[site_wapurl]" placeholder="如：www.maccms.com,不要加http://" value="<?php echo $config['site']['site_wapurl']; ?>" class="layui-input">
                        </div>
                    </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">关键字：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_keywords]" placeholder="一般不超过100个字符" value="<?php echo $config['site']['site_keywords']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">描述信息：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_description]" placeholder="一般不超过200个字符" value="<?php echo $config['site']['site_description']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">备案号：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_icp]" placeholder="京ICP备00000000号" value="<?php echo $config['site']['site_icp']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">QQ号码：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_qq]" placeholder="站长客服qq号码" value="<?php echo $config['site']['site_qq']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Email邮箱：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[site_email]" placeholder="站长客服邮箱" value="<?php echo $config['site']['site_email']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">安装目录：</label>
                    <div class="layui-input-block">
                        <input type="text" name="site[install_dir]" placeholder="根目录 ＂/＂，二级目录 ＂/maccms/＂以此类推" value="<?php echo $config['site']['install_dir']; ?>" class="layui-input">
                    </div>
                </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">默认LOGO：</label>
                        <div class="layui-input-inline w600">
                            <input type="text" name="site[site_logo]" placeholder="图片地址或路径" value="<?php echo $config['site']['site_logo']; ?>" class="layui-input upload-input">
                        </div>
                        <div class="layui-input-inline ">
                            <button type="button" class="layui-btn layui-upload" lay-data="{data:{thumb:0,thumb_class:'site[site_logo]'}}" id="upload1">上传图片</button>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机站LOGO：</label>
                        <div class="layui-input-inline w600">
                            <input type="text" name="site[site_waplogo]" placeholder="图片地址或路径" value="<?php echo $config['site']['site_waplogo']; ?>" class="layui-input upload-input">
                        </div>
                        <div class="layui-input-inline ">
                            <button type="button" class="layui-btn layui-upload" lay-data="{data:{thumb:0,thumb_class:'upload-thumb'}}" id="upload2">上传图片</button>
                        </div>
                    </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">网站模板：</label>
                    <div class="layui-input-inline" >
                            <select class="w150" name="site[template_dir]">
                                <?php if(is_array($templates) || $templates instanceof \think\Collection || $templates instanceof \think\Paginator): $i = 0; $__LIST__ = $templates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo; ?>" <?php if($config['site']['template_dir'] == $vo): ?>selected <?php endif; ?>><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                    </div>
                    <label class="layui-form-label">模板目录：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="site[html_dir]" placeholder="" value="<?php echo $config['site']['html_dir']; ?>" class="layui-input w150" >
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">自适应手机：</label>
                    <div class="layui-input-inline w300">
                        <input type="radio" name="site[mob_status]" value="0" title="关闭" <?php if($config['site']['mob_status'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="site[mob_status]" value="1" title="多域" <?php if($config['site']['mob_status'] == 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="site[mob_status]" value="2" title="单域" <?php if($config['site']['mob_status'] == 2): ?>checked <?php endif; ?>>
                    </div>
                    <div class="layui-form-mid layui-word-aux">多域名：访问wap域名会自动使用手机模板；单域名：手机访问会自动使用手机模板；</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手机模板：</label>
                    <div class="layui-input-inline">
                            <select class="w150" name="site[mob_template_dir]">
                                <?php if(is_array($templates) || $templates instanceof \think\Collection || $templates instanceof \think\Paginator): $i = 0; $__LIST__ = $templates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo; ?>" <?php if($config['site']['mob_template_dir'] == $vo): ?>selected <?php endif; ?>><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                    </div>
                    <label class="layui-form-label">模板目录：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="site[mob_html_dir]" placeholder="" value="<?php echo $config['site']['mob_html_dir']; ?>" class="layui-input w150" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">统计代码：</label>
                    <div class="layui-input-block">
                        <textarea name="site[site_tj]" class="layui-textarea"  placeholder="请输入第三方网站统计代码"><?php echo $config['site']['site_tj']; ?></textarea>
                    </div>
                </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">站点状态：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="site[site_status]" value="0" title="关闭" <?php if($config['site']['site_status'] == 0): ?>checked <?php endif; ?>>
                            <input type="radio" name="site[site_status]" value="1" title="开启" <?php if($config['site']['site_status'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">关闭提示：</label>
                        <div class="layui-input-block">
                            <textarea name="site[site_close_tip]" class="layui-textarea"  placeholder="请输入站点关闭后的提示信息"><?php echo $config['site']['site_close_tip']; ?></textarea>
                        </div>
                    </div>
            </div>

                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">PATH分隔符：</label>
                        <div class="layui-input-inline w150">
                            <select class="w150" name="app[pathinfo_depr]">
                                <option value="/" <?php if($config['app']['pathinfo_depr'] == '/'): ?>selected <?php endif; ?>>斜杠/</option>
                                <option value="-" <?php if($config['app']['pathinfo_depr'] == '-'): ?>selected <?php endif; ?>>中横线-</option>
                                <option value="_" <?php if($config['app']['pathinfo_depr'] == '_'): ?>selected <?php endif; ?>>下横线_</option>
                            </select>
                        </div>
                        <div class="layui-form-mid layui-word-aux">PATHINFO分隔符 修改后将改变非静态模式下URL地址</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">页面后缀名：</label>
                        <div class="layui-input-inline">
                            <select style="width:150px;" name="app[suffix]">
                                <option value="html" <?php if($config['app']['suffix'] == 'html'): ?>selected <?php endif; ?>>html</option>
                                <option value="htm" <?php if($config['app']['suffix'] == 'htm'): ?>selected <?php endif; ?>>htm</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">数据权限过滤：</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="app[popedom_filter]" value="0" title="关闭" <?php if($config['app']['popedom_filter'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="app[popedom_filter]" value="1" title="开启" <?php if($config['app']['popedom_filter'] == 1): ?>checked <?php endif; ?>>
                        </div>
                        <div class="layui-form-mid layui-word-aux">开启后将隐藏没有权限的分类和数据</div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">缓存方式：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="app[cache_type]" lay-filter="cache_type" value="file" title="file" <?php if($config['app']['cache_type'] == '0' || $config['app']['cache_type'] == 'file'): ?>checked <?php endif; ?>>
                            <input type="radio" name="app[cache_type]" lay-filter="cache_type" value="memcache" title="memcache" <?php if($config['app']['cache_type'] == '1' || $config['app']['cache_type'] == 'memcache'): ?>checked <?php endif; ?>>
                            <input type="radio" name="app[cache_type]" lay-filter="cache_type" value="redis" title="redis" <?php if($config['app']['cache_type'] == '2' || $config['app']['cache_type'] == 'redis'): ?>checked <?php endif; ?>>
                            <input type="radio" name="app[cache_type]" lay-filter="cache_type" value="memcached" title="memcached" <?php if($config['app']['cache_type'] == '3' || $config['app']['cache_type'] == 'memcached'): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item row_cache_server " <?php if($config['app']['cache_type'] == '0' || $config['app']['cache_type'] == 'file'): ?> style="display:none;" <?php endif; ?>>
                        <label class="layui-form-label">服务器：</label>
                        <div class="layui-input-inline w150">
                            <input type="text" name="app[cache_host]" placeholder="缓存服务器IP" value="<?php echo $config['app']['cache_host']; ?>" class="layui-input" >
                        </div>
                        <label class="layui-form-label">端口：</label>
                        <div class="layui-input-inline w150">
                            <input type="text" name="app[cache_port]" placeholder="缓存服务器端口" value="<?php echo $config['app']['cache_port']; ?>" class="layui-input" >
                        </div>
                        <label class="layui-form-label">账号：</label>
                        <div class="layui-input-inline">
                            <input type="text" name="app[cache_username]" placeholder="缓存服务账号,没有请留空" value="<?php echo $config['app']['cache_username']; ?>" class="layui-input" >
                        </div>
                        <label class="layui-form-label">密码：</label>
                        <div class="layui-input-inline">
                            <input type="text" name="app[cache_password]" placeholder="缓存服务密码,没有请留空" value="<?php echo $config['app']['cache_password']; ?>" class="layui-input" >
                        </div>
                        <button type="button" class="layui-btn layui-btn-normal" onclick="test_cache()">测试连接</button>
                    </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">缓存标识：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="app[cache_flag]" placeholder="留空将自动生成" value="<?php echo $config['app']['cache_flag']; ?>" class="layui-input w150" >
                    </div>
                    <div class="layui-form-mid layui-word-aux">多站共用一个服务器上memcache、redis时需区分开</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">数据缓存：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="app[cache_core]" value="0" title="关闭" <?php if($config['app']['cache_core'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[cache_core]" value="1" title="开启" <?php if($config['app']['cache_core'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">数据缓存时间：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="app[cache_time]" placeholder="建议设置为3600以上" value="<?php echo $config['app']['cache_time']; ?>" class="layui-input w150" >
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位秒建议设置为3600以上</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">页面缓存：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="app[cache_page]" value="0" title="关闭" <?php if($config['app']['cache_page'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[cache_page]" value="1" title="开启" <?php if($config['app']['cache_page'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">页面缓存时间：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="app[cache_time_page]" placeholder="建议设置为3600以上" value="<?php echo $config['app']['cache_time_page']; ?>" class="layui-input w150" >
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位秒建议设置为3600以上</div>
                </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">压缩页面：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="app[compress]" value="0" title="关闭" <?php if($config['app']['compress'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="app[compress]" value="1" title="开启" <?php if($config['app']['compress'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">搜索开关：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="app[search]" value="0" title="关闭" <?php if($config['app']['search'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[search]" value="1" title="开启" <?php if($config['app']['search'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">搜索间隔：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="app[search_timespan]" placeholder="建议设置为3秒以上" value="<?php echo $config['app']['search_timespan']; ?>" class="layui-input w150">
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位秒，建议设置为3秒以上</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">视频搜索规则：</label>
                    <div class="layui-input-inline w600">
                        <input type="checkbox" lay-skin="primary" name="app[search_vod_rule][]" value="vod_name" title="名称" checked disabled>
                        <input type="checkbox" lay-skin="primary" name="app[search_vod_rule][]" value="vod_en" title="拼音" <?php if(strpos($config['app']['search_vod_rule'],'vod_en') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="app[search_vod_rule][]" value="vod_sub" title="副标" <?php if(strpos($config['app']['search_vod_rule'],'vod_sub') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="app[search_vod_rule][]" value="vod_tag" title="tag" <?php if(strpos($config['app']['search_vod_rule'],'vod_tag') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="app[search_vod_rule][]" value="vod_actor" title="主演" <?php if(strpos($config['app']['search_vod_rule'],'vod_actor') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="app[search_vod_rule][]" value="vod_director" title="导演" <?php if(strpos($config['app']['search_vod_rule'],'vod_director') !==false): ?>checked <?php endif; ?>>
                    </div>
                    <div class="layui-form-mid layui-word-aux">注意，仅影响wd参数，勾选过多影响性能，建议3个以内</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">文章搜索规则：</label>
                    <div class="layui-input-inline w600">
                        <input type="checkbox" lay-skin="primary" name="app[search_art_rule][]" value="art_name" title="名称" checked disabled>
                        <input type="checkbox" lay-skin="primary" name="app[search_art_rule][]" value="art_en" title="拼音" <?php if(strpos($config['app']['search_art_rule'],'art_en') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="app[search_art_rule][]" value="art_sub" title="副标" <?php if(strpos($config['app']['search_art_rule'],'art_sub') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="app[search_art_rule][]" value="art_tag" title="tag" <?php if(strpos($config['app']['search_art_rule'],'art_tag') !==false): ?>checked <?php endif; ?>>
                    </div>
                    <div class="layui-form-mid layui-word-aux">注意，仅影响wd参数，勾选过多影响性能，建议3个以内</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">版权提示：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="app[copyright_status]" value="0" title="关闭" <?php if($config['app']['copyright_status'] == 0): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[copyright_status]" value="1" title="提示信息" <?php if($config['app']['copyright_status'] == 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[copyright_status]" value="2" title="内容页跳转" <?php if($config['app']['copyright_status'] == 2): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[copyright_status]" value="3" title="播放页跳转" <?php if($config['app']['copyright_status'] == 3): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[copyright_status]" value="4" title="iframe播放页跳转" <?php if($config['app']['copyright_status'] == 4): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">版权提示信息：</label>
                    <div class="layui-input-inline w500">
                        <input type="text" name="app[copyright_notice]" placeholder="版权提示信息" value="<?php echo $config['app']['copyright_notice']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">采集间隔：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="app[collect_timespan]" placeholder="建议设置为3秒以上" value="<?php echo $config['app']['collect_timespan']; ?>" class="layui-input w150">
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位秒，建议设置为3秒以上</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">后台每页数：</label>
                    <div class="layui-input-block">
                        <input type="text" name="app[pagesize]" placeholder="每页显示数据量、一般设置为20左右" value="<?php echo $config['app']['pagesize']; ?>" class="layui-input w150">
                    </div>
                </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">生成每页数：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[makesize]" placeholder="批量生成每次生成都少页、一般设置为20左右" value="<?php echo $config['app']['makesize']; ?>" class="layui-input w150">
                        </div>
                    </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">后台登录验证码：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="app[admin_login_verify]" value="0" title="关闭" <?php if($config['app']['admin_login_verify'] == '0'): ?>checked <?php endif; ?>>
                        <input type="radio" name="app[admin_login_verify]" value="1" title="开启" <?php if($config['app']['admin_login_verify'] != '0'): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">富文本编辑器：</label>
                    <div class="layui-input-inline">
                        <select style="width:150px;" name="app[editor]">
                            <option value="ueditor" <?php if($config['app']['editor'] == 'ueditor' || $config['app']['editor'] == ''): ?>selected <?php endif; ?>>ueditor</option>
                            <option value="umeditor" <?php if($config['app']['editor'] == 'umeditor'): ?>selected <?php endif; ?>>umeditor</option>
                            <option value="kindeditor" <?php if($config['app']['editor'] == 'kindeditor'): ?>selected <?php endif; ?>>kindeditor</option>
                            <option value="ckeditor" <?php if($config['app']['editor'] == 'ckeditor'): ?>selected <?php endif; ?>>ckeditor</option>
                        </select>
                    </div>
                    <div class="layui-form-mid layui-word-aux">系统默认带ueditor，使用其他请先到官网下载扩展包</div>
                </div>

            </div>

                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">播放器顺序：</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="app[player_sort]" value="0" title="添加" <?php if($config['app']['player_sort'] == 0): ?>checked <?php endif; ?>>
                            <input type="radio" name="app[player_sort]" value="1" title="全局" <?php if($config['app']['player_sort'] == 1): ?>checked <?php endif; ?>>
                        </div>
                        <div class="layui-form-mid layui-word-aux">模板里展示的播放器排列顺序</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">加密地址：</label>
                        <div class="layui-input-inline">
                            <select style="width:150px;" name="app[encrypt]">
                                <option value="0">不加密</option>
                                <option value="1" <?php if($config['app']['encrypt'] == 1): ?>selected <?php endif; ?>>escape编码</option>
                                <option value="2" <?php if($config['app']['encrypt'] == 2): ?>selected <?php endif; ?>>base64编码</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">搜索热词：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[search_hot]" placeholder="搜索热词多个请用,号分割" value="<?php echo $config['app']['search_hot']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">文章扩展分类：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[art_extend_class]" placeholder="文章扩展分类" value="<?php echo $config['app']['art_extend_class']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">视频扩展分类：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_class]" placeholder="视频扩展分类" value="<?php echo $config['app']['vod_extend_class']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">视频资源：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_state]" placeholder="" value="<?php echo $config['app']['vod_extend_state']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">视频版本：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_version]" placeholder="" value="<?php echo $config['app']['vod_extend_version']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">视频地区：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_area]" placeholder="" value="<?php echo $config['app']['vod_extend_area']; ?>" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">视频语言：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_lang]" placeholder="" value="<?php echo $config['app']['vod_extend_lang']; ?>" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">视频年代：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_year]" placeholder="" value="<?php echo $config['app']['vod_extend_year']; ?>" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">视频周期：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[vod_extend_weekday]" placeholder="" value="<?php echo $config['app']['vod_extend_weekday']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">演员地区：</label>
                        <div class="layui-input-block">
                            <input type="text" name="app[actor_extend_area]" placeholder="" value="<?php echo $config['app']['actor_extend_area']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">词语过滤：</label>
                        <div class="layui-input-block">
                            <textarea name="app[filter_words]" class="layui-textarea" placeholder="用户交互如评论留言的禁用词汇；多个用,号分隔"><?php echo $config['app']['filter_words']; ?></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">自定义参数：</label>
                        <div class="layui-input-block">
                            <textarea name="app[extra_var]" class="layui-textarea" placeholder="每行一个变量,例如aa$$$我是老王；模板调用方法$GLOBALS['config']['extra']['aa']"><?php echo $config['app']['extra_var']; ?></textarea>
                        </div>
                    </div>
                </div>


                <div class="layui-form-item center">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">保 存</button>
                        <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript">
    layui.use(['form','upload', 'layer'], function(){
        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , upload = layui.upload;

        form.on('radio(cache_type)',function(data){
            $('.row_cache_server').hide();
           if(data.value=='memcache' || data.value=='redis' || data.value=='memcached'){
               $('.row_cache_server').show();
           }
        });


        upload.render({
            elem: '.layui-upload'
            ,url: "<?php echo url('upload/upload'); ?>?flag=site"
            ,method: 'post'
            ,before: function(input) {
                layer.msg('文件上传中...', {time:3000000});
            },done: function(res, index, upload) {
                var obj = this.item;
                if (res.code == 0) {
                    layer.msg(res.msg);
                    return false;
                }
                layer.closeAll();
                var input = $(obj).parent().parent().find('.upload-input');
                if ($(obj).attr('lay-type') == 'image') {
                    input.siblings('img').attr('src', res.data.file).show();
                }
                input.val(res.data.file);

                if(res.data.thumb_class !=''){
                    $('.'+ res.data.thumb_class).val(res.data.thumb[0].file);
                }
            }
        });

        $('.upload-input').hover(function (e){
            var e = window.event || e;
            var imgsrc = $(this).val();
            if(imgsrc.trim()==""){ return; }
            var left = e.clientX+document.body.scrollLeft+20;
            var top = e.clientY+document.body.scrollTop+20;
            $(".showpic").css({left:left,top:top,display:""});
            if(imgsrc.indexOf('://')<0){ imgsrc = ROOT_PATH + '/' + imgsrc;	} else{ imgsrc = imgsrc.replace('mac:','http:'); }
            $(".showpic_img").attr("src", imgsrc);
        },function (e){
            $(".showpic").css("display","none");
        });


    });

    function test_cache(){
        var type = $("input[name='app[cache_type]']:checked").val();
        var host = $("input[name='app[cache_host]']").val();
        var port = $("input[name='app[cache_port]']").val();
        var user_name =  $("input[name='app[cache_username]']").val();
        var password = $("input[name='app[cache_password]']").val();
        layer.msg('数据提交中...',{time:500000});
        $.ajax({
            url: "<?php echo url('system/test_cache'); ?>",
            type: "post",
            dataType: "json",
            data: {type:type,host:host,port:port,username:user_name,password:password},
            beforeSend: function () {
            },
            error:function(r){
                layer.msg('发生错误，请检查是否开启扩展库和配置项!',{time:1800});
            },
            success: function (r) {
                layer.msg(r.msg,{time:1800});
            },
            complete: function () {
            }
        });
    }


</script>

</body>
</html>