<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();


    // Get Saksi
    $app->get("/witness/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_saksi";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Saksi" => $result], 200);
    });

    // Get 1 Saksi
    $app->get("/witness/{id_saksi}", function (Request $request, Response $response, $args) {
        $id_saksi = $args["id_saksi"];
        $sql = "SELECT * FROM tbl_saksi WHERE id_saksi = :id_saksi";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_saksi" => $id_saksi]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Saksi" => $result], 200);
    });


    //SEARCH saksi
    $app->get("/witness/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM tbl_saksi
            WHERE nama_saksi LIKE '%$keyword%' OR pekerjaan_saksi LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Saksi" => $result], 200);
    });

    //POST Saksi
    $app->post("/witness/", function (Request $request, Response $response) {

        $new_witnes = $request->getParsedBody();

        $sql = "INSERT INTO tbl_saksi (nama_saksi, pekerjaan_saksi) VALUE (:nama_saksi, :pekerjaan_saksi)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":nama_saksi" => $new_witnes["nama_saksi"],
            ":pekerjaan_saksi" => $new_witnes["pekerjaan_saksi"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Saksi", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Saksi", "data" => "0"], 200);
        }
    });

    //PUT Saksi
    $app->put("/witness/{id_saksi}", function (Request $request, Response $response, $args) {

        $id_saksi = $args["id_saksi"];
        $new_witnes = $request->getParsedBody();

        $sql = "UPDATE tbl_saksi SET nama_saksi = :nama_saksi, pekerjaan_saksi = :pekerjaan_saksi WHERE id_saksi = :id_saksi";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_saksi" => $id_saksi,
            ":nama_saksi" => $new_witnes["nama_saksi"],
            ":pekerjaan_saksi" => $new_witnes["pekerjaan_saksi"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Saksi", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Saksi", "data" => "0"], 200);
        }
    });

    // Delete 1 Saksi
    $app->delete("/witness/{id_saksi}", function (Request $request, Response $response, $args) {
        $id_saksi = $args["id_saksi"];
        $sql = "DELETE FROM tbl_saksi WHERE id_saksi = :id_saksi";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_saksi" => $id_saksi
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Saksi", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Saksi", "data" => "0"], 200);
        }
    });
};
