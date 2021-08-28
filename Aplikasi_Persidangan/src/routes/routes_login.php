<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

return function (App $app) {
    $container = $app->getContainer();

    //POST Saksi
    $app->post("/login/", function (Request $request, Response $response) {

        $new_login = $request->getParsedBody();

        $username = trim(strip_tags($new_login['username']));
        $password = trim(strip_tags($new_login['password']));

        $sql = "SELECT id_user, username FROM tbl_user WHERE username = :username AND password = :password";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":username" => $new_login["username"],
            ":password" => $new_login["password"],
        ];

        $stmt->execute($data);

        $user = $stmt->fetchObject();

        if (!$user) {

            return $response->withJson(["status" => "Gagal", "data" => "0"], 200);
        } else {

            $settings = $this->get('settings');
            $token = array(
                'id_user' => $user->id_user,
                'username' => $user->username
            );
            $token = JWT::encode($token, $settings['jwt']['secret'], "HS256");

            return $response->withJson(["status" => "Sukses", "Data" => $user, 'Token' => $token], 200);
        }
    });

    $app->post('/register/', function (Request $request, Response $response, array $args) {
        $input = $request->getParsedBody();
        $username = trim(strip_tags($input['username']));
        $nama_lengkap = trim(strip_tags($input['nama_lengkap']));
        $email = trim(strip_tags($input['email']));
        $password = trim(strip_tags($input['password']));
        $sql = "INSERT INTO tbl_user(username, nama_lengkap, email, password) 
                VALUES(:username, :nama_lengkap, :email, :password)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("username", $username);
        $sth->bindParam("nama_lengkap", $nama_lengkap);
        $sth->bindParam("email", $email);
        $sth->bindParam("password", $password);
        $StatusInsert = $sth->execute();
        if ($StatusInsert) {
            $id_user = $this->db->lastInsertId();
            $settings = $this->get('settings');
            $token = array(
                'id_user' =>  $id_user,
                'username' => $username
            );
            $token = JWT::encode($token, $settings['jwt']['secret'], "HS256");
            $dataUser = array(
                'id_user' => $id_user,
                'username' => $username
            );
            return $response->withJson(['status' => 'Sukses', 'Data_Pengguna' => $dataUser, 'token' => $token]);
        } else {
            return $response->withJson(['status' => 'error', 'Data_Pengguna' => 'error insert user.']);
        }
    });
};
