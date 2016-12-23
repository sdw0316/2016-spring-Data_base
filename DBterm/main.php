<?php 
  /*로그인 상태 아니면 로그인 페이지로*/
  session_start();
  if(!isset($_SESSION["id"])){
    header('Location: ./');
  }
  include("./database.php");
  $conn = initDB();
  $evalq = "(select index, course_name, instructor_id, account_id, rate, comment from evaluation natural join course)";
  $evalq = "(select index, course_name, instructor_name, account_id, rate, comment from $evalq as S natural join instructor)";
  $evalq = "(select index, account_id, course_name, instructor_name, user_name, rate, comment from $evalq as T natural join account order by index desc)";
  $evalresult = pg_query($conn, $evalq);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>메인 페이지</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/jquery-1.12.4.min.js"></script>
  <style>
    .left>.notice{
      line-height: 45px;
    }
    .left > h2{
      padding-left : 40px;
      text-align: left;
    }
    .eval{
      padding-bottom:20px;
    }
    .eval div{
      margin-top: 20px;
    }
    .rate{
      font-size:18pt;
    }
    .edit_wrap{
      text-align: right;
    }
    .edit_wrap span{
      margin-left : 20px;
      cursor: pointer
    }
    .edit_wrap span:hover{
      color: #CCC;
    }
  </style>
</head>
<body>
  <?php include("./header.php") ?>
  <div id="content">
    <div class="left">
      <div class="box notice">
        <h2>공지사항, 보라고 어서!</h2>
        <p>
          <strong>설명충</strong><br>
          2016 데이터 베이스 텀 프로젝트입니다.<br>
          검색을 통해 현재 데이터 베이스에 등록 된 강의 목록을 볼 수 있습니다. <br>
          <strong>만든이 : 2014210056 송도원</strong><br>
        </p>
      </div>
      <h2>최근 평가</h2>
      <?php for($i=0;$i<5;$i++){ $eval = pg_fetch_assoc($evalresult)?>
      <div class="box eval">
        <div class="top">
          <div class="name_wrap">
            <h2><?=$eval["course_name"]?></h2>
          </div>
          <div class="prop_wrap">
            <strong>교수명 </strong><?=$eval["instructor_name"]?>
          </div>
        </div>
        <div class="account">
          <strong><?=$eval["user_name"]?></strong> <span style="font-size:9pt">님의 의견</span>
        </div>
        <div class="rate_wrap">
          <strong>점수 </strong><span class="rate"><?=$eval["rate"]?></span>
        </div>
        <div class="comment">
          <?=$eval["comment"] ?>
        </div>
        <?php 
          /*자기가 쓴거거나, 관리자로 접속시에만 수정 삭제 가능*/
          if($eval["account_id"] === $_SESSION["id"] || $_SESSION["id"] === "admin"){
         ?>
        <div class="edit_wrap">
          <span class="update">
            <input type="hidden" value="<?=$eval["index"]?>">
            수정
          </span>
          <span class="delete">
            <input type="hidden" value="<?=$eval["index"]?>">
            삭제
          </span>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    <?php include("./right.php") ?>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copyright">2016 DB <strong>Term Project</strong></div>
    </div>
  </div>
  <script src="./js/lecture.js"></script></body>
</html>