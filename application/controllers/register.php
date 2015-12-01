<?php
class register extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->helper('file');
	$this->load->helper('form');
        $this->load->library('session');
        $this->load->library('SimpleLoginSecure');
	$this->load->library('My_PHPMailer');
	$this->load->model('m_setting');
        $this->load->model('m_register');
	}
		
	function index() {
		$data['title'] = $this->m_setting->getSetting();
		$data['header'] = "lyt_login/header";
		$data['content'] = "v_register";		
		$this->load->view('tpl_front', $data);
	}
	
	protected function send_email($email){
		
		$setting = $this->m_setting->getSetting();
		$mail = new PHPMailer();
		$mail->IsSMTP(); // we are going to use SMTP
		$mail->SMTPAuth   = true; // enabled SMTP authentication
		//$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
		$mail->Host       = $setting[0]['stmp_mail'];      // setting GMail as our SMTP server
		$mail->Port       = 25;                   // SMTP port to connect to GMail
		$mail->Username   = $setting[0]['user_mail'];  // user email address
		$mail->Password   = $setting[0]['password_mail']; // password in GMail
		$mail->SetFrom($setting[0]['user_mail'], 'ESRNL');  //Who is sending the email
		$mail->AddReplyTo($email);  //email address that receives the response
		$mail->Subject    = "[ESRNL] Please verify your email ".$email."";
		$mail->Body      = "<br/><br/>Hey, we want to verify that you are indeed ".$email." Verifying this address will let you receive notifications and password resets from ESRNL PORTAL.  If you wish to continue, please follow the link below:
						<br/><br/>".base_url()."index.php/register/email_confirm/".$this->m_register->getHash($email)."";
		$mail->IsHTML(true);
		$destino = $email; // Who is addressed the email to
			
		$mail->AddAddress($destino);
		if(!$mail->Send()) {
			echo  "Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent correctly!";
		}
		
	}
	
	//function for registration
	function processing(){
		
		$this->load->library('form_validation');
		
		$email = $this->input->post('email');
		$paswd = $this->input->post('password');
                $this->session->set_userdata('email', $email);
                
		//set validasi
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check|is_unique[m_user.user_email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[7]');
		$this->form_validation->set_rules('rpassword', 'Retype Password', 'required|matches[password]');
		$this->form_validation->set_rules('tnc', 'Term Of Service','callback_tnc_accept');
		
		$this->form_validation->set_message('is_unique', 'The Email address already in use');
		$this->form_validation->set_error_delimiters('<label for="register_password" class="help-inline help-small no-left-padding" style="color:red">', '</label>');
		
		if($this->form_validation->run() == FALSE){
			$data['title'] = $this->m_setting->getSetting();
			$data['header'] = "lyt_login/header";
			$data['content'] = "v_register";
			$this->load->view('tpl_front', $data);
			
		}
		else{
			//nampilih greenbox di view
			$this->session->set_userdata('noticebox', '3');
			//create new user
			$this->simpleloginsecure->create($email, $paswd);
			$this->session->unset_userdata('email');
			
			//fungsi kirim konfirmasi ke email
			$this->send_email($email);
			
			redirect('/register/'); 
			
			
		}
	}
	
	//check email only for ESRNL
	function email_check($str){
		$str = strtolower($str);
		if (strpos($str,'esrnl.com')){
			return TRUE;
		}
		else{
			$this->form_validation->set_message('email_check', 'Email address must be official');
			return FALSE;
		}
	}
	
	function tnc_accept() {
		if (isset($_POST['tnc'])) return true;
			$this->form_validation->set_message('tnc_accept', 'Please read and accept our terms and conditions.');
		return false;
	}
	
	function email_confirm(){
		if($this->uri->segment(3)){
                    $hash = $this->uri->segment(3);
		    if($this->m_register->updateStatus($hash) == 1){
			$this->session->set_userdata('noticebox', '1');
			redirect('/login/');
			
		    }
		    else{
			redirect('/login/');
		    }
                }
		else{
			redirect('/login/');     
		}
	}
	
	function resend_code(){		
		$data['title'] = $this->m_setting->getSetting();
		$data['header'] = "lyt_login/header";
		$data['content'] = "v_send";		
		$this->load->view('tpl_front', $data);	
	}
	
	protected function validate_email(){
		$this->load->library('form_validation');
		$email = $this->input->post('email');
		
		//set validasi
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
		
		if(($this->m_register->checkActive($email) == 1) && ($this->form_validation->run() == TRUE)){
			//nampilih errormsg
			$this->session->set_userdata('noticebox', '1');
			//fungsi kirim konfirmasi ke email
			$this->send_email($email);
			redirect('/resendcode/');
		}
		else{
			$this->session->set_userdata('noticebox', '2');
			redirect('/resendcode/');
		}
	}
}
?>