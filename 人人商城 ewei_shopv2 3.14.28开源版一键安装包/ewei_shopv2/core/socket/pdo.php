<?php
class sw_pdo
{
	static public $pdo;
	static private $_config;

	static public function getPDO()
	{
		global $_W;

		if (self::$_config == NULL) {
			$db_config = empty($_W['config']['db']['master']) ? $_W['config']['db'] : $_W['config']['db']['master'];
			if (empty($db_config['host']) || empty($db_config['database'])) {
				$db_config = NULL;
				$config_wq_path = IA_ROOT . '/data/config.php';

				if (is_file($config_wq_path)) {
					require $config_wq_path;
					$db_config = empty($config['db']['master']) ? $config['db'] : $config['db']['master'];
				}
			}

			self::$_config = empty($db_config) ? array() : $db_config;
		}

		if (self::$pdo == NULL) {
			$options = array();

			if (!empty(self::$_config['pconnect'])) {
				$options = array(PDO::ATTR_PERSISTENT => true);
			}

			try {
				self::$pdo = new PDO('mysql:host=' . self::$_config['host'] . ';dbname=' . self::$_config['database'] . ';port=' . self::$_config['port'] . ';charset=' . self::$_config['charset'], self::$_config['username'], self::$_config['password'], $options);
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (Exception $ex) {
				exit($ex->getMessage());
			}
		}

		return self::$pdo;
	}

	/**
     * 开始事务 易-福-网提供
     * @return bool
     */
	static public function beginTransaction()
	{
		return self::getPDO()->beginTransaction();
	}

	/**
     * 提交事务
     * @return bool
     */
	static public function commit()
	{
		return self::getPDO()->commit();
	}

	/**
     * 事务回滚
     * @return bool
     */
	static public function rollBack()
	{
		return self::getPDO()->rollBack();
	}

	/**
     * 错误代码
     * @return mixed
     */
	static public function errorCode()
	{
		return self::getPDO()->errorCode();
	}

	/**
     * 错误信息
     * @return array
     */
	static public function errorInfo()
	{
		return self::getPDO()->errorInfo();
	}

	/**
     * 上次插入的ID
     * @return string
     */
	static public function lastInsertId()
	{
		return self::getPDO()->lastInsertId();
	}

	/**
     * 获取一条记录
     * @param $sql
     * @param array $params
     * @return mixed
     */
	static public function fetch($sql, $params = array(), $fetchMode = PDO::FETCH_ASSOC)
	{
		$results = self::prepare($sql, $params);
		$results->setFetchMode($fetchMode);
		return $results->fetch();
	}

	/**
     * 获取一个字段值
     * @param $sql
     * @param array $params
     * @return string
     */
	static public function fetchColumn($sql, $params = array())
	{
		$results = self::prepare($sql, $params);
		return $results->fetchColumn();
	}

	/**
     * 获取一个数据集
     * @param $sql
     * @param array $params
     * @return array
     */
	static public function fetchAll($sql, $params = array(), $keyfield = '', $fetchMode = PDO::FETCH_ASSOC)
	{
		$results = self::prepare($sql, $params);
		$results->setFetchMode($fetchMode);
		$res = $results->fetchAll();
		$ret = $res;
		if (!empty($res) && !empty($keyfield)) {
			$ret = array();

			foreach ($res as $val) {
				$ret[$val[$keyfield]] = $val;
			}
		}

		return $ret;
	}

	static public function insert($table, $data = array(), $replace = false)
	{
		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$condition = self::implode($data, ',');
		return self::exec($cmd . ' ' . tablename($table) . (' SET ' . $condition['fields']), $condition['params']);
	}

	static public function update($table, $data = array(), $params = array(), $glue = 'AND')
	{
		$fields = self::implode($data, ',');
		$condition = self::implode($params, $glue);
		$params = array_merge($fields['params'], $condition['params']);
		$sql = 'UPDATE ' . tablename($table) . (' SET ' . $fields['fields']);
		$sql .= $condition['fields'] ? ' WHERE ' . $condition['fields'] : '';
		return self::exec($sql, $params);
	}

	static public function delete($table, $params = array(), $glue = 'AND')
	{
		$condition = self::implode($params, $glue);
		$sql = 'DELETE FROM ' . tablename($table);
		$sql .= $condition['fields'] ? ' WHERE ' . $condition['fields'] : '';
		return self::exec($sql, $condition['params']);
	}

	static private function implode($params, $glue = ',')
	{
		$result = array(
			'fields' => ' 1 ',
			'params' => array()
			);
		$split = '';
		$suffix = '';
		$allow_operator = array('>', '<', '<>', '!=', '>=', '<=', '+=', '-=', 'LIKE', 'like');

		if (in_array(strtolower($glue), array('and', 'or'))) {
			$suffix = '__';
		}

		if (!is_array($params)) {
			$result['fields'] = $params;
			return $result;
		}

		if (is_array($params)) {
			$result['fields'] = '';

			foreach ($params as $fields => $value) {
				$operator = '';

				if (strpos($fields, ' ') !== false) {
					list($fields, $operator) = explode(' ', $fields, 2);

					if (!in_array($operator, $allow_operator)) {
						$operator = '';
					}
				}

				if (empty($operator)) {
					$fields = trim($fields);
					if (is_array($value) && !empty($value)) {
						$operator = 'IN';
					}
					else {
						$operator = '=';
					}
				}
				else if ($operator == '+=') {
					$operator = ' = `' . $fields . '` + ';
				}
				else if ($operator == '-=') {
					$operator = ' = `' . $fields . '` - ';
				}
				else {
					if ($operator == '!=' || $operator == '<>') {
						if (is_array($value) && !empty($value)) {
							$operator = 'NOT IN';
						}
					}
				}

				if (is_array($value) && !empty($value)) {
					$insql = array();
					$value = array_values($value);

					foreach ($value as $k => $v) {
						$insql[] = ':' . $suffix . $fields . '_' . $k;
						$result['params'][':' . $suffix . $fields . '_' . $k] = is_null($v) ? '' : $v;
					}

					$result['fields'] .= $split . ('`' . $fields . '` ' . $operator . ' (') . implode(',', $insql) . ')';
					$split = ' ' . $glue . ' ';
				}
				else {
					$result['fields'] .= $split . ('`' . $fields . '` ' . $operator . '  :' . $suffix . $fields);
					$split = ' ' . $glue . ' ';
					$result['params'][':' . $suffix . $fields] = is_null($value) || is_array($value) ? '' : $value;
				}
			}
		}

		return $result;
	}

	/**
     * 执行SQL, 插入返回 lastInsertID 其他返回影响行数
     * @param $sql
     * @param array $params
     * @return int|string
     */
	static public function exec($sql, $params = array())
	{
		$results = self::prepare($sql, $params);

		if (preg_match('/^\\s*(INSERT\\s+INTO|REPLACE\\s+INTO)\\s+/i', $sql)) {
			return (int) self::getPDO()->lastInsertId();
		}

		return $results->rowCount();
	}

	static protected function prepare($sql, $params = array())
	{
		try {
			$stmt = self::getPDO()->prepare($sql);

			if (!is_array($params)) {
				$params = array();
			}

			$exec = $stmt->execute($params);

			if ($exec) {
				return $stmt;
			}

			return false;
		}
		catch (Exception $ex) {
			if ($ex->getCode() == 'HY000') {
				self::$pdo = NULL;
				return self::prepare($sql, $params);
			}

			throw $ex;
		}
	}
}

function pdo_query2($sql, $params = array())
{
	return sw_pdo::exec($sql, $params);
}

function pdo_fetchcolumn2($sql, $params = array())
{
	return sw_pdo::fetchColumn($sql, $params);
}

function pdo_fetch2($sql, $params = array())
{
	return sw_pdo::fetch($sql, $params);
}

function pdo_fetchall2($sql, $params = array(), $keyfield = '')
{
	return sw_pdo::fetchAll($sql, $params, $keyfield);
}

function pdo_update2($table, $data = array(), $params = array(), $glue = 'AND')
{
	return sw_pdo::update($table, $data, $params, $glue);
}

function pdo_insert2($table, $data = array(), $replace = false)
{
	return sw_pdo::insert($table, $data, $replace);
}

function pdo_delete2($table, $params = array(), $glue = 'AND')
{
	return sw_pdo::delete($table, $params, $glue);
}

function pdo_insertid2()
{
	return sw_pdo::lastInsertId();
}

function pdo_begin2()
{
	sw_pdo::beginTransaction();
}

function pdo_commit2()
{
	sw_pdo::commit();
}

function pdo_rollback2()
{
	sw_pdo::rollBack();
}

defined('IN_IA') || exit('Access Denied');

?>
