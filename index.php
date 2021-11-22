<?php

if(isset($_GET['texto'])){
	$txt = $_GET['texto'];
	$entrada = $_GET['entrada'];
	$salida = $_GET['salida'];
	$txte = explode(" ", $txt);
	$texto = $txte[0];
	$i=0;
	foreach ($txte as $txtf) {
		if ($txte[$i] != $txte[0]) {
			$texto = $texto . "%20" . $txtf;
		}
		$i++;
	}
}

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://google-translate1.p.rapidapi.com/language/translate/v2",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "q=".$texto."&target=".$salida."&source=".$entrada,
	CURLOPT_HTTPHEADER => [
		"accept-encoding: application/gzip",
		"content-type: application/x-www-form-urlencoded",
		"x-rapidapi-host: google-translate1.p.rapidapi.com",
		"x-rapidapi-key: d37ec86316mshce05fbeb65a07bcp101dedjsnd438834cacec"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$json = json_decode($response, true);
	$traduccion = $json['data']['translations'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Traductor de Texto </title>
	<meta charset="utf-8">
	<meta name="viewport"
              content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/cb52b24aa7.js" crossorigin="anonymous"></script>
	<style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                background: url("http://www.solofondos.com/wp-content/uploads/2015/12/Fondos-para-pc.jpg");
                background-size: cover;
                background-attachment: fixed;
            }

            * {
                box-sizing: border-box;
            }

            .contenedor {
                width: 100%;
                padding: 15px;
            }

            .formulario {
                background: #2C3E50;
                margin-top: 150px;
                padding: 3px;
            }

            h1 {
                text-align: center;
                color: #1a2537;
                font-size: 40px;
            }
			h2 {
                text-align: center;
                color: rgb(251, 252, 252);
                font-size: 40px;
            }
			h3 {
                text-align: center;
                color: rgb(251, 252, 252);
                font-size: 30px;
            }

            input[type="text"]{
                font-size: 20px;
                width: 82%;
                padding: 10px;
                border: none;
            }

            .input-contenedor {
                margin-bottom: 15px;
                border: 1px solid #aaa;
            }

            .icon {
                min-width: 50px;
                text-align: center;
                color: #999;
            }

            .button {
                border: none;
                width: 100%;
                color: white;
                font-size: 20px;
                background: #1a2537;
                padding: 15px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .button:hover {
                background: cadetblue;
            }

            p {
                text-align: center;
            }

            .link {
                text-decoration: none;
                color: #1a2537;
                font-weight: 600;
            }

            .link:hover {
                color: cadetblue;
            }

            @media(min-width:768px) {
                .formulario {
                    margin: auto;
                    width: 500px;
                    margin-top: 40px;
                    border-radius: 2%;
                }
            }
        </style>
</head>
<body bgcolor="darkgray">
	<center>
		<div>
			<form class="formulario" action="" method="GET">
				<h2>Traductor</h2>
				<div class="contenedor">
					<div class="input-contenedor">
						<i class="fas fa-language icon"></i>
						<input type="text" name="texto" placeholder="Texto a traducir">
					</div>
					<div class="input-contenedor">
						<i class="fas fa-language icon"></i>
						<input type="text" name="entrada" placeholder="Idioma de entrada">
					</div>
					<div class="input-contenedor">
						<i class="fas fa-language icon"></i>
						<input type="text" name="salida" placeholder="Idioma de salida">
					</div>
					<input type="submit" name="bt" value="Traducir" class="button"><br>
				</div>
			</form>
		</div>
		<hr>
		<form class="formulario" action="" method="GET">
		<?php
			if(isset($response)!=null){
				echo "<h2> Resultado: </h2>";
				echo  "<h3> ".$traduccion[0]['translatedText']."</h3>";
			}
		?>
		</form>
	</center>
</body>
</html>
