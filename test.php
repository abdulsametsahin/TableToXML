<?php
error_reporting(E_ALL);

include "./TableToXML.php";

$ttx = new TableToXML("localhost", "root", "xxx", "shop");

$ttx->generate("star_products", "./products.xml", "product");
