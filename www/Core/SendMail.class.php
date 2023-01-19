<?php

namespace App\Core;
use App\Vendor\PHPMailer\PHPMailer;
use App\Vendor\PHPMailer\SMTP;
use App\Vendor\PHPMailer\Exception;

class SendMail{
    public function __construct(string $email, string $subject, string $html, string $succes, string $fail){
            $mail = new PHPMailer();
            try {
                $mail->SMTPDebug = 0;                      
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.outlook.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'rattrapage.esgi@outlook.fr';                     
                $mail->Password   = 'z6Phig8#Y!zNtY?B';
                $mail->SMTPSecure = 'STARTTLS';                                       
                $mail->Port       = 587;              
            
                $mail->From = "rattrapage.esgi@outlook.fr";
                $mail->FromName = "Rattrapage";
                $mail->addAddress($email);  

                $mail->isHTML(true);                   
                $mail->Subject = $subject;
                $mail->Body    = $html;
                $mail->send();
                echo $succes;
            } catch (Exception $th) {
                echo $fail;
            }
        }
    }