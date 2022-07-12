<?php

class Auth extends CI_Controller{
	public function login(){
		$this->form_validation->set_rules('username','Username','required',['required' => ' wajib mengisi username!']);
		$this->form_validation->set_rules('password','Password','required',['required' => ' wajib mengisi password!']);
		if($this->form_validation->run() == FALSE){
			$this->load->view('admin_header');
			$this->load->view('form_login');
			$this->load->view('sidebar_footer');
		}else{
			$auth = $this->model_auth->cek_login();
			if($auth == FALSE){
				$this->session->set_flashdata('pesan','
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  Username atau Password anda salah!
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				');
				redirect('auth/login');
			}else{
				$this->session->set_userdata('username',$auth->username);
				$this->session->set_userdata('role_id',$auth->role_id);
				switch($auth->role_id){
					case 1 : redirect('dashboard_admin');
						break;
					case 2 : redirect('dashboard_petugas');
						break;
					default : break;
				}
			}
		}
	}
	public function edit(){
		$this->load->view('admin_header');
		$this->load->view('edit_user');
		$this->load->view('sidebar_footer');
	}
	public function update(){
		$this->form_validation->set_rules('username','Username','required', ['required' => 'Username wajib diisi!']);
		$this->form_validation->set_rules('password_1','Password','required|matches[password_2]',['required' => 'Password wajib diisi!' , 'matches' => 'Password tidak sesuai!']);
		$this->form_validation->set_rules('password_2','Password','required|matches[password_1]',['required' => 'Password wajib diisi!' , 'matches' => 'Password tidak sesuai!']);

		if($this->form_validation->run() == FALSE){
			$this->load->view('admin_header');
			$this->load->view('edit_user');
			$this->load->view('sidebar_footer');
		}else{
			$where = array(
				'username'		=> $this->session->userdata('username'),
			);
			$data = array(
				'username'		=> $this->input->post('username'),
				'password'		=> $this->input->post('password_2'),
			);

			$this->model_auth->update_akun_user($where,$data,'tb_user');

			$this->session->sess_destroy();
			redirect('auth/login');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}