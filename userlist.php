<?php

require '../config.php';

echo '<html><body>';
if (!empty($_GET['password']) && $_GET['password'] == $userlist_password) {
  foreach ($channels as $user =>  $channel) {
    echo '<dl><dt>' . $user . '</dt>';
    foreach ($channel as $ch => $address) {
      echo '<dd><strong>' . $ch . ':</strong>' . $address . '</dd>';
    }
    echo '</dl>';
  }
}
echo '</body></html>';
