<?php
$servername = "br-cdbr-azure-south-b.cloudapp.net";
$username = "b3e430f8dfef1e";
$password = "95df8e51";
$dbname = "acsm_5fe05832cd7250c";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

mysql_query("SET NAMES 'utf8'");
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['id']))
{
  $id = $_POST['id'];
} 
else 
{
  $id = null;
}

if (isset($_POST['name']))
{
  $name = utf8_encode($_POST['name']);
} 
else 
{
  $name = null;
}

if (isset($_POST['type']))
{
  $type = utf8_encode($_POST['type']);
} 
else 
{
  $type = null;
}

if (isset($_POST['state']))
{
  $state = utf8_encode($_POST['state']);
} 
else 
{
  $state = null;
}

if (isset($_POST['city']))
{
  $city = utf8_encode($_POST['city']);
} 
else 
{
  $city = null;
}

if (isset($_POST['status']))
{
  $status = intval($_POST['status']);
} 
else 
{
  $status = 0;
}


if (!is_null($id))
{
	//verifica se já não existe um produto no banco de dados com o mesmo nome
	$verificaExistencia = "SELECT * FROM events WHERE id = '$id'";
	$sqlverificaExistencia = mysqli_query($conn, $verificaExistencia);
	$rowsn = mysqli_num_rows($sqlverificaExistencia);

	if ($rowsn == 0)  //não existe produto com este nome, faz a inserção
	{
		$insert = "INSERT INTO events (id, name, type, state, city, created, updated, status)
		VALUES ('$id','$name','$type','$state','$city', now(), now(), $status)";
		if (mysqli_query($conn, $insert)) {
		    echo "Evento inserido";
		} else {
		    echo "Error: " . $insert . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
	else
	{
	    echo "J&aacute; existe um evento cadastrado com este nome"; // redireciona pra página de erro
	}
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cadastro de evento</title>
</head>
<body>
	<h1>Inserir Evento</h1>
	<form class="form" method="post" id="form1" action = "<?php $_PHP_SELF ?>">
		<p><input name="id" type="text" placeholder="id do evento" id="id" required="required" /></p>
		<p><input name="name" type="text" placeholder="Nome do evento" id="nome"  /></p>
		<p><input name="type" type="text" placeholder="Tipo do evento" id="type" value="rock"  /></p>
		<p><input name="state" type="text" placeholder="Estado do evento" value="rj" id="estado"  /></p>
		<p><input name="city" type="text" placeholder="Cidade do evento" value="rio-de-janeiro" id="city"  /></p>
		<p>
			Status: 
			<input type="radio" name="status" value="1" checked="checked" />Ativo
			<input type="radio" name="status" value="0" />Inativo
		</p>
	    <input type="submit" value=">" />
    </form>
</body>
</html>