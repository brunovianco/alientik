# AlienTik
Module to export AlienVault™ NIDS events to MikroTik

The code is released "as is" and is under testing, use at your own risk, works 
fine with version 5.3.4 (free) and it fits my needs. Feel free to collaborate.

This module export from the database all events with plugin id 1001 (NIDS), for
more detail, look at the SQL code in includes/event_dao.class.php.

Thanks to http://wiki.mikrotik.com/wiki/API_PHP_class