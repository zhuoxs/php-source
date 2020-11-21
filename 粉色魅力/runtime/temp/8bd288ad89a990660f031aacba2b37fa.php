<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"/www/wwwroot/ys01.testx.vip/application/admin/view/art/index.html";i:1545048142;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
<div class="page-container p10">

    <div class="my-toolbar-box">

        <div class="center mb10">
            <form class="layui-form " method="post">
                <input type="hidden" value="<?php echo $param['select']; ?>" name="select">
                <input type="hidden" value="<?php echo $param['input']; ?>" name="input">
                <div class="layui-input-inline w150">
                    <select name="type">
                        <option value="">选择分类</option>
                        <?php if(is_array($type_tree) || $type_tree instanceof \think\Collection || $type_tree instanceof \think\Paginator): $i = 0; $__LIST__ = $type_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['type_mid'] == 2): ?>
                        <option value="<?php echo $vo['type_id']; ?>" <?php if($param['type'] == $vo['type_id']): ?>selected <?php endif; ?>><?php echo $vo['type_name']; ?></option>
                        <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ch): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $ch['type_id']; ?>" <?php if($param['type'] == $ch['type_id']): ?>selected <?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;├&nbsp;<?php echo $ch['type_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="status">
                        <option value="">选择状态</option>
                        <option value="0" <?php if($param['status'] == '0'): ?>selected <?php endif; ?>>未审核</option>
                        <option value="1" <?php if($param['status'] == '1'): ?>selected <?php endif; ?>>已审核</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="level">
                        <option value="">选择推荐</option>
                        <option value="9" <?php if($param['level'] == '9'): ?>selected <?php endif; ?>>推荐9-幻灯</option>
                        <option value="1" <?php if($param['level'] == '1'): ?>selected <?php endif; ?>>推荐1</option>
                        <option value="2" <?php if($param['level'] == '2'): ?>selected <?php endif; ?>>推荐2</option>
                        <option value="3" <?php if($param['level'] == '3'): ?>selected <?php endif; ?>>推荐3</option>
                        <option value="4" <?php if($param['level'] == '4'): ?>selected <?php endif; ?>>推荐4</option>
                        <option value="5" <?php if($param['level'] == '5'): ?>selected <?php endif; ?>>推荐5</option>
                        <option value="6" <?php if($param['level'] == '6'): ?>selected <?php endif; ?>>推荐6</option>
                        <option value="7" <?php if($param['level'] == '7'): ?>selected <?php endif; ?>>推荐7</option>
                        <option value="8" <?php if($param['level'] == '8'): ?>selected <?php endif; ?>>推荐8</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="lock">
                        <option value="">选择锁定</option>
                        <option value="0" <?php if($param['lock'] == '0'): ?>selected <?php endif; ?>>未锁定</option>
                        <option value="1" <?php if($param['lock'] == '1'): ?>selected <?php endif; ?>>已锁定</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="pic">
                        <option value="">选择图片</option>
                        <option value="1" <?php if($param['pic'] == '1'): ?>selected<?php endif; ?>>无图片</option>
                        <option value="2" <?php if($param['pic'] == '2'): ?>selected<?php endif; ?>>远程图片</option>
                        <option value="3" <?php if($param['pic'] == '3'): ?>selected<?php endif; ?>>同步出错图</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="order">
                        <option value="">选择排序</option>
                        <option value="art_time" <?php if($param['order'] == 'art_time'): ?>selected<?php endif; ?>>更新时间</option>
                        <option value="art_id" <?php if($param['order'] == 'art_id'): ?>selected<?php endif; ?>>编号</option>
                        <option value="art_hits" <?php if($param['order'] == 'art_hits'): ?>selected<?php endif; ?>>总人气</option>
                        <option value="art_hits_month" <?php if($param['order'] == 'art_hits_month'): ?>selected<?php endif; ?>>月人气</option>
                        <option value="art_hits_week" <?php if($param['order'] == 'art_hits_week'): ?>selected<?php endif; ?>>周人气</option>
                        <option value="art_hits_day" <?php if($param['order'] == 'art_hits_day'): ?>selected<?php endif; ?>>日人气</option>
                    </select>
                </div>

                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" placeholder="请输入搜索条件" class="layui-input" name="wd" value="<?php echo $param['wd']; ?>">
                </div>
                <button class="layui-btn mgl-20 j-search" >查询</button>
            </form>
        </div>

        <div class="layui-btn-group">
            <a data-href="<?php echo url('info'); ?>" data-full="1" class="layui-btn layui-btn-primary j-iframe"><i class="layui-icon">&#xe654;</i>添加</a>
            <a data-href="<?php echo url('del'); ?>" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe640;</i>删除</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=art&col=type_id&tpl=select_type&url=art/field" data-width="270" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>分类</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=art&col=art_level&tpl=select_level&url=art/field" data-width="270" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>推荐</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=art&col=art_hits&tpl=select_hits&url=art/field" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>点击</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=art&col=art_status&tpl=select_status&url=art/field" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>状态</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=art&col=art_lock&tpl=select_status&url=art/field" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>锁定</a>
            <a class="layui-btn layui-btn-primary j-iframe" data-href="<?php echo url('images/opt?tab=art'); ?>" href="javascript:;" title="同步远程图片"><i class="layui-icon">&#xe620;</i>同步图片</a>
            <a class="layui-btn layui-btn-primary j-iframe" data-checkbox="true" data-href="<?php echo url('make/make?ac=info&tab=art'); ?>" href="javascript:;" title="生成页面"><i class="layui-icon">&#xe620;</i>生成页面</a>
            <?php if($param['select'] == 1): ?>
            <a data-href="" onclick="parent.onSelectResult('<?php echo $param['input']; ?>',$('.checkbox-ids:checked'))" class="layui-btn layui-btn-normal">选择返回</a>
            <?php endif; if($param['repeat'] != ''): ?>
            <a data-href="<?php echo url('del'); ?>?repeat=1&retain=min" data-checkbox="no" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe640;</i>一键删重[保留小ID]</a>
            <a data-href="<?php echo url('del'); ?>?repeat=1&retain=max" data-checkbox="no" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe640;</i>一键删重[保留大ID]</a>
            <?php endif; ?>
        </div>

    </div>


    <form class="layui-form " method="post" id="pageListForm">
        <table class="layui-table" lay-size="sm">
            <thead>
            <tr>
                <th width="25"><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th width="50">编号</th>
                <th >名称</th>
                <th width="50">人气</th>
                <th width="30">评分</th>
                <th width="30">推荐</th>
                <th width="30">浏览</th>
                <th width="80">编辑人</th>
                <th width="120">更新时间</th>
                <th width="80">操作</th>
            </tr>
            </thead>

            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $vo['art_id']; ?>" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td><?php echo $vo['art_id']; ?></td>
                <td>[<?php echo $vo['type']['type_name']; ?>] <a target="_blank" class="layui-badge-rim " href="<?php echo mac_url_art_detail($vo); ?>"><?php echo $vo['art_name']; ?></a> <?php if($vo['art_status'] == 0): ?> <span class="layui-badge">未审</span><?php endif; if($vo['art_lock'] == 1): ?> <span class="layui-badge">锁定</span><?php endif; ?></td>
                <td><?php echo $vo['art_hits']; ?></td>
                <td><?php echo $vo['art_score']; ?></td>
                <td><a data-href="<?php echo url('index/select'); ?>?tab=art&col=art_level&tpl=select_level&url=art/field&ids=<?php echo $vo['art_id']; ?>" data-width="270" data-height="100" class=" j-select"><span class="layui-badge layui-bg-orange"><?php echo $vo['art_level']; ?></span></a></td>
                <td><?php if($vo['ismake'] == 1): ?><a target="_blank" class="layui-badge layui-bg-green " href="<?php echo mac_url_art_detail($vo); ?>">Y</a><?php else: ?><a class="layui-badge" href="<?php echo url('make/make?ac=info&tab=art'); ?>?ids=<?php echo $vo['art_id']; ?>&ref=1">N</a><?php endif; ?></td>
                <td><?php echo $vo['art_author']; ?></td>
                <td><?php echo mac_day($vo['art_time'],color); ?></td>
                <td>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('info?id='.$vo['art_id']); ?>" href="javascript:;" title="编辑">编辑</a>
                    <a class="layui-badge-rim j-tr-del" data-href="<?php echo url('del?ids='.$vo['art_id']); ?>" href="javascript:;" title="删除">删除</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div id="pages" class="center"></div>
    </form>
</div>




<script type="text/javascript" src="/static/js/admin_common.js"></script>

<script type="text/javascript">
    var curUrl="<?php echo url('art/data',$param); ?>";
    layui.use(['laypage', 'layer','form'], function() {
        var laypage = layui.laypage
                , layer = layui.layer,
                form = layui.form;

        laypage.render({
            elem: 'pages'
            ,count: <?php echo $total; ?>
            ,limit: <?php echo $limit; ?>
            ,curr: <?php echo $page; ?>
            ,layout: ['count', 'prev', 'page', 'next', 'limit', 'skip']
            ,jump: function(obj,first){
                if(!first){
                    location.href = curUrl.replace('%7Bpage%7D',obj.curr).replace('%7Blimit%7D',obj.limit);
                }
            }
        });


    });
</script>
</body>
</html>