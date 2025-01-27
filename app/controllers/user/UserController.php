<?php

namespace cefet\SyncLab\controllers\user;

use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\controllers\Controller;
use Exception;

class UserController extends Controller
{

    /** logout the user
     * @throws Exception
     */
    public function logout(): void
    {
        Session::logout();
        //TODO FIX REDIRECT LOGOUT

    }
}