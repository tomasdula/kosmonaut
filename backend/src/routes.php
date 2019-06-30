<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();


    $app->get('/kosmonauti', function (Request $request, Response $response, array $args) {
        date_default_timezone_set('Europe/Prague');

        $now = new DateTime("now");
        $model = new Kosmo($this->db);
        try {
            $data = $model->getAll();
            for ($i = 0; $i < sizeof($data); $i++) {
                $birth = $data[$i]['datum_narozeni'];
                $age = DateTime::createFromFormat('Y-m-d', $birth)->diff($now)->y;
                $data[$i]['vek'] = $age;
            }
            return $response->withJson($data);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            return $response->withStatus(501);
        }
    });

    $app->get('/rows', function (Request $request, Response $response, array $args) {
        $model = new Kosmo($this->db);
        try {
            $data = $model->countRows();
            $data["radku"] = $data["COUNT(*)"];
            unset($data["COUNT(*)"]);
            return $response->withJson($data);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            return $response->withStatus(501);
        }
    });

    $app->get('/kosmonauti/{ofset}', function (Request $request, Response $response, array $args) {
        $inputArgs = $args['ofset'];
        $from = intval($inputArgs);

        date_default_timezone_set('Europe/Prague');

        $now = new DateTime("now");
        $model = new Kosmo($this->db);
        try {
            $data = $model->getAllFrom($from);
            for ($i = 0; $i < sizeof($data); $i++) {
                $birth = $data[$i]['datum_narozeni'];
                $age = DateTime::createFromFormat('Y-m-d', $birth)->diff($now)->y;
                $data[$i]['vek'] = $age;
            }
            return $response->withJson($data);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            return $response->withStatus(501);
        }
    });



    $app->get('/kosmonauti/{sort}/{typ}/{ofset}', function (Request $request, Response $response, array $args) {
        $by = $args['sort'];
        $typ = $args['typ'];
        $inputArgs = $args['ofset'];
        $from = intval($inputArgs);
        if (strtolower($typ) == 'desc' || strtolower($typ) == 'asc') {
            if ($by == 'vek') {
                $by = "datum_narozeni";
            }
            date_default_timezone_set('Europe/Prague');
            $now = new DateTime("now");
            try {
                $model = new Kosmo($this->db);

                $data = $model->getAllSorted($by, $typ, $from);

                for ($i = 0; $i < sizeof($data); $i++) {
                    $birth = $data[$i]['datum_narozeni'];
                    $age = DateTime::createFromFormat('Y-m-d', $birth)->diff($now)->y;
                    $data[$i]['vek'] = $age;
                }
                return $response->withJson($data);
            } catch (Exception $ex) {
                $this->logger->error($ex->getMessage());
                return $response->withStatus(501);
            }
        } else {
            return $response->withStatus(400);
        }
    });

    $app->get('/kosmonaut/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $id = intval($id);
        if ($id != 0) {
            try {
                $model = new Kosmo($this->db);
                $data = $model->getKosmo($id);
                return $response->withJson($data);
            } catch (Exception $ex) {
                $this->logger->error($ex->getMessage());
                return $response->withStatus(501);
            }
        } else {
            return $response->withStatus(400);
        }
    });

    $app->post('/add', function (Request $request, Response $response, array $args) {
        $inputData = $request->getParsedBody();
        $inputData['first'] = strip_tags($inputData['first']);
        $inputData['last'] = strip_tags($inputData['last']);
        $inputData['birth'] = strip_tags($inputData['birth']);
        $inputData['super'] = strip_tags($inputData['super']);
        if (!empty($inputData['first']) && !empty($inputData['last']) &&
                !empty($inputData['birth']) && !empty($inputData['super'])) {
            $model = new Kosmo($this->db);
            date_default_timezone_set('Europe/Prague');
            $now = new DateTime("now");
            $birth = DateTime::createFromFormat("Y-m-d", $inputData['birth']);
            if ($now < $birth) {
                return $response->withStatus(400);
            } else {
                try {
                    $model->addKosmo($inputData);
                    return $response->withStatus(201);
                } catch (Exception $ex) {
                    $this->logger->error($ex->getMessage());
                    return $response->withStatus(501);
                }
            }
        } else {
            return $response->withStatus(400);
        }
    });

    $app->put('/kosmo/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $id = intval($id);
        $inputData = $request->getParsedBody();
        $inputData['first'] = strip_tags($inputData['first']);
        $inputData['last'] = strip_tags($inputData['last']);
        $inputData['birth'] = strip_tags($inputData['birth']);
        $inputData['super'] = strip_tags($inputData['super']);
        if (!empty($inputData['first']) && !empty($inputData['last']) &&
                !empty($inputData['birth']) && !empty($inputData['super']) && ($id != 0)) {
            $model = new Kosmo($this->db);
            date_default_timezone_set('Europe/Prague');
            $now = new DateTime("now");
            $birth = DateTime::createFromFormat("Y-m-d", $inputData['birth']);
            if ($now < $birth) {
                return $response->withStatus(400);
            } else {
                try {
                    $model->updateKosmo($inputData, $id);
                    return $response->withStatus(201);
                } catch (Exception $ex) {
                    $this->logger->error($ex->getMessage());
                    return $response->withStatus(501);
                }
            }
        } else {
            return $response->withStatus(400);
        }
    });



    $app->post('/del', function (Request $request, Response $response, array $args) {
        $inputData = $request->getParsedBody();
        $id = intval($inputData['id'], 10);

        if (($id) != 0) {
            $model = new Kosmo($this->db);
            try {
                $model->delKosmo($id);
                return $response->withStatus(201);
            } catch (Exception $ex) {
                $this->logger->error($ex->getMessage());
                return $response->withStatus(501);
            }
        } else {
            return $response->withStatus(400);
        }
    });


    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
};
