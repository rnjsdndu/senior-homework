<?php 
extract($_POST);

$userBook = DB::fetchAll("
select l.name, b.title, b.author, r.book_idx, r.status, r.rent_at, r.return_date from rent r
join book b
on b.idx = r.book_idx
join library l
on b.library_idx = l.idx
where r.user_id = '$user_id' 
");
?>
<h1><?=$user_id?>님의 프로필</h1>
<?php foreach($userBook as $u):?>
<div>
  <p>서점: <?=$u -> name?></p>
  <p>제목: <?=$u->title?></p>
  <p>작가: <?=$u->author?></p>
  <p>대출기간: <?=$u -> rent_at?> ~ <?=$u -> return_date?></p>
  <p>----------------------------------------</p>
</div>
<?php 
endforeach;
?>