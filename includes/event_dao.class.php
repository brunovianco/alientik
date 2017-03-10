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

require_once 'connection.class.php';
require_once 'event.class.php';

abstract class EventDAO {
    
    /**
     * @return array|null
     */
    public static function get_all() {
        $db = new Connection();
        $conn = $db->connect();
        if ($conn == null) return null;
        /* TODO: configure yout time zone offset http://php.net/manual/es/timezones.php */
        $timezone = "";
        $time = new DateTime('now', new DateTimeZone($timezone));
        $offset = $time->format("P");
        $query = "select "
                . "acid_event.plugin_id, "
                . "acid_event.plugin_sid, "
                . "to_seconds(timestamp) - 62167219200 + to_seconds(utc_timestamp()) - to_seconds(now()) as id, "
                . "hex(acid_event.id) as event_id, "
                . "plugin_sid.name as plugin_name, "
                . "inet_ntoa(conv(hex(ip_src), 16, 10)) as ip_src, "
                . "inet_ntoa(conv(hex(ip_dst), 16, 10)) as ip_dst, "
                . "convert_tz(timestamp,'+00:00','$offset') as timestamp, "
                . "layer4_sport as src_port, "
                . "layer4_dport as dst_port "
                . "from alienvault_siem.device, acid_event "
                . "left join alienvault.plugin_sid on plugin_sid.plugin_id = acid_event.plugin_id and plugin_sid.sid = acid_event.plugin_sid "
                . "left join alienvault.plugin on plugin.id = acid_event.plugin_id "
                . "where device.id = acid_event.device_id and acid_event.plugin_id = 1001 "
                . "group by ip_src "
                . "order by timestamp desc;";
        $statement = $conn->prepare($query);
        $statement->setFetchMode(PDO::FETCH_CLASS, "Event");
        try {
            $statement->execute();
            $events = array();
            while ($event = $statement->fetch()) {
                $events[] = $event;
            }
            $db->disconnect();
            return $events;

        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            $db->disconnect();
            return null;
        }
    }
    
}
?>