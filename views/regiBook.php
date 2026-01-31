<?php 
  $getIdx = $_GET['book_idx'] ?? 0;

  $update = $getIdx ? DB::fetch("select * from book where idx = '$getIdx'") : null;

?>

<form method="post" enctype="multipart/form-data">
  <div>이름: <input type="text" name="title" value="<?=$update -> title ?? ''?>"></div> 
  <div>작가: <input type="text" name="author" value="<?=$update -> author ?? ''?>"></div> 
  <div>내용: <textarea type="text" name="description"><?=$update -> description ?? ''?></textarea></div> 
  <input type="hidden" name="idx" value="<?=$getIdx?>">
  <div>표지: 
    <?php if($update):?>
      <img src="./books/<?=$update -> image?>" alt="">
      <input type="hidden" name="oldImage" value="<?=$update -> image?>">
      <?php endif ?>
    <input type="file" name="cover">
  </div> 
  <div>수량: <input type="number" name="inventory" min="1" value="<?=$update -> inventory ?? ''?>"></div> 
  <button formaction="<?=$update ? '/editBack': '/regiBack'?>"><?=$update ? '수정': '등록'?></button>
</form>

<?php 
$ss = ss();
$books = DB::fetchAll("
select b.image, b.title, b.author, b.idx
from library l
join user u
on u.idx = l.owner_idx
join book b
on l.idx = b.library_idx
where u.id = '$ss';
");

?>

<h1>책 조회</h1>
<?php foreach($books as $b): ?>
  <form enctype="multipart/form-data">
    <img src="./books/<?=$b->image?>" alt="" style="width:150px;">
    <p><?=$b->title?></p>
    <p><?=$b->author?></p>
    <input type="hidden" name="book_idx" value="<?=$b -> idx?>">
    <button formmethod="get" formaction="/bookEdit">수정</button>
    <button formmethod="post" formaction="/bookDelete">삭제</button>
  </form>
<?php endforeach; ?>