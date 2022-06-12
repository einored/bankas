<?php
namespace Bankas\Controllers;
use Bankas\DataBase;
use Bankas\App;
 
class JsonDB implements DataBase
{
    private $data, $file;

    public function __construct($file) {
        $this->file = $file;
        if (!file_exists(App::APP . '/data/'.$file.'.json')) {
            file_put_contents(App::APP . '/data/'.$file.'.json', json_encode([]));
            // file_put_contents(App::APP . '/data/'.$file.'_id.json', 0);
        }
        $this->data = json_decode(file_get_contents(App::APP . '/data/'.$file.'.json'), 1);
    }

    public function __destruct() {
        file_put_contents(App::APP . '/data/'.$this->file.'.json', json_encode($this->data));
    }

    private function getId() {
        $id = (int) file_get_contents(App::APP . '/data/'.$this->file.'_id.json');
        $id++;
        file_put_contents(App::APP . '/data/'.$this->file.'_id.json', $id);
        return $id;
    }

    public function create(array $data) : void {
        $data['id'] = $this->getId();
        $this->data[] = $data;
    }

    public function showAll() : array {
        return $this->data;
    }

    public function show(int $personalCode) : array {
        foreach($this->data as $data) {
            if ($data['personalCode'] == $personalCode) {
                return $data;
            }
        }
        return [];
    }

    public function delete(int $personalCode) : void {
        foreach($this->data as $key => $data) {
            if ($data['personalCode'] == $personalCode) {
                unset($this->data[$key]);
                break;
            }
        }
    }

    function update(int $personalCode, array $data) : void {
        foreach($this->data as $key => $value) {
            if ($value['personalCode'] == $personalCode) {
                $this->data[$key] = $data;
                break;
            }
        }
    }



}