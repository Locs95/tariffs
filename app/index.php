<?php

require "../vendor/autoload.php";

use App\Tariff;


$tariff = new Tariff();

if(isset($_GET['group_id'])) {
	$tariff->getGroupTariffs($_GET['group_id']);
}
else if(isset($_GET['g_id']) && isset($_GET['t_id'])) {
	$tariff->getTariff($_GET['g_id'], $_GET['t_id']);
}
else {
	$tariff->getGroups();
}

