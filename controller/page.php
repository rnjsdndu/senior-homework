<?php
get('/', function() {
  view('/home');
});

get('/join', function() {
  view('/join');
});

get('/login', function() {
  view('/login');
});

get('/check', function() {
  view('/check');
});

get('/rentalUserCheckCalendar', function() {
  view('rentalUserCheckCalendar');
});

get('/rentalUserCheckGraph', function() {
  view('rentalUserCheckGraph');
});

get('/libManage', function() {
  view('/libManage');
});

get('/userList', function() {
  view('/userList');
});

get('/my', function() {
  view('my');
});

get('/regiBook', function() {
  view('regiBook');
});

post('/rental', function() {
  view('/rental');
});

post('/userProfile', function() {
  view('userProfile');
});

get('/logout', function() {
  session_destroy();
  move('/', '로그아웃');
});

post('/joinBack', function() {
  extract($_POST);
  if(!$id || !$password) return move('/join', '빈칸');

  $num = preg_match("/\d/", $id);
  $en = preg_match('/[a-zA-Z]/', $id);
  $spe = preg_match('/[!@#$%^&*()|?\/]/', $password);

  $hasId = DB::fetch("select id from user where id = '$id'");

  if($hasId) return move('/join' ,'이미 있음');

  if(!$num || !$spe || !$en) return move('/join', '다시');

  DB::exec("insert into user (id, password, role) values ('$id', '$password', '일반')");
  move('/join', '성공');
});

post('/loginBack', function() {
  extract($_POST);

  if(!$id || !$password) return move('/login', '빈칸');
  $user = DB::fetch("select * from user where id = '$id'");
  if(!$user || $user -> password != $password) return move('/login', '틀림');

  $_SESSION['ss'] = $id;
  move('/','성공');
});

post('/rent', function() {
  extract($_POST);
  $ss = ss();
  $date = date('Y-m-d');
  $return = date('Y-m-d', strtotime('+7 days'));
  DB::exec("insert into rent (user_id, book_idx, status, rent_at, return_date) values ('$ss', '$idx', 'O', '$date', '$return')");
  DB::exec("update book set rent = 'O' where idx = '$idx'");
  DB::exec("update book set inventory = inventory -1 where idx = '$idx'");
  move('/rental', '대출');
});

post('/return', function() {
  extract($_POST);
  $ss = ss();
  DB::exec("update rent set status = 'X' where book_idx = '$idx' and user_id = '$ss' and status = 'O'");
  DB::exec("update book set rent = null where idx = '$idx'");
  DB::exec("update book set inventory = inventory + 1 where idx = '$idx'");
  move('/my', '반납');
});

post('/regiBack',function() {
  extract($_POST);

  $ss = ss();

  $tmp = $_FILES['cover']['tmp_name'];
  $image = $_FILES['cover']['name'];

  move_uploaded_file($tmp, "./books/" . $image);

  $user = DB::fetch("select * from user where id = '$ss'");
  $library = DB::fetch("select * from library where owner_idx = '$user->idx'");
  DB::exec("insert into book(library_idx, title, author, description, image, inventory) values('$library->idx', '$title', '$author', '$description', '$image', '$inventory')");
  move('/', '등록');
});

post('/libManageBack', function() {
  extract($_POST);
  $tmp = $_FILES['logo']['tmp_name'];
  $image = $_FILES['logo']['name'];
  $user = DB::fetch("select * from user where id = '$user_id'");
  $library = DB::fetch("select * from library where name = '$name'");
  if(!$user_id || !$name || !$image) return move('/libManage', '빈칸');
  if(!$user) return move('/libManage', '그런 유저 없느데');
  if($library) return move('/libManage', '이미 있는 도서관');
  move_uploaded_file($tmp, "./logo/$image");
  DB::exec("insert into library(name, owner_idx, image) values ('$name', '$user->idx', '$image')");
  DB::exec("update user set role = '서점 관리자' where id = '$user->id'");
  move('/libManage', '등록');
});

post('/deleteLib', function() {
  extract($_POST);
  DB::exec("delete from library where idx = '$library_idx'");
  move('/libManage', '삭제');
});
  
post('/libEditBack', function() {
  extract($_POST);
  $f = $_FILES['logo'] ?? 0;
  $image = $oldImage;
  $library = DB::fetch("select * from library where name = '$name'");
  $user = DB::fetch("select * from user where id = '$user_id'");
  if(!$user) return move('/libManage', '그런 유저 없느데');
  if($library) return move('/libManage', '이미 있는 도서관');
  
  if($f && $f['name']){
    $image=$f['name'];
    move_uploaded_file($f['tmp_name'], "./logo/$image");
  }

  if(!$image || !$user_id || !$name) return move('/libManage', '빈칸');

  DB::exec("update library set name = '$name', owner_idx = '$user_idx', image = '$image' where idx = '$library_idx'");
  move('/libManage','수정 완료');
});

post('/managerRegi', function() {
  extract($_POST);
  $tmp = $_FILES['logo']['tmp_name'];
  $image = $_FILES['logo']['name'];

  move_uploaded_file($tmp, "./logo/$image");

  if(!$libName || !$image || !$id || !$password) return move('/userList', '빈칸');

  DB::exec("insert into user (id, password, role) values ('$id', '$password', '서점 관리자')");
  $user_id = DB::fetch("select idx from user where id = '$id'") -> idx;
  DB::exec("insert into library (name, owner_idx, image) values('$libName', '$user_id', '$image')");

  move('/userList', '등록 완료');
});

get('/bookEdit', function() {
  view('/regiBook');
});

post('/editBack', function() {
  extract($_POST);
  $f = $_FILES['cover'] ?? 0;
  $image = $oldImage;
  if($f && $f['name']){
    $image=$f['name'];
    move_uploaded_file($f['tmp_name'], "./books/$image");
  }

  DB::exec("update book set title = '$title', author = '$author', description='$description', image='$image', inventory='$inventory' where idx = $idx");
  move('/regiBook', '수정');
  
});

post('/bookDelete', function() {
  extract($_POST);
  DB::exec("delete from book where idx = '$book_idx'");
  move('/regiBook', '삭제');
});
