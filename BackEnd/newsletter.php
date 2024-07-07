<?php

require 'vendor/autoload.php';

function sendNewsletter($subject, $body) {

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'schoolpea@outlook.fr'; 
    $mail->Password = 'BienvenueEnLangageCLuffyNikaAroufGangstaXavierDupontDeLigones.exe'; // Mot de passe
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

  
    $mail->setFrom('schoolpea@outlook.fr', 'SchoolPea');

 
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    
    if($mail->send()) {
       
        try {
           
            $conn = new PDO("mysql:host=localhost;dbname=PA", "root", "root");
          
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
            $sql = "INSERT INTO newsletter_history (subject, body, sent_at) VALUES (:subject, :body, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':body', $body);
            $stmt->execute();


            return true;
        } catch(PDOException $e) {
            
            echo "Error: " . $e->getMessage();


            return false;
        }
    } else {
        return false;
    }
}


$subject = "Tu commences a nous manqué";
$body = "stp reviens tu commences a nous manqué ";
if(sendNewsletter($subject, $body)) {
    echo 'Newsletter envoyée avec succès';
} else {
    echo 'Erreur lors de l\'envoi de la newsletter';
}

?>
