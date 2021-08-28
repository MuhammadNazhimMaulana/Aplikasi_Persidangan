<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Penggugat
    $app->get("/litigants/", function (Request $request, Response $response) {
        $sql = "SELECT 
            a.id_penggugat,
            a.id_pengacara,
            b.nama_pengacara as pengacara,
            a.nama_penggugat,
            a.pekerjaan_penggugat,
            a.umur_penggugat     
            FROM tbl_penggugat a
         JOIN 
            tbl_pengacara b ON a.id_pengacara = b.id_pengacara
        ORDER BY 
            a.id_pengacara ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Penggugat" => $result], 200);
    });

    // Get 1 Penggugat
    $app->get("/litigants/{id_penggugat}", function (Request $request, Response $response, $args) {
        $id_penggugat = $args["id_penggugat"];
        $sql = "SELECT 
        a.id_penggugat,
        a.id_pengacara,
        b.nama_pengacara as pengacara,
        a.nama_penggugat,
        a.pekerjaan_penggugat,
        a.umur_penggugat     
        FROM tbl_penggugat a
     JOIN 
        tbl_pengacara b ON a.id_pengacara = b.id_pengacara
    WHERE 
        id_penggugat = :id_penggugat";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_penggugat" => $id_penggugat]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Penggugat" => $result], 200);
    });


    //SEARCH Penggugat
    $app->get("/litigants/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT 
        a.id_penggugat,
        a.id_pengacara,
        b.nama_pengacara as pengacara,
        a.nama_penggugat,
        a.pekerjaan_penggugat,
        a.umur_penggugat     
        FROM tbl_penggugat a
     JOIN 
        tbl_pengacara b ON a.id_pengacara = b.id_pengacara
    WHERE nama_penggugat LIKE '%$keyword%' OR pekerjaan_penggugat LIKE '%$keyword%' OR umur_penggugat LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Penggugat" => $result], 200);
    });


    //POST Penggugat
    $app->post("/litigants/", function (Request $request, Response $response) {

        $new_litigant = $request->getParsedBody();

        $sql = "INSERT INTO tbl_penggugat (id_pengacara, nama_penggugat, pekerjaan_penggugat, umur_penggugat) VALUE (:id_pengacara, :nama_penggugat, :pekerjaan_penggugat, :umur_penggugat)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_pengacara" => $new_litigant["id_pengacara"],
            ":nama_penggugat" => $new_litigant["nama_penggugat"],
            ":pekerjaan_penggugat" => $new_litigant["pekerjaan_penggugat"],
            ":umur_penggugat" => $new_litigant["umur_penggugat"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Penggugat", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Penggugat", "data" => "0"], 200);
        }
    });

    //PUT Penggugat
    $app->put("/litigants/{id_penggugat}", function (Request $request, Response $response, $args) {

        $id_penggugat = $args["id_penggugat"];
        $new_litigant = $request->getParsedBody();

        $sql = "UPDATE tbl_penggugat SET id_pengacara = :id_pengacara, nama_penggugat = :nama_penggugat, pekerjaan_penggugat = :pekerjaan_penggugat, umur_penggugat = :umur_penggugat WHERE id_penggugat = :id_penggugat";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_penggugat" => $id_penggugat,
            ":id_pengacara" => $new_litigant["id_pengacara"],
            ":nama_penggugat" => $new_litigant["nama_penggugat"],
            ":pekerjaan_penggugat" => $new_litigant["pekerjaan_penggugat"],
            ":umur_penggugat" => $new_litigant["umur_penggugat"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Penggugat", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Penggugat", "data" => "0"], 200);
        }
    });

    // Delete 1 Penggugat
    $app->delete("/litigants/{id_penggugat}", function (Request $request, Response $response, $args) {
        $id_penggugat = $args["id_penggugat"];
        $sql = "DELETE FROM tbl_penggugat WHERE id_penggugat = :id_penggugat";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_penggugat" => $id_penggugat
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Penggugat", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Penggugat", "data" => "0"], 200);
        }
    });
};
