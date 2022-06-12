<?php
namespace Bankas\Controllers;
use Bankas\App;
use Bankas\Messages as Msg;

class LoginController {

    public function showLogin() {
        return App::view('login', ['messages' => Msg::get()]);
    }

    public function doLogin() {
        $users = json_decode(file_get_contents(App::APP.'data/users.json'));
        foreach($users as $user) {
            if ($_POST['name'] != $user->name) {
                continue;
            }
            if (md5($_POST['password']) != $user->password) {
                Msg::add('Blogi prisijungimo duomenys', 'alert');
                return App::redirect('login');
            } else {
                App::authAdd($user);
                Msg::add('Sveikas, '.$user->name, 'success');
                return App::redirect('home');
            }
        }
        Msg::add('Blogi prisijungimo duomenys', 'alert');
        return App::redirect('login');
    }

    public function doLogout() {
        App::authRem();
        Msg::add('Atsijungta', 'success');
        return App::redirect('login');
    }
}