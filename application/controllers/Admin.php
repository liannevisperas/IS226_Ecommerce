<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	
	public function index()
	{
		if ($this->session->userdata('aId')) {
			$this->load->view('admin/header/header');
			$this->load->view('admin/header/css');
			$this->load->view('admin/header/navtop');
			$this->load->view('admin/header/navleft');
			$this->load->view('admin/home/index');
			$this->load->view('admin/header/footer');
			$this->load->view('admin/header/htmlclose');	
		}
		else{
			$this->session->set_flashdata('error','Invalid credentials. Email or Password is not matched. Please try again.');
			redirect('admin/login');
		}
	}

	public function login(){
		$this->load->view('admin/login');
	}

	public function checkAdmin(){
		$data['aEmail']= $this->input->post('email',true); //post(name,true)
		$data['aPassword']= $this->input->post('password',true);

		if (!empty($data['aEmail']) && !empty($data['aPassword'])){
			$admin = $this->modAdmin->checkAdmin($data);
			if (count($admin)==1){ //here you are checking the array
				$forSession = array(
						'aId'=>$admin[0]['aId'],
						'aName'=>$admin[0]['aName'],
						'aEmail'=>$admin[0]['aEmail']
				);

				$this->session->set_userdata($forSession);
				if ($this->session->userdata('aId')){
					redirect('admin/index');
				}
				else{
					echo 'Session Not Created';
				}

			}
			else {
				$this->session->set_flashdata('error','Invalid credentials. Email or Password is not matched. Please try again.');
				redirect('admin/login');
			}

		}
		else{
			$this->session->set_flashdata('error','Please check the required fields.');
			redirect('admin/login');
		}
	}

}//class ends here..


