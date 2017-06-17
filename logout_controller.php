<?php

require_once './conf/setting.php';
require_once './model/functions.php';
require_once './model/logout_model.php';

$css = './css/logout.css';

if(check_session() === true){
    logout();
}

redirect_login();
