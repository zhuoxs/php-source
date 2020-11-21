<?php
$request = \think\Request::instance()->request();
?>
<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf">封面分类</div>
                    </div>
                    <div class="widget-body am-fr">
                        <div class="row">
                            <div class="am-u-sm-12 am-margin-bottom am-margin-top">
                                <div class="am-u-sm-12 am-u-lg-7">
                                    <div class="am-u-lg-12 am-form-group cl-p tpl-form-border-form">
                                        <div class="am-btn-group am-btn-group-sm">
                                            <a href="<?= url('cover_class/add') ?>"
                                               class="am-btn am-btn-default am-btn-success">
                                                <span class="am-icon-plus"></span> 添加
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-scrollable-horizontal">
                            <table width="100%"
                                   class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap am-scrollable-horizontal">
                                <thead>
                                <tr>
                                    <th>分类ID</th>
                                    <th>分类名称</th>
                                    <th>排序</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $item->class_id ?></td>
                                        <td class="am-text-middle"><?= $item->class_name ?></td>
                                        <td class="am-text-middle"><?= $item->sort ?></td>
                                        <td class="am-text-middle"><?= $item->create_time ?></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <a href="<?= url('cover_class/edit', ['class_id' => $item->class_id]); ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                                <a href="javascript:void(0);"
                                                   data-id="<?= $item['class_id'] ?>"
                                                   class="tpl-table-black-operation-del j-delete">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($list->isEmpty()): ?>
                                    <tr>
                                        <td colspan="5" align="center">暂无分类</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
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
            let class_id = $(this).attr('data-id');
            layer.confirm('确定要删除该封面分类吗？', function () {
                $.ajax({
                    type: "post",
                    url: "<?= url('cover_class/delete') ?>",
                    data: {class_id: class_id},
                    dataType: "json",
                    success: function (data) {
                        laymsg(data, true);
                    }
                });
            });
        });
    });
</script>
