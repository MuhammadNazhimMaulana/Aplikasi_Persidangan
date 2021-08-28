<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Pengacara
    $app->get("/lawyers/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_pengacara";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Pengacara" => $result], 200);
    });

    // Get 1 Pengacara
    $app->get("/lawyers/{id_pengacara}", function (Request $request, Response $response, $args) {
        $id_pengacara = $args["id_pengacara"];
        $sql = "SELECT * FROM tbl_pengacara WHERE id_pengacara = :id_pengacara";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_pengacara" => $id_pengacara]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Pengacara" => $result], 200);
    });

    //SEARCH Pengacara
    $app->get("/lawyers/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM tbl_pengacara
            WHERE nama_pengacara LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Pengacara" => $result], 200);
    });


    //POST Pengacara
    $app->post("/lawyers/", function (Request $request, Response $response) {

        $new_lawyer = $request->getParsedBody();

        $sql = "INSERT INTO tbl_pengacara (nama_pengacara) VALUE (:nama_pengacara)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":nama_pengacara" => $new_lawyer["nama_pengacara"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Pengacara", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Pengacara", "data" => "0"], 200);
        }
    });

    //PUT Pengacara
    $app->put("/lawyers/{id_pengacara}", function (Request $request, Response $response, $args) {

        $id_pengacara = $args["id_pengacara"];
        $new_lawyer = $request->getParsedBody();

        $sql = "UPDATE tbl_pengacara SET nama_pengacara = :nama_pengacara WHERE id_pengacara = :id_pengacara";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_pengacara" => $id_pengacara,
            ":nama_pengacara" => $new_lawyer["nama_pengacara"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Pengacara", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Pengacara", "data" => "0"], 200);
        }
    });

    // Delete 1 Pengacara
    $app->delete("/lawyers/{id_pengacara}", function (Request $request, Response $response, $args) {
        $id_pengacara = $args["id_pengacara"];
        $sql = "DELETE FROM tbl_pengacara WHERE id_pengacara = :id_pengacara";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_pengacara" => $id_pengacara
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Pengacara", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Pengacara", "data" => "0"], 200);
        }
    });
};
