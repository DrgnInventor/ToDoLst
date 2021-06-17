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
            document.getElementById(id + "B").className = "IsDone";
            location.reload();
        } else {
            document.getElementById(id + "B").className = "IsDoneF";
            location.reload();
        }
    });
}

function deleteEntry(id){

    var data = {
        'process' : "deleteButton",
        'id' : id
    }

    var dataStr = JSON.stringify(data);

    console.log({data: dataStr});

    $.post('php_logic/jsReqLogic.php', {data: dataStr}, function(deleted) {
        console.log("Response: "+ deleted);
        if (deleted){
            location.reload();
        } else {
            console.log("Cant be deleted, something broke.")
            location.reload();
        }
    });
}