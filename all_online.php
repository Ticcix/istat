<?php

/*
=====================================================
Автор: Артем Малков
Url модуля: https://artem-malcov.ru/moduli_i_skripty/modul-statistiki-lightstat-10-dlya-dle
Версия: 1.0
=====================================================
Файл: all_online.php
-----------------------------------------------------
Назначение: Вывод количества пользователей онлайн
=====================================================
*/


if(!defined('DATALIFEENGINE')) {
  die("Hacking attempt!");
}

$ip_user = $_SERVER['REMOTE_ADDR'];
$no_active_time = 300; // Время в секундах, через которое удаляем пользователя из бд.

$delete_user = $db->query("DELETE FROM `dle_online` WHERE `time` + '$no_active_time' < ".time());

if(!$db->query("INSERT IGNORE INTO `dle_online` VALUES ('$ip_user','".time()."')")){
$update_user = $db->query("UPDATE `dle_online` SET `time` = '".time()."' WHERE `ip`= '$ip_user'");
}

$all_online = $db->num_rows($db->query("SELECT * FROM `dle_online`"),0,0);

function number_user($number_user, $titles_user) {
    $cases = array (2, 0, 1, 1, 1, 2);
    return $titles_user[ ($number_user%100>4 && $number_user%100<20)? 2 : $cases[min($number_user%10, 5)] ];
}

echo 'Сейчас на сайте: '.$all_online.' человек'.number_user($all_online, array('','а',''));

?>

