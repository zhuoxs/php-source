<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Uploader_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		load()->func('file');
		$field = $_GPC['file'];

		if (!empty($_FILES[$field]['name'])) {
			if (is_array($_FILES[$field]['name'])) {
				$files = array();

				foreach ($_FILES[$field]['name'] as $key => $name) {
					if (strrchr($name, '.') === false) {
						$name = $name . '.jpg';
					}

					$file = array('name' => $name, 'type' => $_FILES[$field]['type'][$key], 'tmp_name' => $_FILES[$field]['tmp_name'][$key], 'error' => $_FILES[$field]['error'][$key], 'size' => $_FILES[$field]['size'][$key]);

					if (function_exists('exif_read_data')) {
						$image = imagecreatefromstring(file_get_contents($file['tmp_name']));
						$exif = exif_read_data($file['tmp_name']);

						if (!empty($exif['Orientation'])) {
							switch ($exif['Orientation']) {
							case 8:
								$image = imagerotate($image, 90, 0);
								break;

							case 3:
								$image = imagerotate($image, 180, 0);
								break;

							case 6:
								$image = imagerotate($image, -90, 0);
								break;
							}
						}

						imagejpeg($image, $file['tmp_name']);
					}

					$files[] = $this->upload($file);
				}

				$ret = array('status' => 'success', 'files' => $files);
				exit(json_encode($ret));
			}
			else {
				if (strrchr($_FILES[$field]['name'], '.') === false) {
					$_FILES[$field]['name'] = $_FILES[$field]['name'] . '.jpg';
				}

				$result = $this->upload($_FILES[$field]);
				exit(json_encode($result));
			}
		}
		else {
			$result['message'] = '请选择要上传的图片！';
			exit(json_encode($result));
		}
	}

	protected function upload($uploadfile)
	{
		global $_W;
		global $_GPC;
		$result['status'] = 'error';

		if ($uploadfile['error'] != 0) {
			$result['message'] = '上传失败，请重试！';
			return $result;
		}

		load()->func('file');
		$path = '/images/ewei_shop/' . $_W['uniacid'];

		if (!is_dir(ATTACHMENT_ROOT . $path)) {
			mkdirs(ATTACHMENT_ROOT . $path);
		}

		$_W['uploadsetting'] = array();
		$_W['uploadsetting']['image']['folder'] = $path;
		$_W['uploadsetting']['image']['extentions'] = $_W['config']['upload']['image']['extentions'];
		$_W['uploadsetting']['image']['limit'] = $_W['config']['upload']['image']['limit'];
		$file = file_upload($uploadfile, 'image');

		if (is_error($file)) {
			$result['message'] = $file['message'];
			return $result;
		}

		if (!empty($_W['setting']['remote'][$_W['uniacid']]['type'])) {
			$_W['setting']['remote'] = $_W['setting']['remote'][$_W['uniacid']];
		}

		if (function_exists('file_remote_upload')) {
			$remote = file_remote_upload($file['path']);

			if (is_error($remote)) {
				$result['message'] = $remote['message'];
				return $result;
			}
		}

		$result['status'] = 'success';
		$result['url'] = $file['url'];
		$result['error'] = 0;
		$result['filename'] = $file['path'];
		$result['url'] = tomedia(trim($result['filename']));
		return $result;
	}

	public function remove()
	{
		global $_W;
		global $_GPC;
		load()->func('file');
		$file = $_GPC['file'];
		file_delete($file);
		exit(json_encode(array('status' => 'success')));
	}
}

?>
