<?php

//   This script imports IPs and servers from our old inhouse database to 
//   racktables.
//   
//   Copyright (C) 2013 Craig Parker <craig@paragon.net.uk>
//
//   This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 3 of the License, or
//   (at your option) any later version.
//   
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; If not, see <http://www.gnu.org/licenses/>.
//

$racktables_con = mysql_connect("host","user","pass");
if (!$racktables_con)
{
        die("Racktables no worky.");
}

$ipdb_con = mysql_connect("host","user","pass");
if (!$ipdb_con)
{
        die("ipdb no worky.");
}

$ipdb_db = mysql_select_db("database", $ipdb_con);

$rack_db = mysql_select_db("database", $racktables_con);

echo "Selected IPDB database. <br />";

print $ipdb_select = mysql_query('SELECT ip, server FROM ips');

echo "Selected racktables database. <br />";

$rackarray = array();

while($ipdbrow = mysql_fetch_array($ipdb_select))
{
        $rackarrayip = long2ip($ipdbrow['ip']);
       
        $rackarrayserver = $ipdbrow['server'];
                    
        $rackinsertquery = "INSERT INTO IPv4Address SET name = '$rackarrayserver', ip = INET_ATON(\"$rackarrayip\")";
        
        echo $rackinsertquery;
       
        mysql_query($rackinsertquery, $racktables_con);
       
       	echo mysql_error($racktables_con);
}

echo "Finished racktables insert <br />";

echo mysql_error();

?>
