<style>
    .content {
        min-width: 210px;
        max-width: 410px;
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
                        <div class="widget-title  am-cf">反馈列表</div>
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
                                    <th>会员ID</th>
                                    <th>微信昵称</th>
                                    <th>微信头像</th>
                                    <th>反馈内容</th>
                                    <th>反馈时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $item->user->user_id ?></td>
                                        <td class="am-text-middle"><?= $item->user->nick_name ?: '---' ?></td>
                                        <td class="am-text-middle">
                                            <?php if ($item->user->avatar): ?>
                                                <img src="<?= $item->user->avatar ?>"
                                                     alt="微信头像" width="80">
                                            <?php else: ?>
                                                ---
                                            <?php endif; ?>
                                        </td>
                                        <td class="am-text-middle">
                                            <div class="content" data-content="<?= $item->content ?>">
                                                <a href="javascript:void(0);"
                                                   title="查看反馈内容"
                                                   target="_blank"><?= $item->content ?></a>
                                            </div>
                                        </td>
                                        <td class="am-text-middle"><?= $item->create_time ?></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <a href="javascript:void(0);"
                                                   data-id="<?= $item->feedback_id ?>"
                                                   class="tpl-table-black-operation-del j-del">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($list->isEmpty()): ?>
                                    <tr>
                                        <td colspan="6" align="center">暂无反馈</td>
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
            var feedback_id = $(this).attr('data-id');

            // 确认删除
            layer.confirm('确定要删除该反馈吗？', function () {
                $.ajax({
                    type: "post",
                    url: "<?=url('feedback/delete')?>",
                    data: {feedback_id: feedback_id},
                    dataType: "json",
                    success: function (data) {
                        laymsg(data, true);
                    }
                });
            });
        });

        // 展示反馈内容
        $('.content').click(function () {
            var content = $(this).attr('data-content');
            layer.alert("<div style=\"white-space:pre-wrap;\">" + content + "</div>", {title: '反馈内容'});
        });
    });
</script>
