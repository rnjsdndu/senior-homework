<?php
$lib = DB::fetchAll("select l.name, l.idx from library l join book b on b.library_idx = l.idx");
foreach($lib as $l):
?>
<form action="/rental" method="post">
  <?=$l->name?>
  <input type="hidden" name="idx" value="<?=$l->idx?>">
  <button>책 목록보기</button>
</form>
<br>
<?php endforeach;?>