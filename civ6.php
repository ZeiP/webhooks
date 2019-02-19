<?php

require('../config.php');

$body = file_get_contents('php://input');
$json = json_decode($body);

$username = strtolower($json->value2);

if (isset($channels[$username])) {
  $user = $channels[$username];
  $body = 'Käyhän pelaamassa vuorosi ' . $json->value3 . ' pelissä ' . $json->value1 . '!';
  if (!empty($user['mail'])) {
    $to = $user['mail'];
    $subject = 'Vuoro pelissä ' . $json->value1;
    $addt_headers = array(
      'From: Civ-vuorohallinta <info@example.org>',
      'X-Mailer: Vuoroilmoitin / PHP ' . phpversion(),
    );
    mail($to, $subject, $body, implode("\r\n", $addt_headers));
  }
  if (!empty($user['slack_id'])) {
    send_slack_im($user['slack_id'], $body);
  }
  if (!empty($user['sms'])) {
    send_nexmo_sms($user['sms'], $body);
  }
}

function get_chat_id($slack_id) {
  $ids = send_slack_request('im.list');
  foreach ($ids->ims as $im) {
    if ($im->user == $slack_id) {
      return $im->id;
    }
  }
}

function send_slack_request($action, $method = 'GET', $data = '') {
  global $slack_token;
  $url = 'https://slack.com/api/' . $action . '?token=' . $slack_token;
  if ($method == 'GET' && is_array($data)) {
    $url .= '&' . http_build_query($data);
  }
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $result = json_decode(curl_exec($curl));
  curl_close($curl);
  return $result;
}

function send_slack_im($slack_id, $msg) {
  $chat_id = get_chat_id($slack_id);
  send_slack_request('chat.postMessage', 'GET', array('channel' => $chat_id, 'text' => $msg));
}

function send_nexmo_sms($number, $msg) {
  global $nexmo_keys;

  $url = 'https://rest.nexmo.com/sms/json';

  $data = array(
    'from' => 'Civ6 turn',
    'text' => $msg,
    'to' => $number,
  );
  $data = array_merge($data, nexmo_key);

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $result = json_decode(curl_exec($curl));
  curl_close($curl);
}
