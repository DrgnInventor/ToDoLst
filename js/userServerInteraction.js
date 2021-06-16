function toDoToggle(id){

    var status = document.getElementById("1B").className
    var data = {
        'process' : "doneButton",
        'id' : id,
        'isDone' : status
    }
    var dataStr = JSON.stringify(data);
    $.ajax({
        url: '',
        type: 'post',
        data: {data: dataStr},
        success: function(isDone){
            switch(isDone){
                case 0:
                    document.getElementById(id).classList.remove("IsDone");
                    document.getElementById(id).classList.add("IsDoneF");
                case 1:
                    document.getElementById(id).classList.remove("IsDoneF");
                    document.getElementById(id).classList.add("IsDone"); 
            }
            
        }
    })
}

