// Zoek functionaliteit
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.querySelector(".search_field");
    filter = input.value.toUpperCase();
    table = document.querySelector(".artikelTabel");
    tr = table.getElementsByTagName("tr");
  
    // Loop door alle rijen, verberg degene die niet overeenkomen met de zoekopdracht
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      for (var j = 0; j < td.length; j++) {
        if (td[j]) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break; // Laat de rij zien als er een match is gevonden en ga naar de volgende rij
          } else {
            tr[i].style.display = "none"; // Verberg de rij als er geen match is gevonden
          }
        }
      }
    }
  }