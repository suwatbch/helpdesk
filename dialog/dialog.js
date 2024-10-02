var folder_dialog = web_root + "/dialog";

function sale_group_dialog(id){
    var uri = folder_dialog + "/sale_group.php?id="+id;
    return open_dialog(uri, 600, 420);
}

function activity_dialog(id){
    var uri = folder_dialog + "/activity.php?id="+id;
    return  open_dialog(uri, 600, 420);
}

function user_info_dialog(id){
   var uri = folder_dialog + "/user_info.php?id="+id;
    return  open_dialog(uri, 600, 320);
}

function customer_dialog(){
    var uri = folder_dialog + "/customer.php";
    return  open_dialog(uri, 600, 420);
}

function customer_group_dialog(allowNone){
    var uri = folder_dialog + "/customer_group.php";
    var arg = new Object;
    arg.allowNone = allowNone;
    return  open_dialog(uri, 600, 420, arg);
}

function project_dialog(){
    var uri = folder_dialog + "/project.php";
    return  open_dialog(uri, 650, 420);
}

function employee_dialog(allowNone, notAllow){
    var uri = folder_dialog + "/employee.php";
    var arg = new Object
    arg.allowNone = allowNone;
    arg.notAllow = notAllow;
    return  open_dialog(uri, 600, 450, arg);
}

function company_dialog(allowNone){
    var uri = folder_dialog + "/company.php";
    var arg = new Object
    arg.allowNone = allowNone;
    return  open_dialog(uri, 600, 420, arg);
}
