<?php
namespace TuDublin;

class LoginController extends Controller
{
    function loginForm($error = false)
    {
        $template = 'login.html.twig';
        $args = [];

        // add error message if 'error'
        if($error){
            $args['errorMessage'] =  'invalid credentials - please try again';
        }

        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processLogin()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        if($this->validCredentials($username, $password)){
            $this->successfulLoginAction($username);
        } else {
            // redisplay login form - but with an error message
            $this->loginForm(true);
        }
    }

    public function validCredentials($username, $password)
    {
        if('admin' == $username && 'admin' == $password){
            return true;
        }

        if('user' == $username && 'user' == $password){
            return true;
        }

        if('matt' == $username && 'smith' == $password){
            return true;
        }

        return false;
    }

    private function successfulLoginAction($username)
    {
        // session stuff here

        $_SESSION['username'] = $username;
        $mainController = new MainController();
        $mainController->home();
    }

    public function logout()
    {
        $_SESSION = [];
        $mainController = new MainController();
        $mainController->home();
    }
}
