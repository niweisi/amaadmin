<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
$jsrand=str_replace('.','',$_M[config][metcms_v]).$_M[config][met_patch];
echo <<<EOT
--><!DOCTYPE HTML>
<html>
<head>
<title>{$_M[word][metinfo]}</title>
<link href="{$_M[url][site]}favicon.ico" rel="shortcut icon" />
<meta name="renderer" content="webkit">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<link rel="stylesheet" href="{$_M[url][pub]}ui/admin/css/metinfo.css?{$jsrand}" />
<!--[if IE]><script src="{$_M[url][site]}public/js/html5.js" type="text/javascript"></script><![endif]-->
</head>
<body>
<!--
EOT;
require $this->template('ui/box');
require $this->template('ui/top');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>