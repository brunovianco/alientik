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

class Event {
    
    private $plugin_id;
    private $plugin_sid;
    private $id;
    private $event_id;
    private $plugin_name;
    private $ip_src;
    private $ip_dst;
    private $timestamp;
    private $src_port;
    private $dst_port;
    
    function __construct() {
    }
    
    function get_plugin_id() {
        return $this->plugin_id;
    }

    function get_plugin_sid() {
        return $this->plugin_sid;
    }

    function get_id() {
        return $this->id;
    }

    function get_event_id() {
        return $this->event_id;
    }

    function get_plugin_name() {
        return substr(substr($this->plugin_name, 18), 0, count($this->plugin_name) - 2);
    }

    function get_ip_src() {
        return $this->ip_src;
    }

    function get_ip_dst() {
        return $this->ip_dst;
    }

    function get_timestamp() {
        return $this->timestamp;
    }

    function get_src_port() {
        return $this->src_port;
    }

    function get_dst_port() {
        return $this->dst_port;
    }

    function set_plugin_id($plugin_id) {
        $this->plugin_id = $plugin_id;
    }

    function set_plugin_sid($plugin_sid) {
        $this->plugin_sid = $plugin_sid;
    }

    function set_id($id) {
        $this->id = $id;
    }

    function set_event_id($event_id) {
        $this->event_id = $event_id;
    }

    function set_plugin_name($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    function set_ip_src($ip_src) {
        $this->ip_src = $ip_src;
    }

    function set_ip_dst($ip_dst) {
        $this->ip_dst = $ip_dst;
    }

    function set_timestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    function set_src_port($src_port) {
        $this->src_port = $src_port;
    }

    function set_dst_port($dst_port) {
        $this->dst_port = $dst_port;
    }

}
?>