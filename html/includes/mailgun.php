<?php
$ch = curl_init();
$mailgunApiKey = getenv("MAILGUN_KEY");

curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/sandbox26ef209e49264bbca8ce50646f208f76.mailgun.org/messages");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $mailgunApiKey); //getenv("MAILGUN_KEY");

$postData = array(
    'from' => 'postmaster@sandbox26ef209e49264bbca8ce50646f208f76.mailgun.org',
    'to' => 'korniliaadabugday@gmail.com',
    'subject' => 'Hello',
    'text' => 'Testing some Mailgun awesomeness!'
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
$result = curl_exec($ch);
if (!$result) {
    echo 'Error' . curl_error($ch);
};

curl_close($ch);
