<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    // Get Sidang
    $app->get("/meetings/", function (Request $request, Response $response) {
        $sql = "SELECT 
            a.id_sidang,
            a.id_hakim,
            b.nama_hakim as hakim,
            a.id_penggugat,
            c.nama_penggugat as penggugat,
            a.id_tergugat,
            d.nama_tergugat as tergugat,
            a.id_pengadilan,
            e.nama_pengadilan as pengadilan,
            a.id_saksi,
            f.nama_saksi as saksi,
            a.id_banding,
            g.tanggal_banding as banding,
            a.id_bukti,
            h.nama_bukti as bukti,
            a.id_jaksa,
            i.nama_jaksa as jaksa,
            a.waktu_sidang,
            a.ket_sidang,
            a.keputusan_sidang 
        FROM tbl_sidang a
        JOIN 
            tbl_hakim b ON a.id_hakim = b.id_hakim
        JOIN 
            tbl_penggugat c ON a.id_penggugat = c.id_penggugat
        JOIN 
            tbl_tergugat d ON a.id_tergugat = d.id_tergugat
        JOIN 
            tbl_pengadilan e ON a.id_pengadilan = e.id_pengadilan
        JOIN 
            tbl_saksi f ON a.id_saksi = f.id_saksi
        JOIN 
            tbl_banding g ON a.id_banding = g.id_banding
        JOIN 
            tbl_bukti h ON a.id_bukti = h.id_bukti
        JOIN 
            tbl_jaksa i ON a.id_jaksa = i.id_jaksa
        ORDER BY 
            a.id_sidang ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Sidang" => $result], 200);
    });

    // Get 1 sidang
    $app->get("/meetings/{id_sidang}", function (Request $request, Response $response, $args) {
        $id_sidang = $args["id_sidang"];
        $sql = "SELECT 
            a.id_sidang,
            a.id_hakim,
            b.nama_hakim as hakim,
            a.id_penggugat,
            c.nama_penggugat as penggugat,
            a.id_tergugat,
            d.nama_tergugat as tergugat,
            a.id_pengadilan,
            e.nama_pengadilan as pengadilan,
            a.id_saksi,
            f.nama_saksi as saksi,
            a.id_banding,
            g.tanggal_banding as banding,
            a.id_bukti,
            h.nama_bukti as bukti,
            a.id_jaksa,
            i.nama_jaksa as jaksa,
            a.waktu_sidang,
            a.ket_sidang,
            a.keputusan_sidang 
        FROM tbl_sidang a
        JOIN 
            tbl_hakim b ON a.id_hakim = b.id_hakim
        JOIN 
            tbl_penggugat c ON a.id_penggugat = c.id_penggugat
        JOIN 
            tbl_tergugat d ON a.id_tergugat = d.id_tergugat
        JOIN 
            tbl_pengadilan e ON a.id_pengadilan = e.id_pengadilan
        JOIN 
            tbl_saksi f ON a.id_saksi = f.id_saksi
        JOIN 
            tbl_banding g ON a.id_banding = g.id_banding
        JOIN 
            tbl_bukti h ON a.id_bukti = h.id_bukti
        JOIN 
            tbl_jaksa i ON a.id_jaksa = i.id_jaksa
        WHERE id_sidang = :id_sidang";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_sidang" => $id_sidang]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data Sidang" => $result], 200);
    });

    //SEARCH Persidangan
    $app->get("/meetings/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT 
        a.id_sidang,
        a.id_hakim,
        b.nama_hakim as hakim,
        a.id_penggugat,
        c.nama_penggugat as penggugat,
        a.id_tergugat,
        d.nama_tergugat as tergugat,
        a.id_pengadilan,
        e.nama_pengadilan as pengadilan,
        a.id_saksi,
        f.nama_saksi as saksi,
        a.id_banding,
        g.tanggal_banding as banding,
        a.id_bukti,
        h.nama_bukti as bukti,
        a.id_jaksa,
        i.nama_jaksa as jaksa,
        a.waktu_sidang,
        a.ket_sidang,
        a.keputusan_sidang 
    FROM tbl_sidang a
    JOIN 
        tbl_hakim b ON a.id_hakim = b.id_hakim
    JOIN 
        tbl_penggugat c ON a.id_penggugat = c.id_penggugat
    JOIN 
        tbl_tergugat d ON a.id_tergugat = d.id_tergugat
    JOIN 
        tbl_pengadilan e ON a.id_pengadilan = e.id_pengadilan
    JOIN 
        tbl_saksi f ON a.id_saksi = f.id_saksi
    JOIN 
        tbl_banding g ON a.id_banding = g.id_banding
    JOIN 
        tbl_bukti h ON a.id_bukti = h.id_bukti
    JOIN 
        tbl_jaksa i ON a.id_jaksa = i.id_jaksa
    WHERE waktu_sidang LIKE '%$keyword%' OR ket_sidang LIKE '%$keyword%' OR keputusan_sidang LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data Sidang" => $result], 200);
    });


    //POST Sidang
    $app->post("/meetings/", function (Request $request, Response $response) {

        $new_sidang = $request->getParsedBody();

        $sql = "INSERT INTO tbl_sidang (id_hakim, id_penggugat, id_tergugat, id_pengadilan, id_saksi, id_banding, id_bukti, id_jaksa, waktu_sidang, ket_sidang, keputusan_sidang) VALUE (:id_hakim, :id_penggugat, :id_tergugat, :id_pengadilan, :id_saksi, :id_banding, :id_bukti, :id_jaksa, :waktu_sidang, :ket_sidang, :keputusan_sidang)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_hakim" => $new_sidang["id_hakim"],
            ":id_penggugat" => $new_sidang["id_penggugat"],
            ":id_tergugat" => $new_sidang["id_tergugat"],
            ":id_pengadilan" => $new_sidang["id_pengadilan"],
            ":id_saksi" => $new_sidang["id_saksi"],
            ":id_banding" => $new_sidang["id_banding"],
            ":id_bukti" => $new_sidang["id_bukti"],
            ":id_jaksa" => $new_sidang["id_jaksa"],
            ":waktu_sidang" => $new_sidang["waktu_sidang"],
            ":ket_sidang" => $new_sidang["ket_sidang"],
            ":keputusan_sidang" => $new_sidang["keputusan_sidang"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Sidang", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Sidang", "data" => "0"], 200);
        }
    });

    //PUT Sidang
    $app->put("/meetings/{id_sidang}", function (Request $request, Response $response, $args) {

        $id_sidang = $args["id_sidang"];
        $new_sidang = $request->getParsedBody();

        $sql = "UPDATE tbl_sidang SET id_hakim = :id_hakim, id_penggugat = :id_penggugat, id_tergugat = :id_tergugat, id_pengadilan = :id_pengadilan, id_saksi = :id_saksi, id_banding= :id_banding, id_bukti = :id_bukti, id_jaksa = :id_jaksa, waktu_sidang = :waktu_sidang, ket_sidang = :ket_sidang, keputusan_sidang = :keputusan_sidang WHERE id_sidang = :id_sidang";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_sidang" => $id_sidang,
            ":id_hakim" => $new_sidang["id_hakim"],
            ":id_penggugat" => $new_sidang["id_penggugat"],
            ":id_tergugat" => $new_sidang["id_tergugat"],
            ":id_pengadilan" => $new_sidang["id_pengadilan"],
            ":id_saksi" => $new_sidang["id_saksi"],
            ":id_banding" => $new_sidang["id_banding"],
            ":id_bukti" => $new_sidang["id_bukti"],
            ":id_jaksa" => $new_sidang["id_jaksa"],
            ":waktu_sidang" => $new_sidang["waktu_sidang"],
            ":ket_sidang" => $new_sidang["ket_sidang"],
            ":keputusan_sidang" => $new_sidang["keputusan_sidang"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Sidang", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Sidang", "data" => "0"], 200);
        }
    });

    // Delete 1 Sidang
    $app->delete("/meetings/{id_sidang}", function (Request $request, Response $response, $args) {
        $id_sidang = $args["id_sidang"];
        $sql = "DELETE FROM tbl_sidang WHERE id_sidang = :id_sidang";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_sidang" => $id_sidang
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Sidang", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Sidang", "data" => "0"], 200);
        }
    });
};
