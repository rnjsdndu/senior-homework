<?php 
$library = DB::fetchAll("
  select u.id, l.name, l.image, l.idx
  from library l
  join user u
  on l.owner_idx = u.idx
");

$getIdx = $_GET['library_idx'] ?? 0;
$update = $getIdx ?  DB::fetch("select u.idx user_idx, u.id, l.name, l.image, l.idx from library l join user u on l.owner_idx = u.idx where l.idx = '$getIdx'"): null;
?>
<div>
  <h1>서점 <?=$getIdx ? '수정':'등록'?></h1>
  <form method="post" enctype="multipart/form-data">
    <p>관리자 아이디</p><input type="text" name="user_id" value="<?=$update -> id ?? ''?>" placeholder="<?= $getIdx ? '수정할 ': ''?> 관리자로 등록할 유저의 아이디를 적어주세요!"> <br>
    <p>서점 이름</p><input type="text" name="name" value="<?=$update -> name ?? ''?>" placeholder="<?=$getIdx ? '수정할': ''?>서점 이름을 적어주세요!"> <br>
    <input type="hidden" name="user_idx" value="<?=$update -> user_idx ?? ''?>">
    <?php if($getIdx):?>
      <p>현재 로고</p> <img src="./logo/<?=$update -> image ?? ''?>" alt="<?=$update -> name ?? ''?>" title="<?=$update -> name ?? ''?>">
      <input type="hidden" name="oldImage" value="<?=$update -> image ?? ''?>">
    <?php endif;?>
    <p><?=$getIdx ? '새':''?>서점 로고</p><input type="file" name="logo"><br>
    <input type="hidden" name="library_idx" value="<?=$getIdx?>">
    <button formaction="<?=$getIdx ? '/libEditBack':'/libManageBack'?>"><?=$getIdx ? '수정': '등록'?></button>
  </form>
  <h1>서점 리스트</h1>

  <?php foreach($library as $l):?>
  <form method="get">
    <h3>관리자: <?=$l -> id?></h3>
    <h3>서점 이름: <?=$l -> name?></h3>
    <img src="./logo/<?=$l -> image?>" alt="<?=$l -> name?>" title="<?=$l -> name?>">
    <input type="hidden" name="user_id" value="<?=$l->id?>">
    <input type="hidden" name="library_idx" value="<?=$l->idx?>">
    <input type="hidden" name="library_name" value="<?=$l->name?>">
    <input type="hidden" name="library_logo" value="<?=$l->image?>">
    <button type="submit" formaction="/libManage" formmethod="get">수정</button>
    <button type="submit" formaction="/deleteLib" formmethod="post">삭제</button>
  </form>
  <?php endforeach;?>
</div>