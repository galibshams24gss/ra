<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT,DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

$app = new \Slim\App;

//Get all clients
$app->get('/api/clients', function(Request $request, Response $response){
//echo 'CLIENTS';
$sql = "SELECT * FROM clients";
try{
    //get db object
    $db = new db();
    //connect
    $db = $db->connect();
    $stmt = $db->query($sql);
    $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($clients);
}catch(PDOException $e){
    echo '{"error": {"text": '.$e->getMessage().'}';
}
});

//Get a client
$app->get('/api/client/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM clients WHERE id = $id";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $client = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($client);
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    });

    //Add a client
$app->post('/api/client/add', function(Request $request, Response $response){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO clients (first_name,last_name,phone,email,address,city,state) VALUES (:first_name,:last_name,:phone,:email,:address,:city,:state)";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);

        $stmt->execute();
        echo '{"notice":{"text": "Client Added"}';
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    });

    //Update client
$app->put('/api/client/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE clients SET 
    first_name = :first_name,
    last_name = :last_name,
    phone = :phone,
    email = :email,
    address = :address,
    city = :city,
    state = :state 
    WHERE id = $id";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);

        $stmt->execute();
        echo '{"notice":{"text": "Client Updated"}';
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    });

    /*{
        "first_name":"Sunny",
        "last_name":"Karim",
        "phone":"0123456987",
        "email":"sk@gmail.com",
        "address":"45 Johson St",
        "city":"Preston",
        "state":"VIC"
      }*/

    //Delete a client
$app->delete('/api/client/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM clients WHERE id = $id";
    try{
        //get db object
        $db = new db();
        //connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice":{"text": "Client Deleted"}';
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    });