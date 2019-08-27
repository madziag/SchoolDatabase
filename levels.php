<html>
<head>
<script>

var loc = "";

function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.response;
				loc = this.response;
            }
        };

        xmlhttp.open("GET","levels_conn.php?q="+str,true);
        xmlhttp.send();

    }
}

</script>
</head>
<body>

<form>
<select name="users" onchange="showUser(this.value)">
  <option value="">Select a semester:</option>
  <option value="2-2019">2-2019</option>
  <option value="9-2019">9-2019</option>
  </select>
</form>
<br>
<div id="txtHint"><b>City info will be listed here...</b></div>

</body>
</html>