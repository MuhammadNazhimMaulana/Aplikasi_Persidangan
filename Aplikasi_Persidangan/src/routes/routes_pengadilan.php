<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Pengadilan
    $app->get("/courts/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_pengadilan";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Pengadilan" => $result], 200);
    });

    // Get 1 Pengadilan
    $app->get("/courts/{id_pengadilan}", function (Request $request, Response $response, $args) {
        $id_pengadilan = $args["id_pengadilan"];
        $sql = "SELECT * FROM tbl_pengadilan WHERE id_pengadilan = :id_pengadilan";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_pengadilan" => $id_pengadilan]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Pengadilan" => $result], 200);
    });


    //SEARCH Pengadilan
    $app->get("/courts/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM tbl_pengadilan
                WHERE nama_pengadilan LIKE '%$keyword%' OR kota_pengadilan LIKE '%$keyword%' OR alamat_pengadilan LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Pengadilan" => $result], 200);
    });


    //POST Pengadilan
    $app->post("/courts/", function (Request $request, Response $response) {

        $new_court = $request->getParsedBody();

        $sql = "INSERT INTO tbl_pengadilan (nama_pengadilan, kota_pengadilan, alamat_pengadilan) VALUE (:nama_pengadilan, :kota_pengadilan, :alamat_pengadilan)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":nama_pengadilan" => $new_court["nama_pengadilan"],
            ":kota_pengadilan" => $new_court["kota_pengadilan"],
            ":alamat_pengadilan" => $new_court["alamat_pengadilan"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Pengadilan", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Pengadilan", "data" => "0"], 200);
        }
    });

    //PUT Pengadilan
    $app->put("/courts/{id_pengadilan}", function (Request $request, Response $response, $args) {

        $id_pengadilan = $args["id_pengadilan"];
        $new_court = $request->getParsedBody();

        $sql = "UPDATE tbl_pengadilan SET nama_pengadilan = :nama_pengadilan, kota_pengadilan = :kota_pengadilan, alamat_pengadilan = :alamat_pengadilan WHERE id_pengadilan = :id_pengadilan";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_pengadilan" => $id_pengadilan,
            ":nama_pengadilan" => $new_court["nama_pengadilan"],
            ":kota_pengadilan" => $new_court["kota_pengadilan"],
            ":alamat_pengadilan" => $new_court["alamat_pengadilan"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Pengadilan", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Pengadilan", "data" => "0"], 200);
        }
    });

    // Delete 1 Pengadilan
    $app->delete("/courts/{id_pengadilan}", function (Request $request, Response $response, $args) {
        $id_pengadilan = $args["id_pengadilan"];
        $sql = "DELETE FROM tbl_pengadilan WHERE id_pengadilan = :id_pengadilan";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_pengadilan" => $id_pengadilan
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Pengadilan", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Pengadilan", "data" => "0"], 200);
        }
    });
};
