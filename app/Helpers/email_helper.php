<?php

function envoyerEmail($to,$sujet,$message,$from="admin@cvven.com"){
    $email = \Config\Services::email();
    $email->setFrom($from, 'CVVEN');
    $email->setTo($to);
    $email->setSubject($sujet);
    $email->setMessage($message);
    $email->send();
}
