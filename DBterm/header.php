<div id="header">
    <div class="inner">
      <div class="logo">
        <img src="./logo.png" onclick="location.href = '.'">
      </div>
      <div class="search">
        <form action="search.php" method="GET">
          <input type="text" id="search" name="search" placeholder="교수명 과목명 학수번호로 검색,하자고 어서!">
          <button type="submit" id="search_btn">search</button>
        </form>
      </div>
      <div class="menu">
        <?php 
          if($_SESSION["id"]==="admin"){?>
            <div class="admin" onclick="location.href = './admin.php'">
              데이터 추가
            </div>
          <?php }
         ?>
        <div class="info">
          <?php
          echo $_SESSION["nick"]."님 반갑습니다."
          ?>
        </div>
        <div class="logout" onclick="location.href = './logout.php'">
          로그아웃
        </div>
      </div>
    </div>  
  </div>