<?php
namespace Bankas;
use Bankas\Controllers\BankController;
use Bankas\Controllers\LoginController;
use Bankas\Controllers\JsonDb;
use Bankas\Messages;


class App {
        
        const DOMAIN = 'bankas.lt';
        const APP = __DIR__ . '/../';
        private static $html;
        
        // private static $db;

        public  static function start() {
            session_start();
            Messages::init();
            // $db = new JsonDb('users');
            ob_start();
            $uri = explode('/', $_SERVER['REQUEST_URI']);
            array_shift($uri);
            self::route($uri);
            self::$html = ob_get_contents();
            ob_end_clean();
        }

        public static function sent() {
            echo self::$html;
        }

        public static function view(string $name, array $data = []) {
            extract($data);
            require __DIR__ .' /../views/'.$name.'.php';
        }

        public static function json(array $data = []) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        public static function redirect($url = '') {
            header('Location: http://'.self::DOMAIN.'/'.$url);
        }

        public static function url($url = '') {
            return 'http://'.self::DOMAIN.'/'.$url;
        }

        public static function DeleteAcc($url = '', $id) {
            return 'http://'.self::DOMAIN.'/'.$url.'/'.$id;
        }

        public static function authAdd(object $user) {
            $_SESSION['auth'] = 1;
            $_SESSION['user'] = $user;
        }

        public static function authRem() {
            unset($_SESSION['auth'], $_SESSION['user']);
        }

        public static function auth() : bool {
            return isset($_SESSION['auth']) && $_SESSION['auth'] == 1;
        }

        public static function authName() : string {
            return $_SESSION['user']->name;
        }

        private static function route(array $uri) {

            $m = $_SERVER['REQUEST_METHOD'];

            //LOGIN

            if ('GET' == $m && count($uri) == 1 && $uri[0] === 'login') {
                if (self::auth()) {
                    return self::redirect();
                }
                return (new LoginController)->showLogin();
            }

            if ('POST' == $m && count($uri) == 1 && $uri[0] === 'login') {
                return (new LoginController)->doLogin();
            }

            if ('POST' == $m && count($uri) == 1 && $uri[0] === 'logout') {
                return (new LoginController)->doLogout();
            }



            if (count($uri) == 1 && $uri[0] === '') {
                return (new BankController)->defPage( );
                // return (new LoginController)->showLogin();
            }

            if ('GET' == $m && count($uri) == 1 && $uri[0] === 'home') {
                return (new BankController)->index();
            }

            if ('GET' == $m && count($uri) == 1 && $uri[0] === 'userList') {
                return (new BankController)->userList();
            }

            if ('GET' == $m && count($uri) == 2 && $uri[0] === 'cashIn') {
                return (new BankController)->addFunds();
            }

            if ('POST' == $m && count($uri) == 2 && $uri[0] === 'cashIn') {
                return (new BankController)->cashIn((int) $uri[1], (int) $_POST['amount']);
            }

            if ('GET' == $m && count($uri) == 2 && $uri[0] === 'cashOut') {
                return (new BankController)->takeOutFunds();
            }

            if ('POST' == $m && count($uri) == 2 && $uri[0] === 'cashOut') {
                return (new BankController)->cashOut((int) $uri[1], (int) $_POST['amount']);
            }

            if ('GET' == $m && count($uri) == 1 && $uri[0] === 'addUser') {
                return (new BankController)->addUser();
            }

            if ('POST' == $m && count($uri) == 1 && $uri[0] === 'addUser')
        {
            $newUser = array(
                'personalCode' => $_POST['personalCode'],
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'password' => $_POST['password'],
                'accNumber' => $_POST['accNumber']
            );
            (new BankController)->createAccount($newUser);
        }

            if ('GET' == $m && count($uri) == 1 && $uri[0] === 'json') {
                return (new BankController)->indexJson( );
            }

            if ('GET' == $m && count($uri) == 2 && $uri[0] === 'get-it') {
                return (new BankController)->getIt($uri[1]);
            }

            if ('GET' == $m && count($uri) == 1 && $uri[0] === 'defPage') {
                if (!self::auth()) {
                    return self::redirect('login');
                }
                return (new BankController)->form( );
            }

            if ('POST' == $m && count($uri) == 1 && $uri[0] === 'forma') {
                return (new BankController)->doForm( );
            }


            if ('POST' == $m && count($uri) == 2 && $uri[0] === 'delete') {
                (new JsonDb('users'))->delete($uri[1]);
                // $db->delete($uri[1]);
                
                // self::url('userList');
                // header('Location: http://bankas.lt/userList');
                self::redirect('userList');
                die;
            }
            


            else {
                echo 'kitka';
                echo ($_SERVER['REQUEST_METHOD']);
            }

        }

}