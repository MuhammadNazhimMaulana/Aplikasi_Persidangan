<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Tergugat
    $app->get("/defendants/", function (Request $request, Response $response) {
        $sql = "SELECT 
            a.id_tergugat,
            a.id_pengacara,
            b.nama_pengacara as pengacara,
            a.nama_tergugat,
            a.pekerjaan_tergugat,
            a.umur_tergugat 
        FROM tbl_tergugat a
        JOIN 
            tbl_pengacara b ON a.id_pengacara = b.id_pengacara
        ORDER BY 
            a.id_pengacara ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Tergugat" => $result], 200);
    });

    // Get 1 Tergugat
    $app->get("/defendants/{id_tergugat}", function (Request $request, Response $response, $args) {
        $id_tergugat = $args["id_tergugat"];
        $sql = "SELECT 
            a.id_tergugat,
            a.id_pengacara,
            b.nama_pengacara as pengacara,
            a.nama_tergugat,
            a.pekerjaan_tergugat,
            a.umur_tergugat 
        FROM tbl_tergugat a
        JOIN 
            tbl_pengacara b ON a.id_pengacara = b.id_pengacara
        WHERE id_tergugat = :id_tergugat";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_tergugat" => $id_tergugat]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Tergugat" => $result], 200);
    });

    //SEARCH Tergugat
    $app->get("/defendants/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT 
        a.id_tergugat,
        a.id_pengacara,
        b.nama_pengacara as pengacara,
        a.nama_tergugat,
        a.pekerjaan_tergugat,
        a.umur_tergugat 
    FROM tbl_tergugat a
    JOIN 
        tbl_pengacara b ON a.id_pengacara = b.id_pengacara
    WHERE nama_tergugat LIKE '%$keyword%' OR pekerjaan_tergugat LIKE '%$keyword%' OR umur_tergugat LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Tergugat" => $result], 200);
    });


    //POST Tergugat
    $app->post("/defendants/", function (Request $request, Response $response) {

        $new_defendant = $request->getParsedBody();

        $sql = "INSERT INTO tbl_tergugat (id_pengacara, nama_tergugat, pekerjaan_tergugat, umur_tergugat) VALUE (:id_pengacara, :nama_tergugat, :pekerjaan_tergugat, :umur_tergugat)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_pengacara" => $new_defendant["id_pengacara"],
            ":nama_tergugat" => $new_defendant["nama_tergugat"],
            ":pekerjaan_tergugat" => $new_defendant["pekerjaan_tergugat"],
            ":umur_tergugat" => $new_defendant["umur_tergugat"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Tergugat", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Tergugat", "data" => "0"], 200);
        }
    });

    //PUT Tergugat
    $app->put("/defendants/{id_tergugat}", function (Request $request, Response $response, $args) {

        $id_tergugat = $args["id_tergugat"];
        $new_defendant = $request->getParsedBody();

        $sql = "UPDATE tbl_tergugat SET id_pengacara = :id_pengacara, nama_tergugat = :nama_tergugat, pekerjaan_tergugat = :pekerjaan_tergugat, umur_tergugat = :umur_tergugat WHERE id_tergugat = :id_tergugat";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_tergugat" => $id_tergugat,
            ":id_pengacara" => $new_defendant["id_pengacara"],
            ":nama_tergugat" => $new_defendant["nama_tergugat"],
            ":pekerjaan_tergugat" => $new_defendant["pekerjaan_tergugat"],
            ":umur_tergugat" => $new_defendant["umur_tergugat"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Tergugat", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Tergugat", "data" => "0"], 200);
        }
    });

    // Delete 1 Tergugat
    $app->delete("/defendants/{id_tergugat}", function (Request $request, Response $response, $args) {
        $id_tergugat = $args["id_tergugat"];
        $sql = "DELETE FROM tbl_tergugat WHERE id_tergugat = :id_tergugat";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_tergugat" => $id_tergugat
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Tergugat", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Tergugat", "data" => "0"], 200);
        }
    });
};
