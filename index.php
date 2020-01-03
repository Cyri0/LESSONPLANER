<!doctype html>
<html lang="hu">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <title>Óraterv készítő</title>
  </head>

  <body>
    <br>
      
    <div class="container">
        <div class="jumbotron" id="hero">
            <h1 class="display-4">Óratervező</h1>
            <hr class="my-2">
            <p class="lead">Készíts könnyen, gyorsan, egyszerűen óraterveket!</p>

            <button type="button" class="btn btn-light" onclick="setHint()">Hogyan működik?</button>
        </div>
        
        <div class="jumbotron" id="hint">
        <h4>Profil létrehozása</h4>
        <ol>
          <li>Hozz létre profilt az alapadatok kitöltésével!</li>
          <li>Mentsd el, így legközelebb is használhatod!</li>
        </ol>

        <h4>Tevékenység létrehozása</h4>
        <ol>
          <li>Adj hozzá egy új tevékenységet az óratervhez, vagy módosíts egy meglévőt!</li>
          <li>Mentsd el egy találó néven, így legközelebb is használhatod!</li>
        </ol>

        <h4>Óraterv elkészítése</h4>
        <ol>
          <li>Állítsd össze az óratervet a profil és a tevékenységek kiválasztásával!</li>
          <li>Mentsd el, és töltsd le PDF-ben!</li>
        </ol>
        </div>

        <div class="jumbotron">
            <h2>Alapadatok</h2>
            <div class="btn-group">
              <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mentett profilok
              </button>
              <div class="dropdown-menu" id="savedProfilesDropdown">
              
              <?php 
               $con = mysqli_connect('localhost', 'root', '');
               if(!$con) {die('Not Connected To Server'); }
               if(!mysqli_select_db($con, 'lessonplaner')) {echo 'Database Not Selected';}
               $con->set_charset('utf8');
               $sql="SELECT * FROM userdatas";
               $result = mysqli_query($con,$sql);
               while($row = mysqli_fetch_array($result)) {
                echo '<a class="dropdown-item" onclick="loadBasicDatas('.$row['ID'].')">'.$row['subject'].' ('.$row['date'].')</a>';
               }
               mysqli_close($con); 
              ?>


              </div>
            </div>
          
            <form id="basic_datas_form"  method="post">
              <table class="table table-light">
                  <tbody>
                      <tr>
                          <td class="col-2">A pedagógus neve:</td>
                          <td class="col-10"><input class="form-control input-sm" type="text" name="nameOfTheTeacher" id="nameOfTheTeacher"></td>
                      </tr>
                      <tr>
                          <td>Tantárgy:</td>
                          <td><input class="form-control input-sm" type="text" name="schoolSubject" id="schoolSubject"></td>
                      </tr>
                      <tr>
                          <td>Osztály:</td>
                          <td><input class="form-control input-sm" type="text" name="schoolClass" id="schoolClass"></td>
                      </tr>
                      <tr>
                          <td>Az óra témája:</td>
                          <td><input class="form-control input-sm" type="text" name="subjectTheme" id="subjectTheme"></td>
                      </tr>
                      <tr>
                          <td>Az óra cél és feladatrendszere:</td>
                          <td><input class="form-control input-sm" type="text" name="subjectGoals" id="subjectGoals"></td>
                      </tr>
                      <tr>
                          <td>Az óra didaktikai feladatai:</td>
                          <td><input class="form-control input-sm" type="text" name="subjectDidactics" id="subjectDidactics"></td>
                      </tr>
                      <tr>
                          <td>Tantárgyi kapcsolatok:</td>
                          <td><input class="form-control input-sm" type="text" name="subjectRelationships" id="subjectRelationships"></td>
                      </tr>
                      <tr>
                          <td>Felhasznált források:</td>
                          <td><input class="form-control input-sm" type="text" name="usedSources" id="usedSources"></td>
                      </tr>
                      <tr>
                          <td>Dátum:</td>
                          <td><input class="form-control input-sm" type="date" name="date" id="date"></td>
                      </tr>
                  </tbody>
              </table>
              <button class="btn btn-dark" type="submit">Profil mentése</button>
            </form>
       </div>
            <h2>Óraterv</h2>
            <div class="btn-group" id="activityDropdown" >
              <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Tevékenység hozzáadása
              </button>
              <div class="dropdown-menu" id="savedProfilesDropdown">

              <?php 
                $con = mysqli_connect('localhost', 'root', '');
                if(!$con) {die('Not Connected To Server'); }
                if(!mysqli_select_db($con, 'lessonplaner')) {echo 'Database Not Selected';}
                $con->set_charset('utf8');
                $sql="SELECT * FROM activities";
                $result = mysqli_query($con,$sql);
                while($row = mysqli_fetch_array($result)) {
                  echo '<a class="dropdown-item" onclick="gimmeNewSpecialLine('.$row['ID'].')">'.$row['name'].'</a>';
                }
                mysqli_close($con); 
              ?>

              </div>
            </div>
            
            <div class="container" id="lessonPlan">
            <form id="lesson_plan_form" method="post">
                <div class="d-none d-xl-block d-lg-block d-md-block">
                  <div class="row">
                    
                    <div class="col-sm">
                      Idő
                    </div>
                    <div class="col-sm">
                      Óra menete
                    </div>
                    <div class="col-sm">
                      Módszerek
                    </div>
                    <div class="col-sm">
                      Munkaformák
                    </div>
                    <div class="col-sm">
                      Eszközök
                    </div>
                    <div class="col-sm">
                      Megjegyzések
                    </div>
                  </div>
                </div>
            </form>
            </div>
            
            <div class="jumbotron">
              <div id="availableTime">45/45</div>
              <button style="float: right; width: 50px; height: 50px;"  class="btn btn-dark" onclick="gimmeNewLine()">+</button>
              <div style="width: 100%; float: left; margin-top: 20px;">
                <button style="float: right; width: 200px; height: 50px; margin-bottom: 20px;"  class="btn btn-dark" onclick="generatePDF()">Óraterv létrehozása</button>
              </div>
            </div>


            <div class="jumbotron" id="myFooter">
              <p class="lead"><b>Készítette:</b><br>Nemes Tamás</p>
              <hr>
              <p class="lead"><b>Elérhetőség:</b><br>nemestamas94@gmail.com</p>
            </div>
    </div>






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/saveDatas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>