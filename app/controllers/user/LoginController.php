<?php

namespace cefet\SyncLab\controllers\user;
use cefet\SyncLab\controllers\Controller;

class LoginController extends Controller {

    public function viewLogin(): void
    {
        $this->view("user/login");
    }


}