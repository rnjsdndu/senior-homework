<?php
$lib = DB::fetchAll("select * from library");
foreach($lib as $l):
?>

<div>
  <?=$l->name?>
</div>

<br>
<?php endforeach;?>