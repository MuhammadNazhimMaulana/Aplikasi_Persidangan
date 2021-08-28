<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get jaksa
    $app->get("/prosecutors/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_jaksa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Jaksa" => $result], 200);
    });

    // Get 1 jaksa
    $app->get("/prosecutors/{id_jaksa}", function (Request $request, Response $response, $args) {
        $id_jaksa = $args["id_jaksa"];
        $sql = "SELECT * FROM tbl_jaksa WHERE id_jaksa = :id_jaksa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_jaksa" => $id_jaksa]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Jaksa" => $result], 200);
    });


    //SEARCH jaksa
    $app->get("/prosecutors/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM tbl_jaksa
            WHERE nama_jaksa LIKE '%$keyword%' OR jabatan_jaksa LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Jaksa" => $result], 200);
    });

    //POST jaksa
    $app->post("/prosecutors/", function (Request $request, Response $response) {

        $new_prosecutor = $request->getParsedBody();

        $sql = "INSERT INTO tbl_jaksa (nama_jaksa, jabatan_jaksa) VALUE (:nama_jaksa, :jabatan_jaksa)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":nama_jaksa" => $new_prosecutor["nama_jaksa"],
            ":jabatan_jaksa" => $new_prosecutor["jabatan_jaksa"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Jaksa", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Jaksa", "data" => "0"], 200);
        }
    });

    //PUT jaksa
    $app->put("/prosecutors/{id_jaksa}", function (Request $request, Response $response, $args) {

        $id_jaksa = $args["id_jaksa"];
        $new_prosecutor = $request->getParsedBody();

        $sql = "UPDATE tbl_jaksa SET nama_jaksa = :nama_jaksa, jabatan_jaksa = :jabatan_jaksa WHERE id_jaksa = :id_jaksa";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_jaksa" => $id_jaksa,
            ":nama_jaksa" => $new_prosecutor["nama_jaksa"],
            ":jabatan_jaksa" => $new_prosecutor["jabatan_jaksa"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Jaksa", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Jaksa", "data" => "0"], 200);
        }
    });

    // Delete 1 jaksa
    $app->delete("/prosecutors/{id_jaksa}", function (Request $request, Response $response, $args) {
        $id_jaksa = $args["id_jaksa"];
        $sql = "DELETE FROM tbl_jaksa WHERE id_jaksa = :id_jaksa";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_jaksa" => $id_jaksa
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Jaksa", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Jaksa", "data" => "0"], 200);
        }
    });
};
