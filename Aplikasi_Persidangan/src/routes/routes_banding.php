<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Banding
    $app->get("/counterparts/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_banding";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Banding" => $result], 200);
    });

    // Get 1 Banding
    $app->get("/counterparts/{id_banding}", function (Request $request, Response $response, $args) {
        $id_banding = $args["id_banding"];
        $sql = "SELECT * FROM tbl_banding WHERE id_banding = :id_banding";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_banding" => $id_banding]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Banding" => $result], 200);
    });


    //POST Banding
    $app->post("/counterparts/", function (Request $request, Response $response) {

        $new_judge = $request->getParsedBody();

        $sql = "INSERT INTO tbl_banding (tanggal_banding, ket_banding) VALUE (:tanggal_banding, :ket_banding)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":tanggal_banding" => $new_judge["tanggal_banding"],
            ":ket_banding" => $new_judge["ket_banding"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Banding", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Banding", "data" => "0"], 200);
        }
    });

    //PUT Banding
    $app->put("/counterparts/{id_banding}", function (Request $request, Response $response, $args) {

        $id_banding = $args["id_banding"];
        $new_judge = $request->getParsedBody();

        $sql = "UPDATE tbl_banding SET tanggal_banding = :tanggal_banding, ket_banding = :ket_banding WHERE id_banding = :id_banding";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_banding" => $id_banding,
            ":tanggal_banding" => $new_judge["tanggal_banding"],
            ":ket_banding" => $new_judge["ket_banding"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Banding", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Banding", "data" => "0"], 200);
        }
    });

    // Delete 1 Banding
    $app->delete("/counterparts/{id_banding}", function (Request $request, Response $response, $args) {
        $id_banding = $args["id_banding"];
        $sql = "DELETE FROM tbl_banding WHERE id_banding = :id_banding";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_banding" => $id_banding
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Banding", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Banding", "data" => "0"], 200);
        }
    });
};
