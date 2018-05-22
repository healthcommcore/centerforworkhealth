<?php

// Constants for specifying email parameters and redirect location

define('MAILTO', 'Lisa_Burke@dfci.harvard.edu');
//define('MAILTO', 'dave_rothfarb@dfci.harvard.edu');
define('FROM', 'centerforworkhealth@sph.harvard.edu');
define('BCC', 'dave_rothfarb@dfci.harvard.edu');
define('REDIRECT', 'http://centerforworkhealth.sph.harvard.edu/');

$docname = $_POST["tracking-docname"];

$subject_arr = array(
  "guidelines" => array(
    "subject" => "Integrated Approach guidelines"
  ),
  "wish-assessment" => array(
    "subject" => "WISH assessment"
  )
);

$subject = $subject_arr[$docname]["subject"];

// Quick email message intro and extra headers for "from" and "Bcc" fields
$message_intro = "Someone has downloaded the $subject\n\n";
$headers = array('From: ' . FROM, 'Bcc: ' . BCC);

// First make sure all submitted form fields have been filled out
if ( isset($_POST["first_name"]) && isset($_POST["last_name"]) &&
    isset($_POST["organization"]) && isset($_POST["email"]) ) {
  $vals = array(
    "first_name" => $_POST["first_name"], 
    "last_name" => $_POST["last_name"], 
    "organization" => $_POST["organization"], 
    "email" => $_POST["email"]
  );

// Build the email message with message intro as assigned above and the
// makeIntoMessage function which cleans and stringifies the $vals array
  $message = $message_intro . makeIntoMessage($vals);
  mail(MAILTO, $subject . " downloaded", $message, implode("\r\n", $headers) );
  //header('Content-Type: application/pdf');
  //header('Content-Disposition: attachement; filename="guidelines.pdf"');
  //readfile('../sites/default/files/10.12.17_Guidelines_Screen_post.pdf');
  header('Location: ' . REDIRECT . $docname);
  //echo $message;
}
else {
  echo "<h1>An error has occurred</h1>";
}

function makeIntoMessage($vals) {
  $message = "";
  foreach($vals as $key => $val) {
    $message .= ucfirst( str_replace("_", " ", $key)) . ": " . $val . "\r\n";
  }
  return $message;
}





