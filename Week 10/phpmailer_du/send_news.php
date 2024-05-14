<?php
require_once '08-phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST['email'] ?? ''; // Získání e-mailu z formuláře

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die('Neplatná e-mailová adresa.');
}

$file = 'https://www.vse.cz/feed/';
$xml = simplexml_load_file($file);
if (!$xml) {
  die('Nepodařilo se načíst RSS kanál.');
}

$newsContent = '<h1>Novinky ze školy</h1>';
foreach ($xml->channel->item as $item) {
  $newsContent .= sprintf('<h2><a href="%s">%s</a></h2>', htmlspecialchars($item->link), htmlspecialchars($item->title));
  $newsContent .= '<p>' . htmlspecialchars($item->description) . '</p>';
}

$mailer = new PHPMailer(false);
$mailer->isSendmail();

$mailer->addAddress($email);
$mailer->setFrom('noreply@vse.cz');

$mailer->CharSet = 'ascii';
$mailer->Subject = 'Novinky ze školy';
$mailer->isHTML(true);
$mailer->Body = $newsContent;

// Attempt to send the email
if ($mailer->send()) {
  echo 'Novinky byly odeslány na e-mail: ' . htmlspecialchars($email); // News sent successfully
} else {
  echo "Vyskytla se chyba: " . $mailer->ErrorInfo; // Error occurred while sending email
}
