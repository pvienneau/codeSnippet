<?php 

/**
 * class LoginController
 *
 * Log a use in and out and send a mail with something on 
 * if the user doesn't remember is password !!!
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since  0.1
 */

class AuthenticationController extends Controller
{
    function __construct()
    {
        parent::__construct();

    	$this->setLayout('visitor');
	}
    
    // function index()
    // {
    //     // already log in ?
    //     if (AuthUser::isLoggedIn()) {
    //         redirect(get_url());
    //     }
    // 
    //     // show it!
    //     echo $this->render('login/login');
    // } // add
    
    function login()
    {
	
		if (AuthUser::isLoggedIn()) {
			redirect(get_url());
		}
		
		if(self::is_submit('user')){
			return $this->_login();
		}
	
		echo $this->render('authentication/login');
	
		//if()
		//
        // already log in ?
        // if (AuthUser::isLoggedIn()) {
        //             redirect(get_url());
        //         }
        // 
        //         $data = isset($_POST) ? $_POST: array();
        //         
        //         if (AuthUser::login($data['username'], $data['password'], true)) {
        // 
        // 			if(isset($_SESSION["redirect_url"])){
        // 				$url = $_SESSION["redirect_url"];
        // 				unset ($_SESSION["redirect_url"]);
        // 				redirect($url);
        // 			}else{
        // 				// redirect to defaut controller and action
        // 				redirect(get_url());
        // 			}
        //         } else {
        //             // login error
        //             Flash::set('error', 'Failed to log you in. Please check your login data and try again');
        //         } // if
        //         
        //         // not find or password is wrong
        //         redirect(get_url('login'));
        
    } // login

	function _login(){
		$post = $_POST;
		
		if(AuthUser::login($post['username'], $post['password'])){
			redirect(get_url());
		}else{
			Flash::set('error', 'Failed to log you in. Please try again.');
		}
	}
    
    function logout()
    {
        AuthUser::logout();
        redirect(get_url('login'));
    } // logout
    
    function forgot()
    {
        // show it!
        // echo $this->render('login/forgot');
    } // forgot
    
} // LoginController
