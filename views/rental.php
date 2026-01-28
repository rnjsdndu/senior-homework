<?php 
extract($_POST);
$ss = ss();
$book = DB::fetchAll("select * from book where library_idx = '$idx'");
foreach($book as $b):
$rent = DB::fetch("select * from rent where user_id = '$ss' and status = 'O' and book_idx = '$b->idx'") ?: 0;
?>

<form action="/rent" method="post">
  <input type="hidden" name="idx" value="<?=$b->idx?>">
  <p>제목: <?=$b -> title?></p>
  <p>작가: <?=$b -> author?></p>
  <p>재고: <?=$b -> inventory?>권</p>
  <?php if($b-> inventory == '0'):?>
  <button disabled>재고없음</button>
  <?php elseif($rent):?>
  <button disabled>대출중</button>
  <?php else:?>
  <button>대출하기</button>
  <?php endif; ?>
</form>

<?php endforeach;?>