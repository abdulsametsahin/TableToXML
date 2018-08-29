<?php
error_reporting(E_ALL);

include "./TableToXML.php";

$ttx = new TableToXML("localhost", "root", "1453Sa", "gold_sil");

$ttx->generate("star_products", "./urunler.xml", "urun");
