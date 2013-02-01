function check() {
    var error = 0;
    var terror = 0;
    var cerror = 0;
    if (form.elements['title'].value == '') {
        document.getElementById("titerror").innerHTML = "标题不能为空";
        error = 1;
        terror = 1
    } else {
        if ((form.title.value).indexOf(" ") == 0) {
            document.getElementById("titerror").innerHTML = '标题首字符不能为空！';
            error = 1;
            terror = 1
        }
    }
    if (terror == 0) {
        document.getElementById("titerror").innerHTML = ''
    }
    if (form.elements['content'].value == '') {
        document.getElementById("conerror").innerHTML = "内容不能为空";
        error = 1;
        cerror = 1
    } else {
        if (form.elements['content'].value.length < 10) {
            document.getElementById("conerror").innerHTML = '不得小于10个字符！';
            error = 1;
            cerror = 1
        }
    }
    if (cerror == 0) {
        document.getElementById("conerror").innerHTML = ''
    }
    if (error == 0) {
        return true
    } else {
        return false
    }
}