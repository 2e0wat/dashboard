<?php

session_start();

if (file_exists("./css/theme.php")) { require_once("./css/theme.php");
      } else { die("theme.php does not exist.");
   }

if (file_exists("./pgs/functions.php")) { require_once("./pgs/functions.php");
      } else { die("functions.php does not exist.");
   }

if (file_exists("./pgs/config.inc.php")) { require_once("./pgs/config.inc.php");
      } else { die("config.inc.php does not exist.");
   }

if (!class_exists('ParseXML'))   require_once("./pgs/class.parsexml.php");
if (!class_exists('Node'))       require_once("./pgs/class.node.php");
if (!class_exists('xReflector')) require_once("./pgs/class.reflector.php");
if (!class_exists('Station'))    require_once("./pgs/class.station.php");
if (!class_exists('Peer'))       require_once("./pgs/class.peer.php");
if (!class_exists('Interlink'))  require_once("./pgs/class.interlink.php");

$Reflector = new xReflector();
$Reflector->SetFlagFile("./pgs/country.csv");
$Reflector->SetPIDFile($Service['PIDFile']);
$Reflector->SetXMLFile($Service['XMLFile']);
$Reflector->LoadXML();

if ($CallingHome['Active']) {
   $CallHomeNow = false;
   $LastSync = 0;
   $Hash = "";

   if (!file_exists($CallingHome['HashFile'])) {
      $Ressource = fopen($CallingHome['HashFile'], "w+");
      if ($Ressource) {
         $Hash = CreateCode(16);
		   @fwrite($Ressource, "<?php\n");
		   @fwrite($Ressource, "\n".'$Hash = "'.$Hash.'";');
		   @fwrite($Ressource, "\n\n".'?>');
		   @fflush($Ressource);
		   @fclose($Ressource);
		   @chmod($HashFile, 0777);
		}
   } else {
      require_once($CallingHome['HashFile']);
   }

   if (@file_exists($CallingHome['LastCallHomefile'])) {
      if (@is_readable($CallingHome['LastCallHomefile'])) {
         $tmp      = @file($CallingHome['LastCallHomefile']);
         if (isset($tmp[0])) {
            $LastSync = $tmp[0];
         }
         unset($tmp);
      }
   }
   
   if ($LastSync < (time() - $CallingHome['PushDelay'])) {
      $CallHomeNow = true;
      $Ressource = @fopen($CallingHome['LastCallHomefile'], "w+");
	   if ($Ressource) {
	      @fwrite($Ressource, time());
		   @fflush($Ressource);
		   @fclose($Ressource);
		   @chmod($HashFile, 0777);
		}
   }

   if ($CallHomeNow || isset($_GET['callhome'])) {
      $Reflector->SetCallingHome($CallingHome, $Hash);
      $Reflector->ReadInterlinkFile();
      $Reflector->PrepareInterlinkXML();
      $Reflector->PrepareReflectorXML();
      $Reflector->CallHome();
   }

} else {
   $Hash = "";
}

?>

<!-- -------------------------------- HTML --------------------------------- -->

<!DOCTYPE html>

<!-- -------------------------------- HEAD ---------------------------------- -->

<head>

   <meta charset="UTF-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <meta name="description" content="<?php echo $PageOptions['MetaDescription']; ?>" />
   <meta name="keywords"    content="<?php echo $PageOptions['MetaKeywords']; ?>" />
   <meta name="author"      content="<?php echo $PageOptions['MetaAuthor']; ?>" />
   <meta name="revisit"     content="<?php echo $PageOptions['MetaRevisit']; ?>" />
   <meta name="robots"      content="<?php echo $PageOptions['MetaAuthor']; ?>" />

   <link rel="stylesheet" type="text/css" href="./css/layout.php">
   
   <link rel="icon" href="./favicon.ico" type="image/vnd.microsoft.icon">

   <title>
      <?php
         echo $Reflector->GetReflectorName();
      ?>
      Reflector Dashboard
   </title>

   <?php

      if ($PageOptions['PageRefreshActive']) {
         echo '
            <script src="./js/jquery-1.12.4.min.js"></script>
            <script>
               var PageRefresh;
               function ReloadPage() {
                  $.get("./index.php'.(isset($_GET['show'])?'?show='.$_GET['show']:'').'", function(data) {
                     var BodyStart = data.indexOf("<bo"+"dy");
                     var BodyEnd = data.indexOf("</bo"+"dy>");
                     if ((BodyStart >= 0) && (BodyEnd > BodyStart)) {
                        BodyStart = data.indexOf(">", BodyStart)+1;
                        $("body").html(data.substring(BodyStart, BodyEnd));
                     }
                  })
                  .always(function() {
                     PageRefresh = setTimeout(ReloadPage, '.$PageOptions['PageRefreshDelay'].');
                  });
               }';
               if (!isset($_GET['show']) || (($_GET['show'] != 'liveircddb') && ($_GET['show'] != 'reflectors') && ($_GET['show'] != 'interlinks'))) {
                  echo '
                     PageRefresh = setTimeout(ReloadPage, '.$PageOptions['PageRefreshDelay'].');';
               }
               echo '
                  function SuspendPageRefresh() {
                     clearTimeout(PageRefresh);
                  }
            </script>';
      }

      if (!isset($_GET['show'])) $_GET['show'] = "";

   ?>

</head>

<!-- -------------------------------- BODY --------------------------------- -->

<body>
   
   <?php if (file_exists("./tracking.php")) { include_once("tracking.php"); }?>

   <div class="primary-container">

<!-- ------------------------------- Header -------------------------------- -->

   <header class="header">

      <img src="/img/header.png">
      
      <p>
         We welcome <mark>ALL</mark> to use the reflector. Module A supports Multi-Protocol Transcoding,
         <a href="https://stats.allstarlink.org/stats/621821" target="_blank">AllStar (621821)</a>,
         <a href="https://peanut.pa7lim.nl" target="_blank">Peanut (XLX178A)</a>,
   	   and
         <a href="https://tgif.network/tgprofile.php?id=178" target="_blank">TGIF (178)</a>.
         <hide>
         Please note the AllStar connection is G4BUX-A. Modules B-F are dedicated to individual modes.
         Please visit our <a href="https://buxtonradioamateurs.wixsite.com/buxton-radio-club" target="_blank">Home Page</a>
         to find out more about our club -
         <a href="https://www.qrz.com/db/G4BUX" target="_blank">G4BUX</a>
         /
         <a href="https://www.qrz.com/db/G8BUX" target="_blank">G8BUX</a>.
         </hide>
      </p>
   

   <!-- ------------------------ Navigation Bar ------------------------- -->

      <div class="navbar" align=center>
            <a href="./index.php" class="navbarlink<?php if ($_GET['show'] == '') { echo 'active'; } ?>">Users</a>
            <a href="./index.php?show=repeaters" class="navbarlink<?php if ($_GET['show'] == 'repeaters') { echo 'active'; } ?>"><hide>Repeaters / </hide>Nodes (<?php echo $Reflector->NodeCount(); ?>)</a>
            <a href="./index.php?show=modules" class="navbarlink<?php if ($_GET['show'] == 'modules') { echo 'active'; } ?>">Modules</a>
            <a href="./index.php?show=reflectors" class="navbarlink<?php if ($_GET['show'] == 'reflectors') { echo 'active'; } ?>">Reflectors</a>
            <a href="./index.php?show=allstar" class="navbarlink<?php if ($_GET['show'] == 'allstar') { echo 'active'; } ?>">AllStar Dash</a>
            <a href="./index.php?show=tgif" class="navbarlink<?php if ($_GET['show'] == 'tgif') { echo 'active'; } ?>">TGIF Dash</a>

               <?php
               if ($PageOptions['Traffic']['Show']) {
                  echo '
                     <a href="./index.php?show=traffic" class="navbarlink';
                        if ($_GET['show'] == 'traffic') { echo 'active'; }
                        echo '">Traffic Stats
                     </a>';
               }
               
   		      if ($PageOptions['IRCDDB']['Show']) {
                  echo '
                     <a href="./index.php?show=liveircddb" class="navbarlink';
                        if ($_GET['show'] == 'liveircddb') { echo 'active'; }
                        echo '">D-Star Live
                     </a>';
               }
               
               ?>
      </div>

   </header>

<!-- ---------------------------- Page Content ----------------------------- -->

   <div class="content" align="center">
   
      <?php
      
         if ($CallingHome['Active']) {
            if (!is_readable($CallingHome['HashFile']) && (!is_writeable($CallingHome['HashFile']))) {
               echo '
                  <div class="error">
                     Your private hash in '.$CallingHome['HashFile'].' could not be created. Please check your config file and the permissions for the defined folder.
                  </div>';
            }
         }

         switch ($_GET['show']) {
            case 'users'      : require_once("./pgs/users.php"); break;
            case 'repeaters'  : require_once("./pgs/repeaters.php"); break;
            case 'liveircddb' : require_once("./pgs/liveircddb.php"); break;
            case 'peers'      : require_once("./pgs/peers.php"); break;
            case 'modules'    : require_once("./pgs/modules.php"); break;
            case 'reflectors' : require_once("./pgs/reflectors.php"); break;
            case 'traffic'    : require_once("./pgs/traffic.php"); break;
            case 'allstar'    : require_once("./pgs/allstar.php"); break;
            case 'tgif'       : require_once("./pgs/tgif.php"); break;
            default           : require_once("./pgs/users.php");
         }

      ?>
   
   </div>

   <!-- ------------------------------- Footer ------------------------------- -->

   <footer class="footer" align="center">
      <mark>
         <?php
            echo $Reflector->GetReflectorName();
         ?>
      </mark>
      is maintained by Ash -
      <a href="https://www.qrz.com/db/2E0WAT">2E0WAT</a>
      & Jon -
      <a href="https://www.qrz.com/db/EA5JMN">EA5JMN</a> / <a href="https://www.qrz.com/db/G7NFK">G7NFK</a>
   </footer>

   </div>

</body>

</html>
