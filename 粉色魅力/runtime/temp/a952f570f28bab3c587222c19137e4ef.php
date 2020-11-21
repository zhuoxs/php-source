<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"/www/wwwroot/ys01.testx.vip/application/admin/view/system/configcollect.html";i:1552354866;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
    <form class="layui-form layui-form-pane" action="">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">视频采集设置</li>
                <li>文章采集设置</li>
                <li>明星采集设置</li>
                <li>角色采集设置</li>
                <li>采集词库设置</li>
            </ul>

            <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">

                <div class="layui-form-item">
                    <label class="layui-form-label">数据状态：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[vod][status]" value="0" title="未审" <?php if($config['collect']['vod']['status'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][status]" value="1" title="已审" <?php if($config['collect']['vod']['status'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">随机点击量：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[vod][hits_start]" placeholder="最小值" value="<?php echo $config['collect']['vod']['hits_start']; ?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[vod][hits_end]" placeholder="最大值" value="<?php echo $config['collect']['vod']['hits_end']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">随机顶踩：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[vod][updown_start]" placeholder="最小值" value="<?php echo $config['collect']['vod']['updown_start']; ?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[vod][updown_end]" placeholder="最大值" value="<?php echo $config['collect']['vod']['updown_end']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">随机评分数：</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="collect[vod][score]" value="0" title="关闭" <?php if($config['collect']['vod']['score'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][score]" value="1" title="开启" <?php if($config['collect']['vod']['score'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">自动同步图片：</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="collect[vod][pic]" value="0" title="关闭" <?php if($config['collect']['vod']['pic'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][pic]" value="1" title="开启" <?php if($config['collect']['vod']['pic'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">自动生成TAG：</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="collect[vod][tag]" value="0" title="关闭" <?php if($config['collect']['vod']['tag'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][tag]" value="1" title="开启" <?php if($config['collect']['vod']['tag'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">扩展分类优化：</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="collect[vod][class_filter]" value="0" title="关闭" <?php if($config['collect']['vod']['class_filter'] == '0'): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][class_filter]" value="1" title="开启" <?php if($config['collect']['vod']['class_filter'] != '0'): ?>checked <?php endif; ?>>
                    </div>
                    <div class="layui-form-mid layui-word-aux">将自动过滤扩分类名称里的[片,剧],例如动作片会变为动作;欧美剧会变成欧美;</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">介绍随机插入语句：</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="collect[vod][psernd]" value="0" title="关闭" <?php if($config['collect']['vod']['psernd'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][psernd]" value="1" title="开启" <?php if($config['collect']['vod']['psernd'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">介绍同义词替换：</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="collect[vod][psesyn]" value="0" title="关闭" <?php if($config['collect']['vod']['psesyn'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[vod][psesyn]" value="1" title="开启" <?php if($config['collect']['vod']['psesyn'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">
                        入库重复规则：</label>
                    <div class="layui-input-block">
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="a" title="标题" checked disabled>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="b" title="分类" <?php if(strpos($config['collect']['vod']['inrule'],'b') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="c" title="年代" <?php if(strpos($config['collect']['vod']['inrule'],'c') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="d" title="地区" <?php if(strpos($config['collect']['vod']['inrule'],'d') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="e" title="语言" <?php if(strpos($config['collect']['vod']['inrule'],'e') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="f" title="主演" <?php if(strpos($config['collect']['vod']['inrule'],'f') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][inrule][]" value="g" title="导演" <?php if(strpos($config['collect']['vod']['inrule'],'g') !==false): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">
                        二次更新规则：</label>
                    <div class="layui-input-block">
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="a" title="播放地址" <?php if(strpos($config['collect']['vod']['uprule'],'a') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="b" title="下载地址" <?php if(strpos($config['collect']['vod']['uprule'],'b') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="c" title="连载数" <?php if(strpos($config['collect']['vod']['uprule'],'c') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="d" title="备注" <?php if(strpos($config['collect']['vod']['uprule'],'d') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="e" title="导演" <?php if(strpos($config['collect']['vod']['uprule'],'e') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="f" title="主演" <?php if(strpos($config['collect']['vod']['uprule'],'f') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="g" title="年代" <?php if(strpos($config['collect']['vod']['uprule'],'g') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="h" title="地区" <?php if(strpos($config['collect']['vod']['uprule'],'h') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="i" title="语言" <?php if(strpos($config['collect']['vod']['uprule'],'i') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="j" title="图片" <?php if(strpos($config['collect']['vod']['uprule'],'j') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="k" title="详情" <?php if(strpos($config['collect']['vod']['uprule'],'k') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="l" title="TAG" <?php if(strpos($config['collect']['vod']['uprule'],'l') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="m" title="副标题" <?php if(strpos($config['collect']['vod']['uprule'],'m') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="n" title="扩展分类" <?php if(strpos($config['collect']['vod']['uprule'],'n') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="o" title="编剧" <?php if(strpos($config['collect']['vod']['uprule'],'o') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="p" title="影片版本" <?php if(strpos($config['collect']['vod']['uprule'],'p') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="q" title="资源类别" <?php if(strpos($config['collect']['vod']['uprule'],'q') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="r" title="简介" <?php if(strpos($config['collect']['vod']['uprule'],'r') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="s" title="电视频道" <?php if(strpos($config['collect']['vod']['uprule'],'s') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="t" title="节目周期" <?php if(strpos($config['collect']['vod']['uprule'],'t') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="u" title="总集数" <?php if(strpos($config['collect']['vod']['uprule'],'u') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[vod][uprule][]" value="v" title="完结状态" <?php if(strpos($config['collect']['vod']['uprule'],'v') !==false): ?>checked <?php endif; ?>>


                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">数据过滤：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[vod][filter]" class="layui-textarea" placeholder="多个数据请用逗号分隔"><?php echo $config['collect']['vod']['filter']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="layui-tab-item">

                <div class="layui-form-item">
                    <label class="layui-form-label">数据状态：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[art][status]" value="0" title="未审" <?php if($config['collect']['art']['status'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[art][status]" value="1" title="已审" <?php if($config['collect']['art']['status'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">随机点击量：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[art][hits_start]" placeholder="最小值" value="<?php echo $config['collect']['art']['hits_start']; ?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[art][hits_end]" placeholder="最大值" value="<?php echo $config['collect']['art']['hits_end']; ?>" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">随机顶踩：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[art][updown_start]" placeholder="最小值" value="<?php echo $config['collect']['art']['updown_start']; ?>" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="collect[art][updown_end]" placeholder="最大值" value="<?php echo $config['collect']['art']['updown_end']; ?>" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">随机评分数：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[art][score]" value="0" title="关闭" <?php if($config['collect']['art']['score'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[art][score]" value="1" title="开启" <?php if($config['collect']['art']['score'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">自动同步图片：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[art][pic]" value="0" title="关闭" <?php if($config['collect']['art']['pic'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[art][pic]" value="1" title="开启" <?php if($config['collect']['art']['pic'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">自动生成TAG：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[art][tag]" value="0" title="关闭" <?php if($config['collect']['art']['tag'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[art][tag]" value="1" title="开启" <?php if($config['collect']['art']['tag'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">介绍随机插入语句：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[art][psernd]" value="0" title="关闭" <?php if($config['collect']['art']['psernd'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[art][psernd]" value="1" title="开启" <?php if($config['collect']['art']['psernd'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">介绍同义词替换：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="collect[art][psesyn]" value="0" title="关闭" <?php if($config['collect']['art']['psesyn'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="collect[art][psesyn]" value="1" title="开启" <?php if($config['collect']['art']['psesyn'] == 1): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">入库重复规则：</label>
                    <div class="layui-input-block">
                        <input type="checkbox" lay-skin="primary" name="collect[art][inrule][]" value="a" title="标题" checked disabled>
                        <input type="checkbox" lay-skin="primary" name="collect[art][inrule][]" value="b" title="分类" <?php if(strpos($config['collect']['art']['inrule'],'b') !==false): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">二次更新规则：</label>
                    <div class="layui-input-block">
                        <input type="checkbox" lay-skin="primary" name="collect[art][uprule][]" value="a" title="详情" <?php if(strpos($config['collect']['art']['uprule'],'a') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[art][uprule][]" value="b" title="作者" <?php if(strpos($config['collect']['art']['uprule'],'b') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[art][uprule][]" value="c" title="来源" <?php if(strpos($config['collect']['art']['uprule'],'c') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[art][uprule][]" value="d" title="图片" <?php if(strpos($config['collect']['art']['uprule'],'d') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[art][uprule][]" value="e" title="TAG" <?php if(strpos($config['collect']['art']['uprule'],'e') !==false): ?>checked <?php endif; ?>>
                        <input type="checkbox" lay-skin="primary" name="collect[art][uprule][]" value="f" title="简介" <?php if(strpos($config['collect']['art']['uprule'],'f') !==false): ?>checked <?php endif; ?>>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">数据过滤：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[art][filter]" class="layui-textarea" placeholder="多个数据请用逗号分隔"><?php echo $config['collect']['art']['filter']; ?></textarea>
                    </div>
                </div>

            </div>


                <div class="layui-tab-item">

                    <div class="layui-form-item">
                        <label class="layui-form-label">数据状态：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[actor][status]" value="0" title="未审" <?php if($config['collect']['actor']['status'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[actor][status]" value="1" title="已审" <?php if($config['collect']['actor']['status'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">随机点击量：</label>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[actor][hits_start]" placeholder="最小值" value="<?php echo $config['collect']['actor']['hits_start']; ?>" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[actor][hits_end]" placeholder="最大值" value="<?php echo $config['collect']['actor']['hits_end']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">随机顶踩：</label>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[actor][updown_start]" placeholder="最小值" value="<?php echo $config['collect']['actor']['updown_start']; ?>" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[actor][updown_end]" placeholder="最大值" value="<?php echo $config['collect']['actor']['updown_end']; ?>" class="layui-input">
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">随机评分数：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[actor][score]" value="0" title="关闭" <?php if($config['collect']['actor']['score'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[actor][score]" value="1" title="开启" <?php if($config['collect']['actor']['score'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">自动同步图片：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[actor][pic]" value="0" title="关闭" <?php if($config['collect']['actor']['pic'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[actor][pic]" value="1" title="开启" <?php if($config['collect']['actor']['pic'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">介绍随机插入语句：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[actor][psernd]" value="0" title="关闭" <?php if($config['collect']['actor']['psernd'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[actor][psernd]" value="1" title="开启" <?php if($config['collect']['actor']['psernd'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">介绍同义词替换：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[actor][psesyn]" value="0" title="关闭" <?php if($config['collect']['actor']['psesyn'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[actor][psesyn]" value="1" title="开启" <?php if($config['collect']['actor']['psesyn'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">入库重复规则：</label>
                        <div class="layui-input-block">
                            <input type="checkbox" lay-skin="primary" name="collect[actor][inrule][]" value="a" title="演员名" checked disabled>
                            <input type="checkbox" lay-skin="primary" name="collect[actor][inrule][]" value="b" title="性别" <?php if(strpos($config['collect']['actor']['inrule'],'b') !==false): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">二次更新规则：</label>
                        <div class="layui-input-block">
                            <input type="checkbox" lay-skin="primary" name="collect[actor][uprule][]" value="a" title="详情" <?php if(strpos($config['collect']['actor']['uprule'],'a') !==false): ?>checked <?php endif; ?>>
                            <input type="checkbox" lay-skin="primary" name="collect[actor][uprule][]" value="b" title="简介" <?php if(strpos($config['collect']['actor']['uprule'],'b') !==false): ?>checked <?php endif; ?>>
                            <input type="checkbox" lay-skin="primary" name="collect[actor][uprule][]" value="c" title="备注" <?php if(strpos($config['collect']['actor']['uprule'],'c') !==false): ?>checked <?php endif; ?>>
                            <input type="checkbox" lay-skin="primary" name="collect[actor][uprule][]" value="d" title="代表作" <?php if(strpos($config['collect']['actor']['uprule'],'d') !==false): ?>checked <?php endif; ?>>
                            <input type="checkbox" lay-skin="primary" name="collect[actor][uprule][]" value="e" title="图片" <?php if(strpos($config['collect']['actor']['uprule'],'e') !==false): ?>checked <?php endif; ?>>

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">数据过滤：</label>
                        <div class="layui-input-block">
                            <textarea name="collect[actor][filter]" class="layui-textarea" placeholder="多个数据请用逗号分隔"><?php echo $config['collect']['actor']['filter']; ?></textarea>
                        </div>
                    </div>

                </div>



                <div class="layui-tab-item">

                    <div class="layui-form-item">
                        <label class="layui-form-label">数据状态：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[role][status]" value="0" title="未审" <?php if($config['collect']['role']['status'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[role][status]" value="1" title="已审" <?php if($config['collect']['role']['status'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">随机点击量：</label>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[role][hits_start]" placeholder="最小值" value="<?php echo $config['collect']['role']['hits_start']; ?>" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[role][hits_end]" placeholder="最大值" value="<?php echo $config['collect']['role']['hits_end']; ?>" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">随机顶踩：</label>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[role][updown_start]" placeholder="最小值" value="<?php echo $config['collect']['role']['updown_start']; ?>" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="collect[role][updown_end]" placeholder="最大值" value="<?php echo $config['collect']['role']['updown_end']; ?>" class="layui-input">
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">随机评分数：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[role][score]" value="0" title="关闭" <?php if($config['collect']['role']['score'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[role][score]" value="1" title="开启" <?php if($config['collect']['role']['score'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">自动同步图片：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[role][pic]" value="0" title="关闭" <?php if($config['collect']['role']['pic'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[role][pic]" value="1" title="开启" <?php if($config['collect']['role']['pic'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">介绍随机插入语句：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[role][psernd]" value="0" title="关闭" <?php if($config['collect']['actor']['psernd'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[role][psernd]" value="1" title="开启" <?php if($config['collect']['actor']['psernd'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">介绍同义词替换：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="collect[role][psesyn]" value="0" title="关闭" <?php if($config['collect']['role']['psesyn'] != 1): ?>checked <?php endif; ?>>
                            <input type="radio" name="collect[role][psesyn]" value="1" title="开启" <?php if($config['collect']['role']['psesyn'] == 1): ?>checked <?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">入库重复规则：</label>
                        <div class="layui-input-block">
                            <input type="checkbox" lay-skin="primary" name="collect[role][inrule][]" value="a" title="角色名" checked disabled>
                            <input type="checkbox" lay-skin="primary" name="collect[role][inrule][]" value="b" title="视频名" checked disabled>
                            <input type="checkbox" lay-skin="primary" name="collect[role][inrule][]" value="c" title="演员名" <?php if(strpos($config['collect']['role']['inrule'],'c') !==false): ?>checked <?php endif; ?> >
                            <input type="checkbox" lay-skin="primary" name="collect[role][inrule][]" value="d" title="导演名" <?php if(strpos($config['collect']['role']['inrule'],'d') !==false): ?>checked <?php endif; ?> >
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">二次更新规则：</label>
                        <div class="layui-input-block">
                            <input type="checkbox" lay-skin="primary" name="collect[role][uprule][]" value="a" title="详情" <?php if(strpos($config['collect']['role']['uprule'],'a') !==false): ?>checked <?php endif; ?>>
                            <input type="checkbox" lay-skin="primary" name="collect[role][uprule][]" value="b" title="备注" <?php if(strpos($config['collect']['role']['uprule'],'b') !==false): ?>checked <?php endif; ?>>
                            <input type="checkbox" lay-skin="primary" name="collect[role][uprule][]" value="c" title="图片" <?php if(strpos($config['collect']['role']['uprule'],'c') !==false): ?>checked <?php endif; ?>>

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">数据过滤：</label>
                        <div class="layui-input-block">
                            <textarea name="collect[role][filter]" class="layui-textarea" placeholder="多个数据请用逗号分隔"><?php echo $config['collect']['role']['filter']; ?></textarea>
                        </div>
                    </div>

                </div>


            <div class="layui-tab-item">
                <blockquote class="layui-elem-quote layui-quote-nm">
                    同义词：每行一个，不要有空行，格式：要替换=替换后，不允许出现#号。<br>
                    随机词库：字符段一般20条左右即可，可以是笑话小故事，也可以加入超链接。<br>
                    此项功能影响采集性能，请不要一次加入太多词条 。适当的伪原创有助于搜索引擎收录。该功能只在新增数据时有效。<br>
                    不使用替换功能请在【采集参数设置中禁用】。
                </blockquote>


                <div class="layui-form-item">
                    <label class="layui-form-label">视频同义词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[vod][thesaurus]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['vod']['thesaurus']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">视频随机词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[vod][words]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['vod']['words']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">文章同义词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[art][thesaurus]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['art']['thesaurus']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">文章随机词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[art][words]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['art']['words']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">明星同义词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[actor][thesaurus]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['actor']['thesaurus']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">明星随机词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[actor][words]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['actor']['words']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">角色同义词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[role][thesaurus]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['role']['thesaurus']); ?></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">角色随机词库：</label>
                    <div class="layui-input-block">
                        <textarea name="collect[role][words]" class="layui-textarea"><?php echo mac_replace_text($config['collect']['role']['words']); ?></textarea>
                    </div>
                </div>

            </div>
            </div>
        </div>
        <div class="layui-form-item center">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">保 存</button>
                <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript">

</script>

</body>
</html>