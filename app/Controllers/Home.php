<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function standard()
{
        echo view('header');
        
        echo view('standard');
        echo view('footer');
}

}
