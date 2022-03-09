<?php
header('Content-type: application/json');

include_once("../utils/user_utils.php");

$usuario = $_SERVER['PHP_AUTH_USER'];
$contrasenia = $_SERVER['PHP_AUTH_PW'];

//echo "<br> user: " . $usuario;
//echo "<br> pass: " . $contrasenia;

//$jsondata = file_get_contents("php://input") . "";
//$json = json_decode($jsondata);

//$usuario = $json->usuario;
//$contrasenia = $json->contrasenia;
$institucion = "sanagustin";

include_once("../controller/medoo_users.php");
$user = validateUser($usuario, $contrasenia);
if($user == null || !isset($_SERVER['PHP_AUTH_USER'])) {
  $response["codigo"] = 0;
  $response["mensaje"] = "Datos incorrectos";
  echo json_encode($response, JSON_PRETTY_PRINT);
  return;
}

include_once("../controller/medoo_initiatives.php");
include_once("../controller/medoo_invi.php");

// ALGOTIRMO ODS
include_once("../controller/medoo_measures.php");
include_once("../controller/medoo_initiatives_ods.php");

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * FROM posts where id=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      //header("HTTP/1.1 200 OK");
      //echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  } else {
      $output = array();
      $datas = getVisibleInitiativesByInstitutionFull($institucion);
      for ($i=0; $i < sizeof($datas); $i++) {
        unset($datas[$i]["as_carrera"]);
        unset($datas[$i]["as_seccion"]);
        unset($datas[$i]["as_codigo_modulo"]);
        unset($datas[$i]["as_docente"]);
        unset($datas[$i]["id_programa"]);


        $invi = calculateInviByInitiative($datas[0]['id']);
        $datas[$i]["invi"] = $invi;

        $myObjetives = getODSByInitiative($datas[0]['id']);
        for ($j=0; $j < sizeof($myObjetives); $j++) {
          unset($myObjetives[$j][0]);
          unset($myObjetives[$j][1]);
          unset($myObjetives[$j][2]);
        }
        $datas[$i]["ods"] = $myObjetives;
      }
      //header("HTTP/1.1 200 OK");
      //echo sizeof($datas) . " iniciativas <br>";
      echo json_encode($datas, JSON_PRETTY_PRINT);
      exit();
	}
}
/* Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO posts
          (title, status, content, user_id)
          VALUES
          (:title, :status, :content, :user_id)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}*/

/* Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$id = $_GET['id'];
  $statement = $dbConn->prepare("DELETE FROM posts where id=:id");
  $statement->bindValue(':id', $id);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}*/


/* Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postId = $input['id'];
    $fields = getParams($input);
    $sql = "
          UPDATE posts
          SET $fields
          WHERE id='$postId'
           ";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
} */
//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
?>
