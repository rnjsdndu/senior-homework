<form action="/regiBack" method="post" enctype="multipart/form-data">
  <div>이름: <input type="text" name="title"></div> 
  <div>작가: <input type="text" name="author"></div> 
  <div>내용: <textarea type="text" name="description"></textarea></div> 
  <div>표지: <input type="file" name="cover"></div> 
  <div>수량: <input type="number" name="inventory" min="1"></div> 
  <button>등록</button>
</form>