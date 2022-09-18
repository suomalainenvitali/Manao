<?php
    namespace App\Api\User;

    use Exception;
    use App\Model\User;
    use App\Setting;

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

    include_once  $_SERVER['DOCUMENT_ROOT'] . '/app/model/user.php';
    include_once  $_SERVER['DOCUMENT_ROOT'] . '/app/setting.php';

    if (!Setting::isAjax()) {
        die();
    }

    try {
        $login = isset($_GET['login']) ? $_GET['login'] : die();
        $password = isset($_GET['password']) ? $_GET['password'] : die();

        $user = new User();
        $user->setLogin($login);
        $user->setPassword($password);
        $result = $user->login();

        echo json_encode (
            array (
                "status" => "SUCCESS",
                "data" => $result,
                "error" => null
            )
        );
    } catch (Exception $ex) {
        echo json_encode (
            array (
                "status" => "FAILED",
                "data" => null,
                "error" => $ex->getMessage()
            )
        );
    } 
?>