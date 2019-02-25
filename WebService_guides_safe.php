<?php
  // incluyendo la librería de nusoap
require '/var/www/html/WebService_Guides/info_guides_safe.php';
require_once('/var/www/html/WebService_Guides/nusoap/lib/nusoap.php');
require '/var/www/html/resources/credentials/mysql.php';
$conn = mysql_connect($db_host, $db_name, $db_pass);
if (!$conn){die('Could not connect: Database server is not available');}
$db_selected = mysql_select_db($db_database,$conn);
if (!$db_selected){die ('Unable to use requested DB: Database is not available');}

/*200.85.240.6
  201.131.46.3
  181.48.63.150
 */
 
$ipAcces1='200.85.240.6';
$ipAcces2='201.131.46.3';
$ipAcces3='181.48.63.150';
$ipAcces4='172.16.1.223';
$ipAcces5='10.168.155.227';

$ipAddress = $_SERVER['REMOTE_ADDR'];
$user = $_SERVER['PHP_AUTH_USER'];
$pass = MD5($_SERVER['PHP_AUTH_PW']);


$validation = "SELECT id_user, `user`, `password` FROM `tbl_users_ws` WHERE `name_ws` = 'ws_guides' AND delete_mark=0 LIMIT 1;";
$result_val = mysql_query($validation);
$fila = mysql_fetch_assoc($result_val);
$user = $fila['user'];
$password = $fila['password'];


/*inicio 1*/
/*modificacion insertada con el fin de verificar que sucede con el llamado del php en web y con soapui*/
if($ipAddress==$ipAcces1 || $ipAddress==$ipAcces2 || $ipAddress==$ipAcces3 || $ipAddress==$ipAcces4 || $ipAddress==$ipAcces5){
    $usuarios = array($user => $password);
    $dominio = 'guides';

    if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="'.$dominio.'",qop="auth",nonce="'.uniqid().'",opaque="'.md5($dominio).'"');
        die('Usuario o contraseña incorrectos.');
    }

    // echo $dominio;
    // echo $datos['username'];
    // echo $usuarios[$datos['username']]; //credencial codificada con md5
    // echo $_SERVER['REQUEST_METHOD'];
    // echo $datos['uri'];

    if (!($datos = analizar_http_digest($_SERVER['PHP_AUTH_DIGEST'])) || !isset($usuarios[$datos['username']])){
        die('Credenciales incorrectas.');
    }

    // echo ($datos['username']."\n");
    // echo ($dominio."\n");
    // echo ($usuarios[$datos['username']]); //credencial codificada con md5
    // echo $_SERVER['REQUEST_METHOD'];
    // echo $datos['uri'];
    // $dominio = gruides;
    $A1 = md5($datos['username'] . ':' . $dominio . ':' . $usuarios[$datos['username']]);
    $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$datos['uri']);
    $respuesta_válida = md5($A1.':'.$datos['nonce'].':'.$datos['nc'].':'.$datos['cnonce'].':'.$datos['qop'].':'.$A2);
    if ($datos['response'] != $respuesta_válida){
        die('Credenciales incorrectas .');
    }
}// cierre de ips



function analizar_http_digest($txt)
{
    // Protección contra datos ausentes
    $partes_necesarias = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $datos = array();
    $claves = implode('|', array_keys($partes_necesarias));

    preg_match_all('@(' . $claves . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $coincidencias, PREG_SET_ORDER);

    foreach ($coincidencias as $c) {
        $datos[$c[1]] = $c[3] ? $c[3] : $c[4];
        unset($partes_necesarias[$c[1]]);
    }
    return $partes_necesarias ? false : $datos;
}


if($ipAddress==$ipAcces1 || $ipAddress==$ipAcces2 || $ipAddress==$ipAcces3 || $ipAddress==$ipAcces4 || $ipAddress==$ipAcces5){
if (! $result_val){
		echo "La consulta SQL contiene errores.";
}
else
	{
			
		$arrUsu = mysql_fetch_array($result_val);
		

	$server = new soap_server();
	$server->configureWSDL("guide", "urn:dischargeswsdl");
	$servidor->wsdl->schemaTargetNamespace ="urn:dischargeswsdl";


	//Create a complex type
			$server->wsdl->addComplexType('MyComplexType','complexType','struct','all','',
					array(  'NumeroGuia' => array('name' => 'NumeroGuia','type' => 'xsd:string'),
							'Origen' => array('name' => 'Origen','type' => 'xsd:string'),
							'Destino' => array('name' => 'Destino','type' => 'xsd:string'),
							'LugarExpedicionGuia' => array('name' => 'LugarExpedicionGuia','type' => 'xsd:string'),
							'Producto' => array('name' => 'Producto','type' => 'xsd:string'),
							'EmpresaTransportadora' => array('name' => 'EmpresaTransportadora','type' => 'xsd:string'),
							'DespachadoA' => array('name' => 'DespachadoA','type' => 'xsd:string'),
							'IdConductor' => array('name' => 'IdConductor','type' => 'xsd:string'),
							'NombreConductor' => array('name' => 'NombreConductor','type' => 'xsd:string'),
							'OrdenRemision' => array('name' => 'OrdenRemision','type' => 'xsd:string'),
							'PlacaVehiculo' => array('name' => 'PlacaVehiculo','type' => 'xsd:string'),
							'PlacaRemolque' => array('name' => 'PlacaRemolque','type' => 'xsd:string'),
							'DescripcionProducto' => array('name' => 'DescripcionProducto','type' => 'xsd:string'),
							'ObservacionesGuia' => array('name' => 'ObservacionesGuia','type' => 'xsd:string'),
							'Usuario' => array('name' => 'Usuario','type' => 'xsd:string'),
							'API' => array('name' => 'API','type' => 'xsd:string'),
							'Temperatura' => array('name' => 'Temperatura','type' => 'xsd:string'),
							'BSW' => array('name' => 'BSW','type' => 'xsd:string'),
							'PorcentajeSal' => array('name' => 'PorcentajeSal','type' => 'xsd:string'),
							'Azufre' => array('name' => 'Azufre','type' => 'xsd:string'),
							'BarrilesGOV' => array('name' => 'BarrilesGOV','type' => 'xsd:string'),
							'BarrilesGSV' => array('name' => 'BarrilesGSV','type' => 'xsd:string'),
							'BarrilesNSV' => array('name' => 'BarrilesNSV','type' => 'xsd:string'),
							'TipoVehiculo' => array('name' => 'TipoVehiculo','type' => 'xsd:string'),
							'FechaHoraProgramacion' => array('name' => 'FechaHoraProgramacion','type' => 'xsd:dateTime'),
							'FechaHoraPostulacion' => array('name' => 'FechaHoraPostulacion','type' => 'xsd:dateTime'),
							'FechaHoraCitaCargue' => array('name' => 'FechaHoraCitaCargue','type' => 'xsd:dateTime'),
							'FechaHoraCargue' => array('name' => 'FechaHoraCargue','type' => 'xsd:dateTime'),
							'FechaHoraSalidaCargue' => array('name' => 'FechaHoraSalidaCargue','type' => 'xsd:dateTime'),
							'EstadoGuia' => array('name' => 'EstadoGuia','type' => 'xsd:string'),
							'FechaModificacion' => array('name' => 'FechaModificacion','type' => 'xsd:dateTime')
					)
		);
		
						   
			$server->wsdl->addComplexType(
				'MyComplexTypeArray',
				'complexType',
				'array',
				'',
				'SOAP-ENC:Array',
				array(),
				array(
					array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:MyComplexType[]')
				),
				'tns:MyComplexType'
			);
			
	
	if($ipAddress==$ipAcces1 || $ipAddress==$ipAcces2 || $ipAddress==$ipAcces3 || $ipAddress==$ipAcces4 || $ipAddress==$ipAcces5){	
			
			//Register our method using the complex type

			$server->register(
							// method name:
							'send_info_guides',
							// parameter list:
							array("startDate" => "xsd:dateTime","finishDate" => "xsd:dateTime"),
							// return value(s):
							array('return'=>'tns:MyComplexTypeArray'),
							// namespace:
							"urn:guideswsdl",
							// soapaction: (use default)
							"urn:guideswsdl#send_info_guides",
							// style: rpc or document
							'rpc',
							// use: encoded or literal
							'encoded',
							// description: documentation for the method
							'sin guias');
			 }else{
                 echo $ipAddress;
                }
			$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
			$server->service($HTTP_RAW_POST_DATA);
			exit();




?>