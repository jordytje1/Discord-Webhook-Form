<?php
function SendForm() {
    require_once ('config.php');
    if ($alert_level == 1) {
        $msg = array("content" => "@here");
    } elseif ($alert_level == 2) {
        $msg = array("content" => "@everyone");
    } else {
        $msg = array();
    }
    $desc = '';
    foreach ($_POST as $name => $input) {
        $desc .= '**'.htmlspecialchars(ucwords($name)).':**'."\n".''.htmlspecialchars($input).''."\n\n".'';
    }
    $embed = array("embeds" => array(0 => array("title" => $embed_title, "description" => $desc, "color" => $embed_color),), "username" => $username);
    $content = array_merge($msg, $embed);
    $webhook = curl_init($webhook_url);
    curl_setopt($webhook, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($webhook, CURLOPT_POSTFIELDS, json_encode($content));
    curl_setopt($webhook, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($webhook);
}

if (SendForm() == null) {
    header('Location: index.php?r=success');
    exit();
} else {
    header('Location: index.php?r=error');
    exit();
}
?>