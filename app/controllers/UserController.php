<?php

class UserController extends Controller
{
	function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		$this->setLayout('default');
	}
	
	function index()
	{
		if ( ! (AuthUser::accessLevel("users") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		echo $this->render('user/index', array('users' => User::findAll()));
	}
	
	public function show($id, $month=false)
	{
		if ( ! (AuthUser::accessLevel("users") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		$this->setLayout('default');
		$this->display('user/show', array(
			'user' => User::get($id),
			'month' => !$month ? date('Y-m'): $month
		));
	}
	
	function add()
	{
		if ( ! (AuthUser::accessLevel("users") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (get_request_method() == 'POST') {
			return $this->_add();
		}
		
		// check if user have already enter something
		$user = Flash::get('post_data');
		
		if (empty($user)) {
			$user = new User;
		}
		
		echo $this->render('user/edit', array(
			'user' => $user
		));
	}
	
	function _add()
	{
		
		$_POST["is_admin"] = (!isset($_POST["is_admin"])) ? 0 : 1;
		$_POST["is_active"] = (!isset($_POST["is_active"])) ? 0 : 1;
		
		$data = $_POST;
		
		Flash::set('post_data', (object) $data);
		
		// check if pass and confirm are egal and >= 5 chars
		if (strlen($data['password']) >= 5 && $data['password'] == $data['confirm']) {
			$data['password'] = sha1($data['password']);
			unset($data['confirm']);
		} else {
			Flash::set('error', __('Password and Confirm are not the same or too small!'));
			redirect(get_url('user/add'));
		}
		
		// check if username >= 3 chars
		if (strlen($data['username']) < 3) {
			Flash::set('error', __('Username must be 3 character minimum!'));
			redirect(get_url('user/add'));
		}

		$user = new User($data);

		if ($user->save()) {
			// now we need to add permissions
			Flash::set('success', __('User has been added!'));
		} else {
			Flash::set('error', __('User has not been added!'));
		}
		
		redirect(get_url('user'));
	}
	
	function edit($id)
	{
		if ( ! (AuthUser::accessLevel("users") > 1) &&  AuthUser::getId() != $id) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (get_request_method() == 'POST') {
			return $this->_edit($id);
		}
		
		echo $this->render('user/edit', array(
			'user' => User::findBy('id', $id)
		));
	}
	
	function _edit($id)
	{
		if ( ! $user = User::findBy('id', $id)) {
			Flash::set('error', 'User not found!');
			redirect(get_url('user'));
		}
		
		if(AuthUser::isAdmin()){
			$_POST["is_admin"] = (!isset($_POST["is_admin"])) ? 0 : 1;
			$_POST["is_active"] = (!isset($_POST["is_active"])) ? 0 : 1;
		}else{
			unset($_POST["is_admin"],$_POST["is_active"]);
		}
		
		$data = $_POST;
		unset($data['oldpassword']);
		
		
		// check if user want to change the password
		if (strlen($data['newpassword']) > 0) {
			// check if pass and confirm are egal and >= 5 chars
			if (strlen($data['newpassword']) >= 5 && $data['newpassword'] == $data['confirm']) {
				$data['password'] = sha1($data['newpassword']);
				unset($data['confirm']);
			} else {
				Flash::set('error', __('Password and Confirm are not the same or too small!'));
				redirect(get_url('user/edit/'.$id));
			}
		} else {
			unset($data['password'], $data['confirm']);
		}
		unset($data['newpassword']);
		
		// check if username >= 3 chars
		if (strlen($data['username']) < 3) {
			unset($data['username']);
			Flash::set('error', __('Username have not been save must be 3 character minimum!'));
		}
		
		$user = Record::findByIdFrom('User', $id);
		$user->setFromData($data);
			
		
		if ($user->save()) {
			Flash::set('success', 'User <strong>'.$user->name.'</strong> has been updated with success!');
		} else {
			Flash::set('error', 'User <strong>'.$user->name.'</strong> has NOT been updated!');
		}
		if(AuthUser::isAdmin()){
			redirect(get_url('user'));
		}else{
			redirect(get_url(''));
		}
	}
	
	public function picture($user_id)
	{
		$user_id = (int) $user_id;
		if (!AuthUser::isAdmin() && AuthUser::getId() != $user_id)
			return;
		
		use_helper('image');
		
		$path = CORE_ROOT.'/_/img/'.$user_id;
		
		$s = new Image($_FILES['filename']['tmp_name'], $path.'_s.jpg', 25, 25, '1:1');
		$m = new Image($_FILES['filename']['tmp_name'], $path.'_m.jpg', 50, 50, '1:1');
		
		round_image($path.'_s.jpg', $path.'_s.png');
		round_image($path.'_m.jpg', $path.'_m.png');
		
		chmod($path.'_s.jpg', 0755);
		chmod($path.'_s.png', 0755);
		chmod($path.'_m.jpg', 0755);
		chmod($path.'_m.png', 0755);
		
		redirect(get_url('user'));
	}
	
	function remove($id)
	{
		if ( ! (AuthUser::accessLevel("users") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if ($user = User::get($id)) {
			$user->deleted = 1;
			$user->is_active = 0;
			$user->is_admin = 0;
		
			if ($user->save()) {
				Flash::set('success', 'User <strong>'.$user->name.'</strong> has been deleted!');
			} else {
				Flash::set('error', 'User <strong>'.$user->name.'</strong> has NOT been deleted!');
			}
		}else{
			Flash::set('error', 'User <strong>'.$id.'</strong> does not exist!');	
		}
		redirect(get_url('user'));
	}

} // end UserController class
