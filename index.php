<?php
require ('resources/fb_init.php');
//if ($user_id) $facebook->api('me/permissions/read_mailbox',"DELETE");

$scripts="<script src='javascript/form_animator.js'></script>";
$view_title="Welcome to Find My Friends!";
$view_path="views/action_form.php";
require ('views/app_skeleton_view.php');
?>