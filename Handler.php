<?php
namespace AutoGitPuller;
require_once "Util/Commander.php";
require_once "AutoGitPull.php";
use AutoGitPuller;

$default = array(
    "secretKey" => "mysecretkey",
    "repository"=>"",
    "branchMap" => array(
        "master" =>dirname(__FILE__)."/master/"
    ),
    "authorMap" =>array(
        "nguyenvanduocit"=>"/"
    ),
    "exclude" => array(),
    "tmpDir" => "reponsive",
    "isNeedClearUp" => false,
    "backupDir" => dirname(__FILE__)."/backup/",
    "isUseComposer" => false,
    "isEmailOnError" => true,
    "notifyEmail" => "nguyenvanduocit@gmail.com"
);
$args = array();
$args = array_merge($default, $args);
$autoGitPull = new AutoGitPull($args);