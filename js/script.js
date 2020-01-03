var num=1;
var liveLines = [];

function gimmeNewLine() {
    var container = document.createElement("div");
    var newLineToTable = `
        <div id="line`+num+`">
            <div class="row">
                <div class="d-md-none">
                    <div style="width: 50px; height: 50px; background-color: transparent;"></div>
                </div>

                <div class="col-md">
                    <div class="d-md-none">Idő</div>
                    <input class="form-control input-md" onChange="getAvailableTime()" value="0" type="number"  min="0" max="45" name="time`+num+`" id="time`+num+`">
                </div>

                <div class="col-md">
                    <div class="d-md-none">Óra menete</div>
                    <textarea class="form-control textarea-sm" rows="1" id="lesson`+ num +`"></textarea>
                </div>

                <div class="col-md">
                    <div class="d-md-none">Módszerek</div>
                    <textarea class="form-control textarea-sm" rows="1" id="method`+ num +`"></textarea>
                </div>

                <div class="col-md">
                    <div class="d-md-none">Munkaformák</div>
                    <textarea class="form-control textarea-sm" rows="1" id="workforms`+ num +`"></textarea>
                </div>

                <div class="col-md">
                    <div class="d-md-none">Eszközök</div>
                    <textarea class="form-control textarea-sm" rows="1" id="tools`+ num +`"></textarea>
                </div>

                <div class="col-md">
                    <div class="d-md-none">Megjegyzések</div>
                    <textarea class="form-control textarea-sm" rows="1" id="notes`+ num +`"></textarea>
                </div>
                
                <img class="miniButt" src="img/delete.png" onclick="deleteLine(`+num+`)">
                <img class="miniButt" src="img/save.png" onclick="saveLine(`+num+`)">
            </div>
        </div>
    `;
    container.innerHTML = newLineToTable;
    liveLines.push(num);
    num++;
    document.getElementById("lessonPlan").appendChild(container);
}
gimmeNewLine();

function getAvailableTime(){
    var time = 0;
    var actualTime = 0;

    for(var i = 1; i <= num; i++){
        if(document.getElementById("time"+i) != null){
         actualTime = document.getElementById("time"+i).value;
         time = time + (actualTime * 1);
        }
    }

    
    var availableTime = 45 - time;

    document.getElementById("availableTime").innerHTML = availableTime + "/45";
    
    document.getElementById("availableTime").style.backgroundColor = "#343a40";

    if(availableTime<0){
        document.getElementById("availableTime").style.backgroundColor = "red";
    }
}

function arrayRemove(arr, value) {
    return arr.filter(function(ele){
        return ele != value;
    });
}
 
function deleteLine(wantToDelete){
    var element = document.getElementById("line"+wantToDelete);
    element.parentNode.removeChild(element);
    getAvailableTime();
    liveLines = arrayRemove(liveLines, wantToDelete);
}

function saveLine(wantTosave){
    var savename = prompt("Adjon meg egy nevet!", "");
    var time = document.getElementById("time"+wantTosave).value;
    var lesson = document.getElementById("lesson"+wantTosave).value;
    var method = document.getElementById("method"+wantTosave).value;
    var workforms = document.getElementById("workforms"+wantTosave).value;
    var tools = document.getElementById("tools"+wantTosave).value;
    var notes = document.getElementById("notes"+wantTosave).value;

    $(function () 
    {
      $.ajax({                                      
        url: 'saveActivities.php',    
        data: 'name='+savename + '&time='+time + '&lesson='+lesson + '&method='+method+'&workforms='+workforms+'&tools='+tools+'&notes='+notes,
        dataType: 'json',  
        success: function(data)
        {
            alert("A/Az " + wantTosave + ". tevékenység a mentve, " + savename + " néven!");
        } 
      });
    });
}

function gimmeNewSpecialLine(id) {
    $(function () 
    {
      $.ajax({                                      
        url: 'loadActivity.php',       
        data: 'lineID='+id,
        dataType: 'json',    
        success: function(data)
        {
            var time = data[2];
            var lesson = data[3];
            var method = data[4];
            var workforms = data[5];
            var tools = data[6];
            var notes = data[7];

            var container = document.createElement("div");
            var newLineToTable = `
                <div id="line`+num+`">
                    <div class="row">
                        <div class="d-md-none">
                        <hr class="my-2">
                        </div>
                        <div class="col-md">
                            <div class="d-md-none">Idő</div>
                            <input class="form-control input-md" onChange="getAvailableTime()" value="`+time+`" type="number"  min="0" max="45" name="time`+num+`" id="time`+num+`">
                        </div>
        
                        <div class="col-md">
                            <div class="d-md-none">Óra menete</div>
                            <textarea class="form-control textarea-sm" rows="1" id="lesson`+ num +`">`+lesson+`</textarea>
                        </div>
        
                        <div class="col-md">
                            <div class="d-md-none">Módszerek</div>
                            <textarea class="form-control textarea-sm" rows="1" id="method`+ num +`">`+method+`</textarea>
                        </div>
        
                        <div class="col-md">
                            <div class="d-md-none">Munkaformák</div>
                            <textarea class="form-control textarea-sm" rows="1" id="workforms`+ num +`">`+workforms+`</textarea>
                        </div>
        
                        <div class="col-md">
                            <div class="d-md-none">Eszközök</div>
                            <textarea class="form-control textarea-sm" rows="1" id="tools`+ num +`">`+tools+`</textarea>
                        </div>
        
                        <div class="col-md">
                            <div class="d-md-none">Megjegyzések</div>
                            <textarea class="form-control textarea-sm" rows="1" id="notes`+ num +`">`+notes+`</textarea>
                        </div>
                        
                        <img class="miniButt" src="img/delete.png" onclick="deleteLine(`+num+`)">
                        <img class="miniButt" src="img/save.png" onclick="saveLine(`+num+`)">
                    </div>
                </div>
            `;
            container.innerHTML = newLineToTable;
            liveLines.push(num);
            num++;
            document.getElementById("lessonPlan").appendChild(container);
            getAvailableTime();
        } 
      });
    });
}

function addNewDropdownItem(name, id){
    var container = document.createElement("div");
    container.innerHTML = '<a class="dropdown-item" href="#" onclick="loadBasicDatas('+id+')">'+name+'</a>';
    
    document.getElementById("savedProfilesDropdown").appendChild(container); 
}

function loadBasicDatas(id){
    $(function () 
    {
      $.ajax({                                      
        url: 'loadBasics.php',     
        data: 'id='+id,
        dataType: 'json',
        success: function(data)
        {
          document.getElementById("nameOfTheTeacher").value = data[0];
          document.getElementById("schoolSubject").value = data[2];
          document.getElementById("schoolClass").value = data[3];
          document.getElementById("subjectTheme").value = data[4];
          document.getElementById("subjectGoals").value = data[5];
          document.getElementById("subjectDidactics").value = data[6];
          document.getElementById("subjectRelationships").value = data[7];
          document.getElementById("usedSources").value = data[8];
          document.getElementById("date").value = data[9];
        } 
      });
    }); 
}

function generatePDF(){

    liveLines.forEach(saveActualLines);

    var teacher = document.getElementById("nameOfTheTeacher").value;
    var schoolSubject = document.getElementById("schoolSubject").value;
    var schoolClass = document.getElementById("schoolClass").value;
    var subjectTheme = document.getElementById("subjectTheme").value;
    var subjectGoals = document.getElementById("subjectGoals").value;
    var subjectDidactics = document.getElementById("subjectDidactics").value;
    var subjectRelationships = document.getElementById("subjectRelationships").value;
    var sources = document.getElementById("usedSources").value;
    var date = document.getElementById("date").value;

    window.open("generatePDF.php?"+'teacher='+teacher + 
    '&subject='+schoolSubject + 
    '&schoolClass='+schoolClass + 
    '&theme='+subjectTheme+
    '&goals='+subjectGoals+
    '&didactics='+subjectDidactics+
    '&relationships='+subjectRelationships+
    '&sources='+sources+
    '&date='+date);
}

function setHint(){
    if(document.getElementById("hint").style.display != "block"){
        document.getElementById("hint").style.display = "block";
    } else {
        document.getElementById("hint").style.display = "none";
    }  
}

function saveActualLines(wantTosave,index){

    alert(wantTosave);
    var savename = "AUTO";
    var time = document.getElementById("time"+wantTosave).value;
    var lesson = document.getElementById("lesson"+wantTosave).value;
    var method = document.getElementById("method"+wantTosave).value;
    var workforms = document.getElementById("workforms"+wantTosave).value;
    var tools = document.getElementById("tools"+wantTosave).value;
    var notes = document.getElementById("notes"+wantTosave).value;

    $(function () 
    {
      $.ajax({                                      
        url: 'saveActualActivities.php',    
        data: 'name='+savename + '&time='+time + '&lesson='+lesson + '&method='+method+'&workforms='+workforms+'&tools='+tools+'&notes='+notes,
        dataType: 'json',  
        success: function(data)
        {
            alert("A/Az " + wantTosave + ". tevékenység a mentve, " + savename + " néven!");
        } 
      });
    });
}