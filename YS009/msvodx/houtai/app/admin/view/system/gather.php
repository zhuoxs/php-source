<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
         <blockquote class="layui-elem-quote layui-text">
            <div class="layui-colla-item">
                <h3>特别注意:</h3>
                <div class="layui-colla-content layui-show">
                    <p>1. 本功能可结合第三方采集软件自动入库，如“火车头采集”。</p>
                    <p>2. 请确保在请求采集接口时必须传递接口密钥，否则将会拒绝请求。</p>
                    <p>3. 采集接口文档及采集样例：<a class="layui-btn layui-btn-primary layui-btn-xs" style="height: 25px;line-height: 25px;padding: 0px 10px;" href="/static/gather_doc/MsvodX采集接口文档及样例.zip">点击下载</a> ; <span style="color: red">采集样例仅供学习交流使用，请下载后24小时内删除</span>。</p>
                </div>
            </div>
        </blockquote>


 <fieldset class="layui-elem-field layui-field-title">
            <legend>采集设置</legend>
        </fieldset>
      <div class="layui-form-item">
            <label class="layui-form-label">是否开启采集</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="resource_gather_status"   lay-skin="switch" lay-text="开启|关闭"  {if condition="$config['resource_gather_status'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">开启采集后采集工具才能提交数据过来，请在不采集时关闭，以免被恶意请求。</div>
        </div>
 <div class="layui-form-item">
            <label class="layui-form-label">接口秘钥</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_key" value="{$config['resource_gather_key']}" autocomplete="off" placeholder="和火车头采集同步">
            </div>
            <div class="layui-form-mid layui-word-aux">和火车头采集同步</a></div>
        </div>
		
            <legend><fieldset class="layui-elem-field layui-field-title">
            <legend>视频采集入库相关设置</legend>
        </fieldset>
            <!--<div class="layui-form-item">
            <label class="layui-form-label">视频入库分类</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_video_classid" value="{$config['resource_gather_video_classid']}" autocomplete="off" placeholder="分类相应的ID">
            </div>
            <div class="layui-form-mid layui-word-aux">找到视频分类的分类ID</a></div>
        </div>-->
		 <div class="layui-form-item">
<label class="layui-form-label">视频采集是否审核</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="resource_gather_video_need_review"   lay-skin="switch" lay-text="要核|不审"  {if condition="$config['resource_gather_video_need_review'] eq 1"}checked=""{/if}>
            </div>

            <div class="layui-form-mid layui-word-aux">不审直接进入视频列表显示，要审在视频审核区</div>
        </div>
		 <div class="layui-form-item">
            <label class="layui-form-label">视频采集所需金币</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_video_view_gold" value="{$config['resource_gather_video_view_gold']}" autocomplete="off" placeholder="金币个数">
            </div>
            <div class="layui-form-mid layui-word-aux">视频采集过来的时候所需观看金币</a></div>
        </div>
		<legend><fieldset class="layui-elem-field layui-field-title">
            <legend>小说采集入库相关设置</legend>
        </fieldset>
				<!-- <div class="layui-form-item">
            <label class="layui-form-label">小说入库分类</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_novel_classid" value="{$config['resource_gather_novel_classid']}" autocomplete="off" placeholder="分类相应的ID">
            </div>
            <div class="layui-form-mid layui-word-aux">找到小说分类的分类ID</a></div>
        </div>-->
		
				  <div class="layui-form-item">

		<label class="layui-form-label">小说采集是否审核</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="resource_gather_novel_need_review"   lay-skin="switch" lay-text="要审|不审"  {if condition="$config['resource_gather_novel_need_review'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">不审直接进入视频列表显示，要审在视频审核区</div>
        </div>
		<div class="layui-form-item">
            <label class="layui-form-label">小说采集所需金币</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_novel_view_gold" value="{$config['resource_gather_novel_view_gold']}" autocomplete="off" placeholder="金币个数">
            </div>
            <div class="layui-form-mid layui-word-aux">小说采集过来的时候所需观看金币</a></div>
        </div>
		<legend><fieldset class="layui-elem-field layui-field-title">
            <legend>图片采集入库相关设置</legend>
        </fieldset>
					<!-- <div class="layui-form-item">
            <label class="layui-form-label">图片入库分类</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_atlas_classid" value="{$config['resource_gather_atlas_classid']}" autocomplete="off" placeholder="分类相应的ID">
            </div>
            <div class="layui-form-mid layui-word-aux">找到图片分类的分类ID</a></div>
        </div>-->
 
			
		             <div class="layui-form-item">

		<label class="layui-form-label">图片采集是否审核</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="resource_gather_atlas_need_review"   lay-skin="switch" lay-text="要审|不审"  {if condition="$config['resource_gather_atlas_need_review'] eq 1"}checked=""{/if}>
            </div>
			   <div class="layui-form-mid layui-word-aux">不审直接进入图片列表显示，要审在图片审核区</div>
        </div>
		
		
		<div class="layui-form-item">
            <label class="layui-form-label">图片采集所需金币</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="resource_gather_atlas_view_gold" value="{$config['resource_gather_atlas_view_gold']}" autocomplete="off" placeholder="金币个数">
            </div>
            <div class="layui-form-mid layui-word-aux">图片采集过来的时候所需观看金币</a></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            </div>
        </div>
    </form>
</div>
<style type="text/css">
    .layui-form-item .layui-form-label{width:150px;}
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:320px;}
    .layui-field-title:not(:first-child){margin: 30px 0}
</style>

