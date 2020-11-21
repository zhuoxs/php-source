<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Processor extends WeModuleProcessor
{
	public function respond()
	{
		$rule = pdo_fetch('select * from ' . tablename('rule') . ' where id=:id limit 1', array(':id' => $this->rule));

		if (empty($rule)) {
			return false;
		}

		$names = explode(':', $rule['name']);
		$plugin = isset($names[1]) ? $names[1] : '';
		$processname = $plugin;

		if (!empty($plugin)) {
			if ($plugin == 'com') {
				$com = isset($names[2]) ? $names[2] : '';

				if (empty($com)) {
					return false;
				}

				$processname = $com;
				$processor_file = EWEI_SHOPV2_PROCESSOR . $com . '.php';
			}
			else {
				$processor_file = EWEI_SHOPV2_PLUGIN . $plugin . '/core/processor.php';
			}

			if (is_file($processor_file)) {
				require $processor_file;
				$processor_class = ucfirst($processname) . 'Processor';
				$proc = new $processor_class($plugin);

				if (method_exists($proc, 'respond')) {
					return $proc->respond($this);
				}
			}
		}
	}
}

?>
