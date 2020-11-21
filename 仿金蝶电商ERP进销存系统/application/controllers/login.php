<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
	 
	public function index(){
	    $data = str_enhtml($this->input->post(NULL,TRUE));
		if (is_array($data)&&count($data)>0) {
			!token(1) && die('token验证失败'); 
			strlen($data['username']) < 1 && die('用户名不能为空'); 
			strlen($data['userpwd']) < 1  && die('密码不能为空'); 
			$user = $this->mysql_model->get_rows('admin','(username="'.$data['username'].'") or (mobile="'.$data['username'].'") ');
			if (count($user)>0) {
			    $user['status']!=1 && die('账号被锁定'); 
				if ($user['userpwd'] == md5($data['userpwd'])) {
					$data['jxcsys']['uid']      = $user['uid'];
					$data['jxcsys']['name']     = $user['name'];
					$data['jxcsys']['roleid']   = $user['roleid'];
					$data['jxcsys']['username'] = $user['username'];
					$data['jxcsys']['login']    = 'jxc'; 
					if (isset($data['ispwd']) && $data['ispwd'] == 1) {
					    $this->input->set_cookie('username',$data['username'],3600000); 
						$this->input->set_cookie('userpwd',$data['userpwd'],3600000); 
					} 
					$this->input->set_cookie('ispwd',$data['ispwd'],3600000);
					$this->session->set_userdata($data); 
					$this->common_model->logs('登陆成功 用户名：'.$data['username']);
					die('1'); 
			   }		
			}
			die('账号或密码错误');
		} else {
		    $this->load->view('login',$data);
		}
	}
	
	public function out(){
	    $this->session->sess_destroy();
		redirect(site_url('login'));
	}
	
	public function code(){
	    $this->load->library('lib_code');
		$this->lib_code->image();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */