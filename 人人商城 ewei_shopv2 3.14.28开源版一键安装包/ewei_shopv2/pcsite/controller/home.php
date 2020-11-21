<?php

if (!defined('ES_PATH')) {
	exit('Access Denied');
}

class HomeController extends Controller
{
	protected $type = 'set';
	protected $site;

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		$set = pdo_fetch('select * from ' . tablename('ewei_shop_system_site') . ' where `type`=:type', array(':type' => $this->type));

		if (empty($set)) {
			exit('请先到【系统设置】->【网站】->【基础设置】 配置网站数据.');
		}

		if (!empty($set['content']) && !is_array($set['content'])) {
			if (strexists($set['content'], '{"')) {
				$data = json_decode($set['content'], true);
			}
			else {
				$data = unserialize($set['content']);
			}
		}

		if (!is_array($data)) {
			$data = array();
		}

		$this->site = $data;

		if (empty($data['status'])) {
			$this->shutdown($data);
		}
	}

	public function index()
	{
		global $_W;
		$site = $this->site;
		$banner = $this->banner(1);
		$casus = $this->casus(1);
		$link = $this->link(1);
		$article = $this->article(1);
		$companyArticle = $this->companyArticle();
		$basicset = $this->basicset();
		$title = $basicset['title'];
		include $this->template('index');
	}

	public function ajaxguestbook()
	{
		global $_GPC;
		$guestbookform['nickname'] = trim($_GPC['nickname']);
		$guestbookform['mobile'] = trim($_GPC['mobile']);
		$guestbookform['email'] = trim($_GPC['email']);
		$guestbookform['content'] = trim($_GPC['content']);

		if (empty($guestbookform['nickname'])) {
			exit(json_encode(array('status' => 'error', 'message' => '姓名不能为空!', 'type' => 'nickname')));
		}

		if (empty($guestbookform['mobile'])) {
			exit(json_encode(array('status' => 'error', 'message' => '电话不能为空!', 'type' => 'mobile')));
		}

		if (empty($guestbookform['email'])) {
			exit(json_encode(array('status' => 'error', 'message' => '邮箱不能为空!', 'type' => 'email')));
		}

		if (empty($guestbookform['content'])) {
			exit(json_encode(array('status' => 'error', 'message' => '内容不能为空!', 'type' => 'content')));
		}

		$guestbook = pdo_fetch('SELECT * FROM' . tablename('ewei_shop_system_guestbook') . ' WHERE clientip=:clientip ORDER BY createtime DESC LIMIT 1', array(':clientip' => ES_CLIENT_IP));
		if (!empty($guestbook) && TIMESTAMP <= $guestbook['createtime'] + 60) {
			exit(json_encode(array('status' => 'error', 'message' => '距离上次留言时间小于1分钟!')));
		}

		$guestbookform['createtime'] = TIMESTAMP;
		$guestbookform['clientip'] = ES_CLIENT_IP;
		pdo_insert('ewei_shop_system_guestbook', $guestbookform);

		if (pdo_insertid()) {
			echo json_encode(array('status' => 'success', 'message' => '留言成功!'));
		}
		else {
			echo json_encode(array('status' => 'error', 'message' => '留言失败!'));
		}
	}

	protected function shutdown(array $data)
	{
		$url = $this->site['closeurl'];

		if (empty($url)) {
			exit('网站已经关闭');
		}
		else {
			header('location: ' . $url);
			exit();
		}
	}

	protected function banner($status = 'all')
	{
		$statusSql = $this->statusSql($status);
		$result = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_banner') . (' WHERE 1 ' . $statusSql['sql'] . '  ORDER BY displayorder DESC'), $statusSql['param']);
		return $result;
	}

	protected function casus($status = 'all')
	{
		$statusSql = $this->statusSql($status);
		$result = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_case') . (' WHERE 1 ' . $statusSql['sql'] . '  ORDER BY displayorder DESC'), $statusSql['param']);
		return $result;
	}

	protected function link($status = 'all')
	{
		$statusSql = $this->statusSql($status);
		$result = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_link') . (' WHERE 1 ' . $statusSql['sql'] . '  ORDER BY displayorder DESC'), $statusSql['param']);
		return $result;
	}

	protected function article($status = 'all', $limit = 6)
	{
		$statusSql = $this->statusSql($status);
		$statusSql['sql'] = str_replace(' status ', ' a.status ', $statusSql['sql']);
		$result = pdo_fetchall('SELECT a.id,a.title,a.content,a.createtime,c.name FROM ' . tablename('ewei_shop_system_article') . ' AS a LEFT JOIN ' . tablename('ewei_shop_system_category') . (' AS c ON a.cate = c.id WHERE 1 ' . $statusSql['sql'] . '  ORDER BY a.displayorder DESC LIMIT ' . $limit), $statusSql['param']);
		return $result;
	}

	protected function companyArticle($status = 'all', $limit = 6)
	{
		$statusSql = $this->statusSql($status);
		$statusSql['sql'] = str_replace(' status ', ' a.status ', $statusSql['sql']);
		$result = pdo_fetchall('SELECT a.*,c.id as cid,c.name FROM ' . tablename('ewei_shop_system_company_article') . ' AS a LEFT JOIN ' . tablename('ewei_shop_system_company_category') . (' AS c ON a.cate = c.id WHERE 1 ' . $statusSql['sql'] . '  ORDER BY a.displayorder DESC LIMIT ' . $limit), $statusSql['param']);
		return $result;
	}

	/**
     * 拼接sql status语句
     * @param $status
     * @return array
     */
	protected function statusSql($status)
	{
		$condition = '';
		$param = array();

		if ($status != 'all') {
			$status = intval($status);
			$condition .= 'AND status = :status';
			$param[':status'] = $status;
		}

		return array('sql' => $condition, 'param' => $param);
	}
}

?>
