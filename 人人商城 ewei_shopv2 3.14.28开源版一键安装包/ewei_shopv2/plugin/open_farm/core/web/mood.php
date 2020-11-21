<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Mood_EweiShopV2Page extends PluginWebPage
{
	/**     * 当前数据表名称     * @var string     */
	private $table = 'ewei_open_farm_mood';
	/**     * 当前数据表名称     * @var string     */
	private $sonTable = 'ewei_open_farm_mood_image';
	/**     * 当前类的所有字段     * @var array     */
	private $field = array('id', 'uniacid', 'background', 'logo', 'create_time');
	/**     * 当前类的所有字段     * @var array     */
	private $sonField = array('id', 'uniacid', 'picture', 'create_time');
	/**     * 需要验证是否非空的字段以及其回复     * @var array     */
	private $message = array('background' => '请选择心情背景', 'picture_list' => '请选择心情图');

	/**     * 初始化配置类     * Task_EweiShopV2Page constructor.     * @param bool $_init     */
	public function __construct($_init = true)
	{
		parent::__construct($_init);
	}

	/**     * 首页主方法     */
	public function main()
	{
		global $_W;
		require_once $this->template();
	}

	/**     * 获取信息     */
	public function getInfo()
	{
		global $_W;
		$where = array('uniacid' => $_W['uniacid']);
		$moodInfo = pdo_get($this->table, $where);
		$moodInfo['show_logo'] = tomedia($moodInfo['logo']);
		$moodInfo['show_background'] = tomedia($moodInfo['background']);
		$moodInfo['picture_list'] = $this->getSon();
		$this->model->returnJson($moodInfo);
	}

	/**     * 获取子表数据     */
	public function getSon()
	{
		global $_W;
		$where = array('uniacid' => $_W['uniacid']);
		$list = pdo_getall($this->sonTable, $where);
		$list = $this->model->forTomedia($list, 'picture', 'show_picture');
		$data = array();

		foreach ($list as $item) {
			$data[] = $item;
		}

		return $data;
	}

	/**     * 添加一条数据     */
	public function addInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$this->checkInfo($data);
		$data['uniacid'] = $_W['uniacid'];
		$data['create_time'] = date('Y-m-d H:i:s');
		$mood = $this->addMood($data);
		$moodPicture = $this->addMoodPicture($data);
		$this->model->returnJson($mood || $moodPicture);
	}

	/**     * 添加心情     * @param $data     * @return bool     */
	public function addMood($data)
	{
		$imagesPrefix = $_SERVER['DOCUMENT_ROOT'] . '/attachment/';
		$backgroundPath = $imagesPrefix . $data['background'];

		if (file_exists($backgroundPath)) {
			list($pictureWidth, $pictureHeight) = getimagesize($backgroundPath);
			if ($pictureWidth != 580 && $pictureHeight != 1032) {
				$this->model->returnJson(false, false, '背景图片大小不满足 580*1032 的要求');
			}
			else if ($pictureWidth != 580) {
				$this->model->returnJson(false, false, '背景图片的宽不是 580 px');
			}
			else {
				if ($pictureHeight != 1032) {
					$this->model->returnJson(false, false, '背景图片的长不是 1032 px');
				}
			}
		}

		$data = $this->model->removeUselessField($data, $this->field);
		$where = array('id' => $data['id']);

		if ($data['id']) {
			$query = pdo_update($this->table, $data, $where);
		}
		else {
			$query = pdo_insert($this->table, $data);
		}

		return $query;
	}

	/**     * 添加心情图片     * @param $data     * @return bool     */
	public function addMoodPicture($data)
	{
		$imagesPrefix = $_SERVER['DOCUMENT_ROOT'] . '/attachment/';
		$where = array('uniacid' => $data['uniacid']);
		pdo_delete($this->sonTable, $where);
		$bool = true;
		if (isset($data['picture_list']) && 0 < count($data['picture_list'])) {
			foreach ($data['picture_list'] as $value) {
				$picturePath = $imagesPrefix . $value;

				if (file_exists($picturePath)) {
					list($pictureWidth, $pictureHeight) = getimagesize($picturePath);
					if ($pictureWidth != 526 && $pictureHeight != 271) {
						$this->model->returnJson(false, false, '该小鸡照片大小不满足 526*271 的要求');
					}
					else if ($pictureWidth != 526) {
						$this->model->returnJson(false, false, '该小鸡照片的宽不是 526 px');
					}
					else {
						if ($pictureHeight != 271) {
							$this->model->returnJson(false, false, '该小鸡照片的高不是 271 px');
						}
					}
				}

				$info['picture'] = $value;
				$info['uniacid'] = $data['uniacid'];
				$info['create_time'] = $data['create_time'];
				$bool = $bool && pdo_insert($this->sonTable, $info);
			}
		}

		return $bool;
	}

	/**     * 验证提交数据     * @param $data     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
	}
}

?>
