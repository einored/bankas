<?php
namespace Bankas\Controllers;
use Bankas\App;
use Bankas\Messages as M;
use Bankas\Controllers\JsonDb;


class BankController {

    public function defPage() {
        return App::view('defPage', [
            'title' => 'Bank'
        ]);
    }

    public function index() {
        return App::view('home', [
            'title' => 'Home page'
        ]);
    }

    public function userList() {
        return App::view('userList', [
            'title' => 'Account list'
        ]);
    }

    

    public function getIBAN()
    {
        $iban = 'LT';
        $iban .= (string)rand(0, 9);
        $iban .= (string)rand(0, 9);
        $iban .= '12121';
        for ($i = 0; $i < 11; $i++)
            $iban .= (string)rand(0, 9);
        return $iban;
    }

    public function addUser() {
        return App::view('addUser', [
            'title' => 'Add User',
            'iban' => self::getIBAN()
        ]);
    }

    public function createAccount(array $arr)
    {
        
        $arr['password'] = md5($arr['password']);
        $arr['balance'] = 0;
        (new JsonDb('users'))->create($arr);
        M::add('Account created', 'success');
        return App::redirect('addUser');

    }

    public function addFunds()
    {
        // $db = new JsonDb('users');
        // $user = $db->show(App::uri[1]);
        return App::view('cashIn', [
            'title' => 'Cash In'
        ]);
    }

    public function cashIn(int $personalCode, int $amount) {
        $db = new JsonDb('users');
        $user = $db->show($personalCode);
        // print_r($db);
        $user['balance'] += $amount;
        // print_r($personalCode);
        // die;
        $db->update($personalCode,(array) $user);
        unset($db);
        // M::add('Funds deposited', 'success');

        return App::redirect('userList');
    }

    public function takeOutFunds()
    {
        return App::view('cashOut', [
            'title' => 'Cash Out'
        ]);
    }

    public function cashOut(int $personalCode, int $amount) {
        $db = new JsonDb('users');
        $user = $db->show($personalCode);
        $user['balance'] -= $amount;
        $db->update($personalCode,(array) $user);
        unset($db);

        return App::redirect('userList');
    }

    public function getIt($param) {

        echo 'AAA: '.$param;
    }


    // public function index() {
    //     $list = [];
    //     for($i = 0; $i < 10; $i++) {
    //         $list[] = rand(1000, 9999);
    //     }
    //     return App::view('home', [
    //         'title' => 'Alabama',
    //         'list' => $list
    //     ]);
    // }

    public function indexJson() {
        $list = [];
        for($i = 0; $i < 10; $i++) {
            $list[] = rand(1000, 9999);
        }
        return App::json([
            'title' => 'Alabama',
            'list' => $list
        ]);
    }

    public function form() {
        return App::view('form', ['messages' => M::get()]);
    }

    public function doForm() {
        M::add('Puiku', 'alert');
        M::add($_POST['alabama'], 'success');
        return App::redirect('forma');
    }
}