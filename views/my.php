<?php
$ss = ss();
$userBook = DB::fetchAll("
select b.title, b.author, r.book_idx, r.status from rent r
join book b
on b.idx = r.book_idx
where r.user_id = '$ss' 
");
foreach($userBook as $u):
?>

<form action="/return" method="post">
  <input type="hidden" name="idx" value="<?=$u -> book_idx?>">
  <p>제목: <?=$u->title?></p>
  <p>작가: <?=$u->author?></p>
  <button <?=$u -> status == 'O' ? '' : 'disabled'?>><?=$u -> status == 'O' ? '반납' : '반납됨 ㅋ'?></button>
</form>

<?php endforeach;?>