<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

$redirect = $_GET['redirect'] ?? 'profile.php';
if (isset($_SESSION['user_id']))
    if ($_SESSION['is_admin'])
        header("Location: admin.php");
    else
        header("Location: $redirect");

$loginHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$messaggiPerForm = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if ($error == 'user')
        $messaggiPerForm .= '<li><span lang="en">Username<span> non esistente</li>';
    else if ($error == 'pwd')
        $messaggiPerForm .= '<li><span lang="en">Password<span> errata</li>';
    unset($_SESSION['error']);
}

if (strlen($messaggiPerForm) != 0)
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';

$errormsgsToModify = Templating::getContentBetweenPlaceholders($loginHtmlContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($loginHtmlContent, "errormsgs", $errormsgsToModify);

$formToModify = Templating::getContentBetweenPlaceholders($loginHtmlContent, 'form');
Templating::replaceAnchor($formToModify, 'redirect', $redirect);
$username = $_SESSION['username'] ?? '';
unset($_SESSION['username']);
Templating::replaceAnchor($formToModify, 'username', $username);
Templating::replaceContentBetweenPlaceholders($loginHtmlContent, 'form', $formToModify);

Templating::showHtmlPageWithoutPlaceholders($loginHtmlContent);

?>