<?php
$year = (int)($_GET['y'] ?? date('Y'));
$month = (int)($_GET['m'] ?? date('n'));

$firstDay = (new DateTimeImmutable)->setDate($year, $month, 1);

$padding = (int)$firstDay->format('w');
$days    = (int)$firstDay->format('t');
$cell    = (int)(ceil(($padding + $days) / 7) * 7);

$prev = $firstDay->modify('-1 month');
$next = $firstDay->modify('+1 month');

$week = ['일','월','화','수','목','금','토'];
$today = (new DateTimeImmutable('today'))->format('Y-m-d');


?>

<table>
  <tr>
    <?php foreach($week as $w):?>
      <th><?=$w?></th>
    <?php endforeach;?>
  </tr>

  <?php
  for($i=0; $i<$cell; $i++){
  if($i%7==0) echo "<tr>";

  $day = $i - $padding + 1;

  if($day < 1 || $day > $days){
    echo "<td class='dim'></td>";
  } else {
    $ds  = $firstDay->setDate($year, $month, $day)->format('Y-m-d');
    $cls = $ds === $today ? 'today' : '';
    echo "<td class='$cls'>$day</td>";
  }

  if($i%7==6) echo "</tr>";
  }
  ?>
</table>