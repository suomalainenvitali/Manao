<?php
    namespace App\Api\User;

    use Exception;
    use App\Model\User;
    use App\Setting;

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

    include_once  $_SERVER['DOCUMENT_ROOT'] . '/app/model/user.php';
    include_once  $_SERVER['DOCUMENT_ROOT'] . '/app/setting.php';

    if (!Setting::isAjax()) {
        die();
    }

    try {
        $data = json_decode(file_get_contents('php://input'));

        $user = new User();
        $user->setLogin($data->login);
        $user->setPassword($data->password);
        $user->setEmail($data->email);
        $user->setName($data->name);

        $result = $user->register();

        echo json_encode (
            array (
                "status" => "SUCCESS",
                "count" => count($result),
                "data" => $result,
                "error" => null
            )
        );
    } catch (Exception $ex) {
        echo json_encode (
            array (
                "status" => "FAILED",
                "count" => null,
                "data" => null,
                "error" => $ex->getMessage()
            )
        );
    }
?>