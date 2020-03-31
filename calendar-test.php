<?php include("lib/core.lib.php"); 
$core = new coreLIB;
$lday=0;
$church_date = '';
if(isset($_POST['church-date'])){
  $church_date = $_POST['church-date'];
  list($year, $month, $day) = explode("-", $church_date);

}else{
  $x = getDate(); 
  $year=$x['year']; 
  $month=$x['mon']; 
  $day=$x['mday']; 
}

$jd = gregoriantojd($month, $day, $year);
$dow=date("w", mktime(0, 0, 0, $month, $day, $year));
$d = cal_from_jd($jd, CAL_GREGORIAN);

?><!DOCTYPE html>
<html lang="en">
<head>
<title>Calendar Test</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="calendar.css" />
<script type="text/javascript" src="calendar.js"></script>
</head>
<body>
<form name="exec" method="post" action="readings.php">
<input type="hidden" name="sDay" value="<?php print $day; ?>" />
<input type="hidden" name="sMonth" value="<?php print $month; ?>" />
<input type="hidden" name="sYear" value="<?php print $year; ?>" />
<input type="hidden" name="cday" value="" />
<input type="hidden" name="rdng" value="" />
</form>

<div style="float:right; text-align:right; width:540px;">
<form method="post" name="fatesearch" onsubmit="return verYear(this);" action="calendar-test.php">
  <input type="date" name="church-date" />
<input type="submit" value="Go" /></p>
</form>
</div>

<h2><?php print "{$d['monthname']} {$d['day']}, {$d['year']}"; ?></h2>

<?php 

  $a = $core->calculateDay($d['month'], $d['day'], $d['year']);
  $dayKeys = array_keys($a);
  $dayKeyCount = count($dayKeys);
  print "<ul>";
  for ($j=0; $j<=$dayKeyCount; $j++)
  {
    print "<li>{$dayKeys[$j]} &nbsp; {$a[$dayKeys[$j]]} </li>";
  } 
  print "</ul>";

  $xr=$core->retrieveReadings($a);


  ?>

</body>
</html>
