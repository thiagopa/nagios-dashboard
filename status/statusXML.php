<?php

  /*
   * +----------------------------------------------------------------------+
   * | statusXML.php                                                        |
   * | PHP example script showing use of statusXML.php.inc                  |
   * |                                                                      |
   * | The canonical source for this project is:                            |
   * |   <http://svn.jasonantman.com/nagios-xml/> (via SVN or HTTP)         |
   * +----------------------------------------------------------------------+
   * | Copyright (c) 2006-2010 Jason Antman.                                |
   * |                                                                      |
   * | This program is free software; you can redistribute it and/or modify |
   * | it under the terms of the GNU General Public License as published by |
   * | the Free Software Foundation; either version 3 of the License, or    |
   * | (at your option) any later version.                                  |
   * |                                                                      |
   * | This program is distributed in the hope that it will be useful,      |
   * | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
   * | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
   * | GNU General Public License for more details.                         |
   * |                                                                      |
   * | You should have received a copy of the GNU General Public License    |
   * | along with this program; if not, write to:                           |
   * |                                                                      |
   * | Free Software Foundation, Inc.                                       |
   * | 59 Temple Place - Suite 330                                          |
   * | Boston, MA 02111-1307, USA.                                          |
   * +----------------------------------------------------------------------+
   * | Authors: Jason Antman <jason@jasonantman.com>                        |
   * +----------------------------------------------------------------------+
   * | CHANGELOG:                                                           |
   * | 2010-08-10 (r6) jantman:                                             |
   * |   - updated license, file header, changelog                          |
   * +----------------------------------------------------------------------+
   * | $Date::                                                            $ |
   * | $LastChangedRevision::                                             $ |
   * | $HeadURL::                                                         $ |
   * +----------------------------------------------------------------------+ 
   */


// this script mines data from the status.dat of a Nagios 2.x installation
require_once("statusXML.php.inc");

$statusFile = "/usr/local/nagios/var/status.dat";

$nag_version = getFileVersion($statusFile); // returns integer 2 or 3
$created_ts = 0;

$debug = false;

if($nag_version == 3)
  {
    $data = getData3($statusFile); // returns an array
  }
else
  {
    $data = getData2($statusFile); // returns an array
  }

$hosts = $data['hosts'];
$services = $data['services'];
$program = "";
if(array_key_exists("program", $data))
  {
    $program = $data['program'];
  }

outputXML($hosts, $services, $program);


?>
