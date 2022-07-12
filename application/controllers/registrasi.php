<?php
class Registrasi extends CI_Controller{
	function index(){
		$this->form_validation->set_rules('username','Username','required', ['required' => 'Username wajib diisi!']);
		$this->form_validation->set_rules('password_1','Password','required|matches[password_2]',['required' => 'Password wajib diisi!' , 'matches' => 'Password tidak sesuai!']);
		$this->form_validation->set_rules('password_2','Password','required|matches[password_1]',['required' => 'Password wajib diisi!' , 'matches' => 'Password tidak sesuai!']);

		if($this->form_validation->run() == FALSE){
			$this->load->view('admin_header');
			$this->load->view('registrasi');
			$this->load->view('sidebar_footer');
		}else{
			$data = array(
				'id_user' 		=> '',
				'username'		=> $this->input->post('username'),
				'password'		=> $this->input->post('password_1'),
				'role_id'		=> 2,
			);
			$this->db->insert('tb_user',$data);
			redirect('auth/login');
		}
	}
}