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

class Connection {
    
    const DB_HOST="";
    const DB_NAME="alienvault_siem";
    /* db user and password are generated at installation time and saved in /etc/ossim/ossim_setup.conf */
    const DB_USER="";
    const DB_PASSWD="";
    
    private $conn;
    
    function __construct() {
    }
    
    /**
     * @return PDO
     */
    public function connect() {
        try {
            $this->conn = new PDO("mysql:"
                    . "host=" . Connection::DB_HOST . ";"
                    . "dbname=" . Connection::DB_NAME . ";"
                    . "charset=utf8", Connection::DB_USER, Connection::DB_PASSWD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            return null;
        }
    }

    public function disconnect() {
        $this->conn = null;
    }
    
}
?>