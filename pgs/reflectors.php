<?php

$Result = @fopen($CallingHome['ServerURL']."?do=GetReflectorList", "r");

if (!$Result) die("HEUTE GIBTS KEIN BROT");

$INPUT = "";
while (!feof ($Result)) {
    $INPUT .= fgets ($Result, 1024);
}
fclose($Result);

$XML = new ParseXML();
$Reflectorlist = $XML->GetElement($INPUT, "reflectorlist");
$Reflectors    = $XML->GetAllElements($Reflectorlist, "reflector");

?>

<table class="listingtable">
  <tr>
    <th>&nbsp;&nbsp;#&nbsp;&nbsp;</th>
    <th>Reflector</th>
    <th>Location</th>
    <th>Up</th>
    <th>Comment</th>
  </tr>

<?php

  $odd = "";

  for ($i=0;$i<count($Reflectors);$i++) {

    $NAME          = $XML->GetElement($Reflectors[$i], "name");
    $COUNTRY       = $XML->GetElement($Reflectors[$i], "country");
    $LASTCONTACT   = $XML->GetElement($Reflectors[$i], "lastcontact");
    $COMMENT       = $XML->GetElement($Reflectors[$i], "comment");
    $DASHBOARDURL  = $XML->GetElement($Reflectors[$i], "dashboardurl");

    if ($odd == $odrw) { $odd = "$prilt"; } else { $odd = "$odrw"; }

    echo '
      <tr bgcolor="'.$odd.'" onMouseOver="this.bgColor=\''.$seclt.'\';" onMouseOut="this.bgColor=\''.$odd.'\';" style="cursor:pointer" onclick=window.open("'.$DASHBOARDURL.'")>
      <td align="center">'.($i+1).'</td>
      <td align="center">'.$NAME.'</td>
      <td align="center">'.$COUNTRY.'</td>
      <td align="center" valign="middle"><img src="./img/'; if ($LASTCONTACT<(time()-1800)) { echo 'down'; } ELSE { echo 'up'; } echo '.png" height="20" /></td>
      <td align="left">'.$COMMENT.'</td>
      </tr>';
  }

?>
</table>
