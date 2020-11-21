<?php
$request = \think\Request::instance()->request();
?>
<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf">会员列表</div>
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
                                    <th>性别</th>
                                    <th>国家</th>
                                    <th>省份</th>
                                    <th>城市</th>
                                    <th>注册时间</th>
                                    <th>更新时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $list = $list ?: []; ?>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $item->user_id ?></td>
                                        <td class="am-text-middle"><?= $item->nick_name ?: '---' ?></td>
                                        <td class="am-text-middle">
                                            <?php if ($item->avatar): ?>
                                                <img src="<?= $item->avatar ?>"
                                                     alt="微信头像" width="80">
                                            <?php else: ?>
                                                ---
                                            <?php endif; ?>
                                        </td>
                                        <td class="am-text-middle"><?= $item->gender ?></td>
                                        <td class="am-text-middle"><?= $item->country ?: '--' ?></td>
                                        <td class="am-text-middle"><?= $item->province ?: '--' ?></td>
                                        <td class="am-text-middle"><?= $item->city ?: '--' ?></td>
                                        <td class="am-text-middle"><?= $item->create_time ?></td>
                                        <td class="am-text-middle"><?= $item->update_time ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($list->isEmpty()): ?>
                                    <tr>
                                        <td colspan="9" align="center">暂无封面</td>
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