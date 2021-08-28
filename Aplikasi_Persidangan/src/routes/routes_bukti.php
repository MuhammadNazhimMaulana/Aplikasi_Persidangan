<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Bukti
    $app->get("/proofs/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_bukti";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Bukti" => $result], 200);
    });

    // Get 1 Bukti
    $app->get("/proofs/{id_bukti}", function (Request $request, Response $response, $args) {
        $id_bukti = $args["id_bukti"];
        $sql = "SELECT * FROM tbl_bukti WHERE id_bukti = :id_bukti";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_bukti" => $id_bukti]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Bukti" => $result], 200);
    });


    //SEARCH Bukti
    $app->get("/proofs/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM tbl_bukti
            WHERE nama_bukti LIKE '%$keyword%' OR tanggal_penemuan LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Bukti" => $result], 200);
    });

    //POST Bukti
    $app->post("/proofs/", function (Request $request, Response $response) {

        $new_judge = $request->getParsedBody();

        $sql = "INSERT INTO tbl_bukti (nama_bukti, tanggal_penemuan) VALUE (:nama_bukti, :tanggal_penemuan)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":nama_bukti" => $new_judge["nama_bukti"],
            ":tanggal_penemuan" => $new_judge["tanggal_penemuan"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Bukti", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Bukti", "data" => "0"], 200);
        }
    });

    //PUT Bukti
    $app->put("/proofs/{id_bukti}", function (Request $request, Response $response, $args) {

        $id_bukti = $args["id_bukti"];
        $new_judge = $request->getParsedBody();

        $sql = "UPDATE tbl_bukti SET nama_bukti = :nama_bukti, tanggal_penemuan = :tanggal_penemuan WHERE id_bukti = :id_bukti";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_bukti" => $id_bukti,
            ":nama_bukti" => $new_judge["nama_bukti"],
            ":tanggal_penemuan" => $new_judge["tanggal_penemuan"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Bukti", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Bukti", "data" => "0"], 200);
        }
    });

    // Delete 1 Bukti
    $app->delete("/proofs/{id_bukti}", function (Request $request, Response $response, $args) {
        $id_bukti = $args["id_bukti"];
        $sql = "DELETE FROM tbl_bukti WHERE id_bukti = :id_bukti";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_bukti" => $id_bukti
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Bukti", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Bukti", "data" => "0"], 200);
        }
    });
};
