<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });


    // Get Hakim
    $app->get("/judges/", function (Request $request, Response $response) {
        $sql = "SELECT * FROM tbl_hakim";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data_Hakim" => $result], 200);
    });

    // Get 1 Hakim
    $app->get("/judges/{id_hakim}", function (Request $request, Response $response, $args) {
        $id_hakim = $args["id_hakim"];
        $sql = "SELECT * FROM tbl_hakim WHERE id_hakim = :id_hakim";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_hakim" => $id_hakim]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "Data_Hakim" => $result], 200);
    });


    //SEARCH hakim
    $app->get("/judges/search/", function (Request $request, Response $response, $args) {
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM tbl_hakim
        WHERE nama_hakim LIKE '%$keyword%' OR jabatan_hakim LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "Data_Hakim" => $result], 200);
    });


    //POST Hakim
    $app->post("/judges/", function (Request $request, Response $response) {

        $new_judge = $request->getParsedBody();

        $sql = "INSERT INTO tbl_hakim (nama_hakim, jabatan_hakim) VALUE (:nama_hakim, :jabatan_hakim)";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":nama_hakim" => $new_judge["nama_hakim"],
            ":jabatan_hakim" => $new_judge["jabatan_hakim"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Input Hakim", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Input Hakim", "data" => "0"], 200);
        }
    });

    //PUT Hakim
    $app->put("/judges/{id_hakim}", function (Request $request, Response $response, $args) {

        $id_hakim = $args["id_hakim"];
        $new_judge = $request->getParsedBody();

        $sql = "UPDATE tbl_hakim SET nama_hakim = :nama_hakim, jabatan_hakim = :jabatan_hakim WHERE id_hakim = :id_hakim";

        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_hakim" => $id_hakim,
            ":nama_hakim" => $new_judge["nama_hakim"],
            ":jabatan_hakim" => $new_judge["jabatan_hakim"],
        ];

        if ($stmt->execute($data)) {
            return $response->withJson(["status" => "Sukses Update Hakim", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Update Hakim", "data" => "0"], 200);
        }
    });

    // Delete 1 hakim
    $app->delete("/judges/{id_hakim}", function (Request $request, Response $response, $args) {
        $id_hakim = $args["id_hakim"];
        $sql = "DELETE FROM tbl_hakim WHERE id_hakim = :id_hakim";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_hakim" => $id_hakim
        ];

        if ($stmt->execute($data)) {

            return $response->withJson(["status" => "Sukses Menghapus Hakim", "data" => "1"], 200);
        } else {
            return $response->withJson(["status" => "Gagal Menghapus Hakim", "data" => "0"], 200);
        }
    });
};
