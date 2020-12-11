<?php
//requiring
require("PHPMailer/src/Exception.php");
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//Parameters
$db_conn = null;


session_start();

function connect_db (){
    //global variable
    global $db_conn;
    // Parsing ini file ro retrieve connexion informations
    $db_info = parse_ini_file("database.ini");
    //connexion to database
    $db_conn= pg_connect("host=" .$db_info['servername']
							. " dbname=". $db_info['dbname']
                            . " user=" . $db_info['username_db']
                            . " password=". $db_info['password_db'])
            or die('Connexion failed : ' . pg_last_error());
}

function disconnect_db (){
    global $db_conn;
	// close connexion
	pg_close($db_conn);

}

// function for the mail sending
function smtpMailer($to, $from, $from_name, $subject, $body){
    $mail = new PHPMailer();  // Create new object PHPMailer
    $mail->IsSMTP(); // active SMTP
    $mail->SMTPDebug = 0;  // debogage: 1 = Errors et messages, 2 = messages only
    $mail->SMTPAuth = true;  // Active authentification SMTP
    $mail->SMTPSecure = 'ssl'; // Gmail requires a securise transfert
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'annogenom@gmail.com';
    $mail->Password = 'annotgenome12345';
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if(!$mail->Send()) {
      return 'Mail error: '.$mail->ErrorInfo;
    } else {
      return true;
    }
  }
?>
