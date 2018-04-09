<?php
include_once('connvar.php');
$q=$_GET["q"];
//$q='PAT000008';
	$sql1=mysql_query("SELECT * FROM patient WHERE patientid = \"$q\"");
	while($row2=mysql_fetch_array($sql1)){
	$sex = $row2['sex'];
	$blood_group = $row2['blood_group'];
	$birth_date = $row2['birth_date'];
	$cardno = $row2['cardno'];
	$age = $row2['age'];
	$patitype = $row2['patitype'];
 echo $data = "<table width=\"60%\" border=\"0\">
  <tr height=\"20\">
    <td>&nbsp;</td>
    <td>Sex:  $sex</td>
    <td>&nbsp;</td>
    <td>Blood Grp: $blood_group</td>
  </tr>
  <tr height=\"60\">
     <td>&nbsp;</td>
   <td>D.O.B: $birth_date</td>
    <td>&nbsp;</td>
    <td>Age: $age</td>
  </tr>
  <tr height=\"20\">
    <td width=\"150\">&nbsp;</td>
    <td>Card No: $cardno</td>
      <td>&nbsp;</td>
  <td>Patient Type: $patitype</td>
  </tr>
</table>";
  } ?>