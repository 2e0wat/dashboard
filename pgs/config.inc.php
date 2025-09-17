<?php

/*
Possible values for IPModus
HideIP
ShowFullIP
ShowLast1ByteOfIP
ShowLast2ByteOfIP
ShowLast3ByteOfIP
*/

$Service     = array();
$CallingHome = array();
$PageOptions = array();
$VNStat      = array();

$PageOptions['ContactEmail']                         = 'insert.your@email.address';	// Support E-Mail address
$PageOptions['DashboardVersion']                     = '2.4.2';				// Dashboard Version
$PageOptions['PageRefreshActive']                    = true;				// Activate automatic refresh
$PageOptions['PageRefreshDelay']                     = '10000';				// Page refresh time in miliseconds

$PageOptions['RepeatersPage'] = array();
$PageOptions['RepeatersPage']['LimitTo']             = 99;				// Number of Repeaters to show
$PageOptions['RepeatersPage']['IPModus']             = 'HideIP';			// See possible options above
$PageOptions['RepeatersPage']['MasqueradeCharacter'] = '*';				// Character used for  masquerade

$PageOptions['PeerPage'] = array();
$PageOptions['PeerPage']['LimitTo']                  = 99;				// Number of peers to show
$PageOptions['PeerPage']['IPModus']                  = 'HideIP';			// See possible options above
$PageOptions['PeerPage']['MasqueradeCharacter']      = '*';				// Character used for  masquerade

$PageOptions['LastHeardPage']['LimitTo']             = 50;				// Number of stations to show

$PageOptions['NumberOfModules']                      = 6;				// Number of Modules enabled on reflector
$PageOptions['ModuleNames'] = array();							// Module nomination
$PageOptions['ModuleNames']['A']                     = 'Multi-Mode';
$PageOptions['ModuleNames']['B']                     = 'DCS';
$PageOptions['ModuleNames']['C']                     = 'DExtra';
$PageOptions['ModuleNames']['D']                     = 'DMR';
$PageOptions['ModuleNames']['E']                     = 'DPlus';
$PageOptions['ModuleNames']['F']                     = 'YSF';

$PageOptions['MetaDescription']                      = 'XLX178 - Buxton Radio Amateurs XLX Multi-Protocol Digital Reflector for Ham Radio Operators.';	// Meta Tag Values, usefull for Search Engine
$PageOptions['MetaKeywords']                         = 'Buxton Radio Amateurs, Ham Radio, D-Star, XReflector, XLX, XRF, DCS, REF, XLX178, YSF, DMR, Peanut, DMR+, DStar, Reflector, XLXd, Ambed, Ambeserver, ';	// Meta Tag Values, usefull forSearch Engine
$PageOptions['MetaAuthor']                           = '2E0WAT';			// Meta Tag Values, usefull for Search Engine
$PageOptions['MetaRevisit']                          = 'After 30 Days';			// Meta Tag Values, usefull for Search Engine
$PageOptions['MetaRobots']                           = 'index,follow';			// Meta Tag Values, usefull for Search Engine

$PageOptions['UserPage']['ShowFilter']               = false;				// Show Filter on Users page
$PageOptions['Traffic']['Show']                      = false;				// Enable vnstat traffic statistics
$PageOptions['IRCDDB']['Show']                       = false;				// Show liveircddb, set it to false if you are running your db in https

$PageOptions['CustomTXT']                            = '';				// custom text in your header

$Service['PIDFile']                                  = '/var/log/xlxd.pid';
$Service['XMLFile']                                  = '/var/log/xlxd.xml';

$CallingHome['Active']                               = true;				// xlx phone home, true or false
$CallingHome['MyDashBoardURL']                       = 'https://xlx.buxton.radio';	// dashboard url
$CallingHome['ServerURL']                            = 'http://xlxapi.rlx.lu/api.php';	// database server, do not change !!!!
$CallingHome['PushDelay']                            = 600;				// push delay in seconds
$CallingHome['Country']                              = "Derbyshire, UK";		// Country
$CallingHome['Comment']                              = "Buxton Radio Amateurs - supports Peanut, DStar, DMR+, YSF, AP/Term Mode, Allstar 621821, TGIF 178";	// Comment. Max 100 character
$CallingHome['HashFile']                             = "/xlxd/callinghome.php";		// Make sure the apache user has read and write permissions in this folder.
$CallingHome['LastCallHomefile']                     = "/tmp/lastcallhome.php";		// lastcallhome.php can remain in the tmp folder
$CallingHome['OverrideIPAddress']                    = "insert.fixed.ip.address";				// Insert your IP address here. Leave blank for autodetection. No need to enter a fake address.
$CallingHome['InterlinkFile']                        = "/xlxd/xlxd.interlink";		// Path to interlink file

$VNStat['Interfaces']                                = array();
$VNStat['Interfaces'][0]['Name']                     = 'LAN';
$VNStat['Interfaces'][0]['Address']                  = 'eth0';
$VNStat['Binary']                                    = '/usr/bin/vnstat';

?>
