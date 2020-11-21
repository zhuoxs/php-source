<?php
$request = \think\Request::instance()->request();
?>
<style>
    .content {
        width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf">活动列表</div>
                    </div>
                    <div class="widget-body am-fr">
                        <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                            <div class="am-form-group">
                                <div class="am-btn-toolbar">
                                </div>
                            </div>
                        </div>

                        <div class="am-u-sm-12 am-scrollable-horizontal">
                            <table width="100%"
                                   class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap am-scrollable-horizontal">
                                <thead>
                                <tr>
                                    <th>活动ID</th>
                                    <th>活动名称</th>
                                    <th>活动封面</th>
                                    <th>活动介绍</th>
                                    <th>活动时间</th>
                                    <th>活动地址</th>
                                    <th>报名人数</th>
                                    <th>创建人</th>
                                    <th>创建时间</th>
                                    <th>更新时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $list = $list ?: []; ?>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $item->active_id ?></td>
                                        <td class="am-text-middle"><?= $item->active_name ?: '---' ?></td>
                                        <td class="am-text-middle">
                                            <?php $cover_image = $item->cover_image ?: $cover_default; ?>
                                            <img src="<?= $cover_image ?>" alt="活动封面" width="150">
                                        </td>
                                        <td class="am-text-middle">
                                            <div class="content" data-content="<?= $item->description ?>">
                                                <a href="javascript:void(0);"
                                                   title="查看活动内容"
                                                   target="_blank"><?= $item->description ?></a>
                                            </div>
                                        </td>
                                        <td class="am-text-middle"><?= $item->active_time['active_date'] ?></td>
                                        <td class="am-text-middle"><?= $item->address ?></td>
                                        <td class="am-text-middle"><?= $item->people ?></td>
                                        <td class="am-text-middle">
                                            <?= $item->user->nick_name ?> (ID:<?= $item->user->user_id ?>)
                                        </td>
                                        <td class="am-text-middle"><?= $item->create_time ?></td>
                                        <td class="am-text-middle"><?= $item->update_time ?></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <a href="javascript:void(0);"
                                                   data-id="<?= $item->active_id ?>"
                                                   class="tpl-table-black-operation-del j-del">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($list->isEmpty()): ?>
                                    <tr>
                                        <td colspan="11" align="center">暂无活动</td>
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
    $(function () {
        // 点击删除
        $('.j-del').click(function () {
            var active_id = $(this).attr('data-id');

            // 确认删除
            layer.confirm('确定要删除该活动吗？', function () {
                $.ajax({
                    type: "post",
                    url: "<?=url('active/delete')?>",
                    data: {active_id: active_id},
                    dataType: "json",
                    success: function (data) {
                        laymsg(data, true);
                    }
                });
            });
        });

        // 展示活动内容
        $('.content').click(function () {
            var content = $(this).attr('data-content');
            layer.alert("<div style=\"white-space:pre-wrap;\">" + content + "</div>", {title: '反馈内容'});
        });
    });
</script>