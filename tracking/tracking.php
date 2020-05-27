<?php

// Constants for specifying email parameters and redirect location

define('MAILTO', 'Lisa_Burke@dfci.harvard.edu');
//define('MAILTO', 'dave_rothfarb@dfci.harvard.edu');
define('FROM', 'centerforworkhealth@sph.harvard.edu');
define('BCC', 'dave_rothfarb@dfci.harvard.edu');
define('REDIRECT', 'http://centerforworkhealth.sph.harvard.edu/resources/');
//define('REDIRECT', 'http://cwhwb.hccupdate.org/resources/');

$docname = $_POST["tracking-docname"];

$subject_arr = array(
  "guidelines" => array(
    "subject" => "Integrated Approach guidelines",
    "url" => "guidelines-implementing-integrated-approach"
  ),
  "wish-assessment" => array(
    "subject" => "WISH assessment",
    "url" => "workplace-integrated-safety-and-health-wish-assessment"
  ),
  "interactive-toolbox" => array(
    "subject" => "Interactive toolbox",
    "url" => "covid-19-interactive-toolbox-talk"
  )
);

$subject = $subject_arr[$docname]["subject"];
$url = $subject_arr[$docname]["url"];

// Quick email message intro and extra headers for "from" and "Bcc" fields
$message_intro = "Someone has downloaded the $subject\n\n";
$headers = array('From: ' . FROM, 'Bcc: ' . BCC);

// First check if honeypot text field used, if so, exit 
if ( isset($_POST["tracking-honeypot"])) {
  $to_test = trim($_POST["tracking-honeypot"]);
  if( $to_test != "" || !empty($to_test) || strlen($to_test) > 0) {
    exit("The honeypot field was filled out and should not have been. Exiting script");
  }
}

// Next, make sure all submitted form fields have been filled out
if ( isset($_POST["first_name"]) && isset($_POST["last_name"]) &&
    isset($_POST["organization"]) && isset($_POST["email"]) ) {

  
  // Continue with capturing data fields
  $vals = array(
    "first_name" => $_POST["first_name"], 
    "last_name" => $_POST["last_name"], 
    "organization" => $_POST["organization"], 
    "zip_postal_code" => $_POST["zip-postal-code"], 
    "email" => $_POST["email"]
  );

// Build the email message with message intro as assigned above and the
// makeIntoMessage function which cleans and stringifies the $vals array
  $message = $message_intro . makeIntoMessage($vals);
  mail(MAILTO, $subject . " downloaded", $message, implode("\r\n", $headers) );
  //header('Content-Type: application/pdf');
  //header('Content-Disposition: attachement; filename="guidelines.pdf"');
  //readfile('../sites/default/files/10.12.17_Guidelines_Screen_post.pdf');
  header('Location: ' . REDIRECT . $url);
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





