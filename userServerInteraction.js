function toDoToggle(id){

    var data = {
        'process' : "doneButton",
        'id' : id
    }

    var dataStr = JSON.stringify(data);
    console.log({data: dataStr});
    $.post('php_logic/jsReqLogic.php', {data: dataStr}, function(isDone) {
        console.log("Response: "+ isDone);
        if (isDone == 1){
            document.getElementById(id + "B").className = "IsDone"
        } else {
            document.getElementById(id + "B").className = "IsDoneF"
        }
    });
}