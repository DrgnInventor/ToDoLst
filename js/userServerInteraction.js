function toDoToggle(id){

    var status = document.getElementById("1B").className
    var data = {
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
                    document.getElementById(id).classList.add("IsDoneF");
                    document.getElementById(id).classList.remove("IsDone");
                case 1:
                    document.getElementById(id).classList.add("IsDone");
                    document.getElementById(id).classList.remove("IsDoneF");
            }
            
        }
    })
}

