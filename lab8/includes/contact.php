<?php

$adminEmail = 'admin@twojadomena.com';
$adminHaslo = 'przykladowe_haslo_123';

function WyslijMailKontakt($odbiorca) {

    if (empty($_POST['temat']) || empty($_POST['wiadomosc']) || empty($_POST['email'])) {
        return false;
    }

    $mail['subject'] = $_POST['temat'];
    $mail['body'] = $_POST['wiadomosc'];
    $mail['sender'] = $_POST['email'];
    $mail['recipient'] = $odbiorca;

    $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
    $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
    $header .= "X-Sender: <".$mail['sender'].">\n";
    $header .= "X-Mailer: PRapWWW mail 1.2\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <".$mail['sender'].">\n";

    mail($mail['recipient'], $mail['subject'], $mail['body'], $header);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wyslij_kontakt'])) {
    WyslijMailKontakt($adminEmail);
}
?>