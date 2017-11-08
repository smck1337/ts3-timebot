<?php

require_once("TeamSpeak3/TeamSpeak3.php");
date_default_timezone_set('Europe/Budapest');
TeamSpeak3::init();

$user = "serveradmin";
$pass = "jelszo";
$serverIP = "87.229.110.218";
$botTimeChannel = 38;
$botUsersChannel = 39;
$nickname = "endTBOT";

try
{
	$ts3 = TeamSpeak3::factory("serverquery://{$user}:{$pass}@{$serverIP}:10011/?server_port=9987&blocking=0&nickname={$nickname}");

    $BotChannelTime = $ts3->channelGetById($botTimeChannel);
    $BotChannelUsuarios = $ts3->channelGetById($botUsersChannel);

    $unixTime = time();
	$realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo $realTime."\t[INFO] Csatlakozva\n";

	$unixTime = time();
    $realTime = date('[Y-m-d] - [H:i]',$unixTime);
    if($BotChannelTime["channel_name"] != "[cspacer0] {$realTime}")
    {
        $BotChannelTime["channel_name"] = "[cspacer0] {$realTime}";
        $unixTime = time();
        $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
        echo $realTime."\t[INFO] Ido frissitve\n";
    }

    $serverInfo = $ts3->getInfo();
    $maxSlots = $serverInfo["virtualserver_maxclients"];
    $clientsOnline = $serverInfo["virtualserver_clientsonline"];
    $slotsReserved = $serverInfo["virtualserver_reserved_slots"];
    $slotsAvailable = $maxSlots - $slotsReserved;

    if($BotChannelUsuarios["channel_name"] != "[cspacer0] Online felhasználók: {$clientsOnline}/{$slotsAvailable}")
    {
        $BotChannelUsuarios["channel_name"] = "[cspacer0] Online felhasználók: {$clientsOnline}/{$slotsAvailable}";
        $unixTime = time();
        $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
        echo $realTime."\t[INFO] Online felhasznalok frissitve\n";
    }

    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    die($realTime."\t[INFO] Keszen van\n");
}
catch(Exception $e)
{
    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo "Failed\n";
    die($realTime."\t[ERROR]  " . $e->getMessage() . "\n". $e->getTraceAsString() ."\n");
}
