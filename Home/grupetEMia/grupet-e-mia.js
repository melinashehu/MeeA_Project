document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("table tbody");

    function fetchGroups() {
        fetch("gruper-e-mia.php")  
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    tableBody.innerHTML = "";  
                    if (data.groups.length === 0) {
                        tableBody.innerHTML = "<tr><td colspan='4'>Nuk ka grupe për të shfaqur.</td></tr>";
                    } else {
                        data.groups.forEach(group => {
                            const row = `
                                <tr>
                                    <td>${group.emri_grupit}</td>
                                    <td>${group.lloji}</td>
                                    <td>${group.privatesia}</td>
                                    <td>${group.created_at}</td>
                                </tr>
                            `;
                            tableBody.insertAdjacentHTML('beforeend', row); 
                        });
                    }
                } else {
                    alert("Gabim: " + data.message); 
                }
            })
            .catch(error => console.error("Gabim gjatë marrjes së grupeve:", error));  
    }

    fetchGroups();
});