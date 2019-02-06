//JS fuer das suchen in der Tabelle

function searchTable() {
	var table, tr, input, data;

	table = document.getElementById("User_table");
    tr = table.getElementsByClassName("tr-content");
    input = document.getElementById("table_input").value.toLowerCase();
    data = [];
    
    for (i = 0; i < tr.length; i++)
    {
        td = tr[i].getElementsByTagName("td");
        if (input) {
            data = [];
            for (j = 0; j < td.length; j++) {
                data.push(td[j].textContent.toLowerCase());
            }
            
            if (data.toString().includes(input)) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
        else {
            tr[i].style.display = "";
        }
        
    }
}