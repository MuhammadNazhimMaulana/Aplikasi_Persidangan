<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Tergugat
    $app->get("/cases/", function (Request $request, Response $response) {
        $sql = "SELECT 
            a.id_kasus,
            a.id_penggugat,
            b.nama_penggugat as penggugat,
            a.id_tergugat,
            c.nama_tergugat as tergugat,
            a.id_bukti,
            d.nama_bukti as bukti,
            a.gugatan,
            a.keterangan 
        FROM tbl_kasus a
        JOIN 
            tbl_penggugat b ON a.id_penggugat = b.id_penggugat
        JOIN 
            tbl_tergugat c ON a.id_tergugat = c.id_tergugat
        JOIN 
            tbl_bukti d ON a.id_bukti = d.id_bukti
        ORDER BY 
            a.id_kasus ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Tergugat" => $result], 200);
    });

    // Get 1 Kasus
    $app->get("/cases/{id_kasus}", function (Request $request, Response $response, $args) {
        $id_kasus = $args["id_kasus"];
        $sql = "SELECT 
            a.id_kasus,
            a.id_penggugat,
            b.nama_penggugat as penggugat,
            a.id_tergugat,
            c.nama_tergugat as tergugat,
            a.id_bukti,
            d.nama_bukti as bukti,
            a.gugatan,
            a.keterangan 
        FROM tbl_kasus a
        JOIN 
            tbl_penggugat b ON a.id_penggugat = b.id_penggugat
        JOIN 
            tbl_tergugat c ON a.id_tergugat = c.id_tergugat
        JOIN 
            tbl_bukti d ON a.id_bukti = d.id_bukti
        WHERE id_kasus = :id_kasus";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_kasus" => $id_kasus]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Kasus" => $result], 200);
    });

    //SEARCH Kasus
    $app->get("/cases/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT 
        a.id_kasus,
        a.id_penggugat,
        b.nama_penggugat as penggugat,
        a.id_tergugat,
        c.nama_tergugat as tergugat,
        a.id_bukti,
        d.nama_bukti as bukti,
        a.gugatan,
        a.keterangan 
    FROM tbl_kasus a
    JOIN 
        tbl_penggugat b ON a.id_penggugat = b.id_penggugat
    JOIN 
        tbl_tergugat c ON a.id_tergugat = c.id_tergugat
    JOIN 
        tbl_bukti d ON a.id_bukti = d.id_bukti
    WHERE gugatan LIKE '%$keyword%' OR keterangan LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Kasus" => $result], 200);
    });


    //POST Kasus
    $app->post("/cases/", function (Request $request, Response $response) {

        $new_case = $request->getParsedBody();

        $sql = "INSERT INTO tbl_kasus (id_penggugat, id_tergugat, id_bukti, gugatan, keterangan) VALUE (:id_penggugat, :id_tergugat, :id_bukti, :gugatan, :keterangan)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_penggugat" => $new_case["id_penggugat"],
            ":id_tergugat" => $new_case["id_tergugat"],
            ":id_bukti" => $new_case["id_bukti"],
            ":gugatan" => $new_case["gugatan"],
            ":keterangan" => $new_case["keterangan"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Kasus", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Kasus", "data" => "0"], 200);
        }
    });

    //PUT Kasus
    $app->put("/cases/{id_kasus}", function (Request $request, Response $response, $args) {

        $id_kasus = $args["id_kasus"];
        $new_case = $request->getParsedBody();

        $sql = "UPDATE tbl_kasus SET id_penggugat = :id_penggugat, id_tergugat = :id_tergugat, id_bukti = :id_bukti, gugatan = :gugatan, keterangan= :keterangan WHERE id_kasus = :id_kasus";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_kasus" => $id_kasus,
            ":id_penggugat" => $new_case["id_penggugat"],
            ":id_tergugat" => $new_case["id_tergugat"],
            ":id_bukti" => $new_case["id_bukti"],
            ":gugatan" => $new_case["gugatan"],
            ":keterangan" => $new_case["keterangan"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Kasus", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Kasus", "data" => "0"], 200);
        }
    });

    // Delete 1 Kasus
    $app->delete("/cases/{id_kasus}", function (Request $request, Response $response, $args) {
        $id_kasus = $args["id_kasus"];
        $sql = "DELETE FROM tbl_kasus WHERE id_kasus = :id_kasus";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_kasus" => $id_kasus
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Kasus", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Kasus", "data" => "0"], 200);
        }
    });
};
