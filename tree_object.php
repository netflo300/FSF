<?php
session_start();
require_once ("class/db.class.php");
require_once ("lib/fonctions.php");
require_once ("class/node.class.php");

$db = new Db();
$list = array();

$tree = new Node(1);
$tree->explore($list);

print_r($tree);

