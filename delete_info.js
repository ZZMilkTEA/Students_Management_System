function deleteInfo(id,table){
    var r = confirm("你确定要删除此条信息吗？");
    if (r==true){
        if (window.XMLHttpRequest) {
            // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            xmlhttp=new XMLHttpRequest();
        }
        else {
            // IE6, IE5 浏览器执行代码
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                executeScript(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET","delete_info.php?q1=" + id + "&q2=" + table ,true);
        xmlhttp.send();
    }
}