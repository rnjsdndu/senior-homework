<?php 
$user = DB::fetchAll("select * from user where not role = '관리자'");
?>

<h1>유저 리스트 조회</h1>
  

<?php foreach($user as $u):?>
<div>
  <p><?=$u -> id?></p>
  <p><?=$u -> role?></p>
</div>
<?php endforeach;?>

<h1>서점 관리자 등록</h1>
<form action="/managerRegi" method="post" enctype="multipart/form-data">
  <input type="text" placeholder="도서관 이름" name="libName">
  <input type="file" name="logo">
  <input type="text" placeholder="관리자 아이디" name="id">
  <input type="text" placeholder="비밀번호" name="password">
  <button>등록</button>
</form>