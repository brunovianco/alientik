## AlienTik
Module to export AlienVault™ NIDS events to MikroTik

The code is released "as is" and is under testing, use at your own risk, works 
fine with version 5.3.4 (free) and it fits my needs. Feel free to collaborate.

This module export from the database all events with plugin id 1001 (NIDS), for
more detail, look at the SQL code in includes/event_dao.class.php.

Thanks to http://wiki.mikrotik.com/wiki/API_PHP_class

# Adding support for TZSP to Suricata inside of AlienVault™

For sniff TZSP in Mangle you will also need:
- tzsp2pcap (https://github.com/thefloweringash/tzsp2pcap) **apt install build-essential libpcap-dev** then **make**
- tcpreplay (https://github.com/appneta/tcpreplay) **apt install tcpreplay**

First: add dummy interface for translate TZSP to PCAP
```
edit /etc/network/interfaces

auto tzsp0
iface tzsp0 inet manual
   up ifconfig $IFACE 0.0.0.0 up
   up ip link set $IFACE promisc on
   down ip link set $IFACE promisc off
   down ifconfig $IFACE down
   pre-up ip link add $IFACE type dummy
   post-up /usr/bin/screen -dm -S tzsp2pcap bash -c "/usr/bin/tzsp2pcap -f | /usr/bin/tcpreplay --topspeed -i tzsp0 -"
   post-down kill -9 tzsp2pcap tcpreplay
```

Second: configure AlienVault™ sensor for listen on the new interface

Third: open port 37008 in **iptables**, reboot appliance and you are done!
```
edit /etc/iptables/rules012-custom.iptables

# add this line at the top
-A INPUT -p udp --dport 37008 -j ACCEPT
```

Thanks to https://github.com/zzbe/mikrocata
