<?php 
$book = DB::fetchAll("select * from book");
foreach($book as $b):?>

<form action="/rent" method="post">
  <input type="hidden" name="idx" value="<?=$b->idx?>">
  <p>제목: <?=$b -> title?></p>
  <p>작가: <?=$b -> author?></p>
  <button <?= $b->rent ? 'disabled' : ''?>><?=$b->rent ? '대출중 ㅋ':'대출'?></button>
</form>

<?php endforeach;?>