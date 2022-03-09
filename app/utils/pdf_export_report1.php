<?php

	//$url = $_GET["url"];
	//$fileName = $_GET["fileName"];
	
	//ob_start();
	//include "../pages/reports/print_report1.php";
	//$html = ob_get_clean();
	//ob_end_clean();
	
	
	
	
	// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
	require_once('../libs/dompdf/dompdf_config.inc.php');
	
	$dompdf = new DOMPDF();
	//$dompdf->setOption('isPhpEnabled', true);

$html = <<<'ENDHTML'
<html>
 <body>
  <h1>Hello Dompdf</h1>
 </body>
</html>
ENDHTML;

//this will be something like: http://www.yourapp.com/templates/log.php
//$fileUrl = "http://localhost:8080/hidrotecnica/pages/reports/print_report1.php";

//get file content after the script is server-side interpreted
//$fileContent = file_get_contents( $fileUrl ) ;

//$dompdf->load_html($html);
$html = file_get_contents("http://localhost:8080/hidrotecnica/pages/reports/print_report1.php?format=pdf&data=ZGF0YTM=");
//$html = get_remote_data('http://localhost:8080/hidrotecnica/pages/reports/print_report1.php?format=pdf&data=ZGF0YTM='); // GET request 

$dompdf->load_html($html);
//$dompdf->load_html(DOMDocument::loadHTMLFile ("../index.php"));
//$dompdf->load_html_file("../pages/reports/print_report1.php");
$dompdf->render();

$dompdf->stream("hello.pdf");