<?php
$request = \think\Request::instance()->request();
?>
<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf">封面列表</div>
                    </div>
                    <div class="widget-body am-fr">
                        <div class="row">
                            <form action="">
                                <input type="hidden" name="s" value="<?= $request['s'] ?>">
                                <?php if (isset($request['page'])) : ?>
                                    <input type="hidden" name="page" value="<?= $request['page'] ?>">
                                <?php endif; ?>
                                <div class="am-u-sm-12 am-margin-bottom am-margin-top">
                                    <div class="am-u-sm-12 am-u-lg-7">
                                        <div class="am-u-lg-12 am-form-group cl-p tpl-form-border-form">
                                            <div class="am-btn-group am-btn-group-sm">
                                                <a href="<?= url('cover/add') ?>"
                                                   class="am-btn am-btn-default am-btn-success">
                                                    <span class="am-icon-plus"></span> 添加
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-u-lg-5">
                                        <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                                            <div class="am-u-lg-12 am-form-group cl-p am-text-center search">
                                                <select name="class_id"
                                                        data-am-selected="{btnSize: 'sm',searchBox: 1,maxHeight:400}">
                                                    <option value="-1">请选择封面分类</option>
                                                    <?php $class_list = $class_list ?: []; ?>
                                                    <?php foreach ($class_list as $item): ?>
                                                        <option value="<?= $item['class_id'] ?>"
                                                            <?= isset($request['class_id']) &&
                                                            $item['class_id'] == $request['class_id'] ? 'selected' : '1' ?>>
                                                            <?= $item['class_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="am-u-sm-12 am-u-md-12 am-u-lg-3 am-u-end">
                                            <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                            <span class="am-input-group-btn">
                                                <button class="am-btn am-btn-default am-btn-success tpl-table-list-field"
                                                        type="submit"> 查询</button>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="am-u-sm-12 am-scrollable-horizontal">
                            <table width="100%"
                                   class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap am-scrollable-horizontal">
                                <thead>
                                <tr>
                                    <th>封面ID</th>
                                    <th>封面分类</th>
                                    <th>封面图片</th>
                                    <th>排序</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $list = $list ?: []; ?>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $item->cover_id ?></td>
                                        <td class="am-text-middle">
                                            <?= !empty($item->cover_class) ? $item->cover_class->class_name : '--' ?>
                                        </td>
                                        <td class="am-text-middle">
                                            <a href="<?= $item->image ?>" target="_blank" title="点击查看大图">
                                                <img src="<?= $item->image ?>" width="150">
                                            </a>
                                        </td>
                                        <td class="am-text-middle"><?= $item->sort ?></td>
                                        <td class="am-text-middle"><?= $item->create_time ?></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <a href="<?= url('cover/edit', ['cover_id' => $item->cover_id]); ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                                <a href="javascript:void(0);"
                                                   data-id="<?= $item['cover_id'] ?>"
                                                   class="tpl-table-black-operation-del j-delete">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($list->isEmpty()): ?>
                                    <tr>
                                        <td colspan="6" align="center">暂无封面</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="am-u-lg-12 am-cf">
                            <div class="am-fr"><?= $list->render() ?> </div>
                            <div class="am-fr pagination-total am-margin-right">
                                <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $ = $ || null;
    $(function () {
        // 点击删除
        $('.j-delete').click(function () {
            let cover_id = $(this).attr('data-id');
            layer.confirm('确定要删除该封面吗？', function () {
                $.ajax({
                    type: "post",
                    url: "<?= url('cover/delete') ?>",
                    data: {cover_id: cover_id},
                    dataType: "json",
                    success: function (data) {
                        laymsg(data, true);
                    }
                });
            });
        });
    });
</script>
