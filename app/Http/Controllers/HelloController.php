<?php

namespace App\Http\Controllers;

class HelloController extends Controller {

    public function hello($id=10) {
        return $id;
        
    }
    public function hellos( Request $requst) {
        $requst->get();
        return $id;
        
    }

}
