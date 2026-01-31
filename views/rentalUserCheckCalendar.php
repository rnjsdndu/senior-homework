<?php
$year=(int)($_GET['y']??date('Y'));
$month=(int)($_GET['m']??date('n'));

$firstDay=(new DateTimeImmutable)->setDate($year,$month,1);
$prev=$firstDay->modify('-1 month');
$next=$firstDay->modify('+1 month');

function q($y,$m){
  $g=$_GET;
  $g['y']=$y; $g['m']=$m;
  return '?'.http_build_query($g);
}

$padding=(int)$firstDay->format('w');
$days=(int)$firstDay->format('t');
$cell=(int)(ceil(($padding+$days)/7)*7);

$week=['일','월','화','수','목','금','토'];
$today=(new DateTimeImmutable('today'))->format('Y-m-d');

$start=$firstDay->format('Y-m-01');
$end=$firstDay->modify('+1 month')->format('Y-m-01');

$rents=DB::fetchAll("
  SELECT r.user_id, b.title, DATE(r.rent_at) d
  FROM rent r
  JOIN book b ON b.idx=r.book_idx
  WHERE r.status='O'
    AND r.rent_at IS NOT NULL
    AND r.rent_at>='$start' AND r.rent_at<'$end'
");

$map=[];
foreach($rents as $r) $map[$r->d][]=[$r->user_id,$r->title];
?>

<div class=flex>
  <a class=nav href="<?=q((int)$prev->format('Y'),(int)$prev->format('n'))?>">◀</a>
  <h1><?=$firstDay->format('Y년 n월')?></h1>
  <a class=nav href="<?=q((int)$next->format('Y'),(int)$next->format('n'))?>">▶</a>
</div>

<table>
  <tr><?php foreach($week as $w) echo "<th>$w</th>";?></tr>
<?php
for($i=0;$i<$cell;$i++){
  if($i%7==0) echo "<tr>";
  $day=$i-$padding+1;

  if($day<1||$day>$days) echo "<td class=dim></td>";
  else{
    $ds=$firstDay->setDate($year,$month,$day)->format('Y-m-d');
    $cls=($ds===$today?'today':'').(isset($map[$ds])?' rentday':'');
    $ui="<div class=day>$day</div>";

    if(isset($map[$ds])){
      [$u,$t]=$map[$ds][0];
      $ui.="<form class=day action=/userProfile method=post>
              <input type=hidden name=user_id value='$u'>
              <button class=rent>$u · $t</button>
            </form>";
    }
    echo "<td class='$cls'>$ui</td>";
  }

  if($i%7==6) echo "</tr>";
}
?>
</table>
