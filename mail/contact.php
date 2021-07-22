<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode([
    "error" => true,
    "message" => "Acontenceu alguma coisa."
  ]);

  die();
}

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($body)) {
  echo json_encode([
    "error" => true,
    "message" => "Por favor, preencha todos os campos."
  ]);

  die();
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  echo json_encode([
    "error" => true,
    "message" => "Digite um e-mail válido."
  ]);

  die();
}

$emailMessage .= "Contato - Irmãos Drywall <br>";
$emailMessage .= "Nome: $name <br>";
$emailMessage .= "E-mail: $email <br>";
$emailMessage .= "Telefone: $phone <br>";
$emailMessage .= "Assunto: $subject <br>";
$emailMessage .= "Mensagem: $body <br>";

$emailHeaders .= "To: contato@irmaosdrywall.com.br\r\n";
$emailHeaders .= "From: noreply@irmaosdrywall.com.br\r\n";
$emailHeaders .= "X-Mailer: PHP/ ${phpversion()}\r\n";
$emailHeaders .= "Content-type: text/html; charset=utf-8";


try {
  mail("contato@irmaosdrywall.com.br", "Contato - Irmãos Drywall", $emailMessage, $emailHeaders);

  echo json_encode([
    "error" => false,
    "message" => "E-mail enviado com sucesso!",
  ]);

  die();
}
catch (\Exception $e) {
  echo json_encode([
    "error" => true,
    "message" => "Error: ${$e->getMessage()}"
  ]);

  die();
}
