<?php
namespace  App\Module;

class user {

    public function getUserinfo($userid) {

        return ['userid'=>$userid, 'username'=>'jelly'];
    }

}


class Jifen {

    public function getUserJifen($userid) {


        return ['userid'=>$userid, 'jifen'=>100];
    }
}

