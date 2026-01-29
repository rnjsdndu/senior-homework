<?php 
get('/',function(){
  view('/home');
});

get('/join', function() {
  view('/join');
});

get('/login', function() {
  view('/login');
});

post('/joinBack', function() {
  extract($_POST);
  if(!$id || !$password) return move('/', '빈칸');

  $num = preg_match("/\d/", $id);
  $en = preg_match('/[a-zA-Z]/', $id);
  $spe = preg_match('/[!@#$%^&*()|?\/]/', $password);

  if(!$num || !$spe || !$en) return move('/', '다시');

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

get('/check', function() {
  view('/check');
});

post('/rental', function() {
  
  view('/rental');
  
});

get('/logout', function() {
  session_destroy();
  move('/', '로그아웃 ㅋ');
});

post('/rent', function() {
  extract($_POST);
  $ss = ss();
  $date = date('Y-m-d');
  $return = date('Y-m-d', strtotime('+7 days'));
  DB::exec("insert into rent (user_id, book_idx, status, rent_at, return_date) values ('$ss', '$idx', 'O', '$date', '$return')");
  DB::exec("update book set rent = 'O' where idx = '$idx'");
  DB::exec("update book set inventory = inventory -1 where idx = '$idx'");
  move('/rental', '대출 ㅋ');
});

get('/my',function() {
  view('my');
});

post('/return', function() {

  extract($_POST);
  $ss = ss();
  DB::exec("update rent set status = 'X' where book_idx = '$idx' and user_id = '$ss' and status = 'O'");
  DB::exec("update book set rent = null where idx = '$idx'");
  DB::exec("update book set inventory = inventory + 1 where idx = '$idx'");
  move('/my', '반납 ㅋ');
});

get('/regiBook', function() {
  view('regiBook');
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
  move('/', '등록 ㅗ');
});

get('/rentalUserCheckCalendar', function() {
  view('rentalUserCheckCalendar');
});

get('/rentalUserCheckGraph', function() {
  view('rentalUserCheckGraph');
});

post('/userProfile', function() {
  view('userProfile');
});