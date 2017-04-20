<?php
$servername = "50.62.209.160";
$username = "philvsf";
$password = "i0riip12";
$dbname = "la";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
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
  $name = $_POST['name'];
} 
else 
{
  $name = null;
}

if (isset($_POST['type']))
{
  $type = $_POST['type'];
} 
else 
{
  $type = null;
}

if (isset($_POST['state']))
{
  $state = $_POST['state'];
} 
else 
{
  $state = null;
}

if (isset($_POST['city']))
{
  $city = $_POST['city'];
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


<html>
<head>
	<title>Cadastro de evento</title>
</head>
<body>
	<h1>Inserir Evento</h1>
	<form class="form" method="post" id="form1" action = "<?php $_PHP_SELF ?>">
		<p><input name="id" type="text" placeholder="id do evento" id="id" required="required" /></p>
		<p><input name="name" type="text" placeholder="Nome do evento" id="nome"  /></p>
		<p><input name="type" type="text" placeholder="Tipo do evento" id="type"  /></p>
		<p><input name="state" type="text" placeholder="Estado do evento" value="rj" id="estado"  /></p>
		<p><input name="city" type="text" placeholder="Cidade do evento" value="rio de janeiro" id="city"  /></p>
		<p>
			Status: 
			<input type="radio" name="status" value="1" checked="checked" />Ativo
			<input type="radio" name="status" value="0" />Inativo
		</p>
	    <input type="submit" value=">" />
    </form>
</body>
</html>