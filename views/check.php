<?php
$lib = DB::fetchAll("select name, idx from library");
foreach($lib as $l):
?>
<form action="/rental" method="post">
  <?=$l->name?>
  <input type="hidden" name="idx" value="<?=$l->idx?>">
  <button>책 목록보기</button>
</form>
<br>
<?php endforeach;?>