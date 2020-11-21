<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;
/**
 * 系统配置模型
 * @package app\admin\model
 */
class AdminConfig extends Model
{
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = 'mtime';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 获取系统配置信息
     * @param  string $name 配置名
     * @param  bool $update 是否更新缓存
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public static function getConfig($name = '', $update = false)
    {
        $result = cache('sys_config');
        if (!$result || $update == true) {
            $configs = self::column('value,type,group', 'name');
            $result = [];
            foreach ($configs as $config) {
                switch ($config['type']) {
                    case 'array':
                    case 'checkbox':
                        if ($config['name'] == 'config_group') {
                            $v = parse_attr($config['value']);
                            if (!empty($config['value'])) {
                                $result[$config['group']][$config['name']] = array_merge(config('hs_system.config_group'), $v);
                            } else {
                                $result[$config['group']][$config['name']] = config('hs_system.config_group');
                            }
                        } else {
                            $result[$config['group']][$config['name']] = parse_attr($config['value']);
                        }
                        break;
                    default:
                        $result[$config['group']][$config['name']] = $config['value'];
                        break;
                }
            }
            cache('sys_config', $result);
        }
        return $name != '' ? $result[$name] : $result;
    }

    /**
     * 删除配置
     * @param string|array $id 节点ID
     * @author frs whs tcl dreamer ©2016
     * @return bool
     */
    public function del($ids = '') {
        if (is_array($ids)) {
            $error = '';
            foreach ($ids as $k => $v) {
                $map = [];
                $map['id'] = $v;
                $row = self::where($map)->find();
                if ($row['system'] == 1) {
                    $error .= '['.$row['title'].']为系统配置，禁止删除！<br>';
                    continue;
                }
                self::where($map)->delete();
            }
            if ($error) {
                $this->error = $error;
                return false;
            }
            return true;
        }
        $this->error = '参数传递错误';
        return false;
    }
}
