<?php
$email_a = '1@jexample.com';
$email_b = 'bogus';

if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
    echo "Esta dirección de correo ($email_a) es válida.";
}
if (filter_var($email_b, FILTER_VALIDATE_EMAIL)) {
    echo "Esta dirección de correo ($email_b) es válida.";
}
?>