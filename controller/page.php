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

get('/rental', function() {
  view('/rental');
});

get('/logout', function() {
  session_destroy();
  move('/', '로그아웃 ㅋ');
});

post('/rent', function() {
  extract($_POST);
  $ss = ss();
  DB::exec("insert into rent (user_id, book_idx, status) values ('$ss', '$idx', 'O')");
  DB::exec("update book set rent = 'O' where idx = '$idx'");
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
  move('/my', '반납 ㅋ');
});

get('/regiBook', function() {
  view('regiBook');
});

