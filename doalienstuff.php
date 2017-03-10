<?php

/*
 * Copyright (C) 2017 Bruno Vianco
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'includes/event_dao.class.php';
require_once 'includes/routeros_api.class.php';

$host = "";
$user = "";
$passwd = "";
/* cidr addresses configured in monitoring interface */
$home_net = array();
$in_list = array();
$to_list = array();

$api = new RouterosAPI();
$events = EventDAO::get_all();

if ($api->connect($host, $user, $passwd)) {
    /* check if addresses are already in list */
    $result = $api->comm("/ip/firewall/address-list/print", array(
        "?list" => "alienvault"
    ));
    foreach ($result as $ip) {
        $in_list[] = $ip["address"];
    }
    foreach ($events as $event) {
        if (!in_array($event->get_ip_src(), $in_list)) {
            $to_list[] = $event;
        }
    }
    /* add the new addresses if not are in white list */
    foreach ($to_list as $event) { /* @var $event Event */
        $match = false;
        foreach ($home_net as $cidr) {
            $match = cidr_match($event->get_ip_src(), $cidr);
        }
        if ($match) break;
        $ip_src = $event->get_ip_src();
        $plugin_name = $event->get_plugin_name();
        $result = $api->comm("/ip/firewall/address-list/add", array(
            "list" => "alienvault",
            "address" => "$ip_src",
            "comment" => "$plugin_name",
            "timeout" => "1d"
        ));
    }
    $api->disconnect();
}

/* thanks to http://stackoverflow.com/questions/594112/matching-an-ip-to-a-cidr-mask-in-php-5 */
function cidr_match($ip, $cidr) {
    list($subnet, $mask) = explode("/", $cidr);
    if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet)) {
        return true;
    }
    return false;
}

?>