let list = document.querySelectorAll(".navigation li");

function activeLink() {
    list.forEach((item) => {
        item.classList.remove("hovered");
    });
    this.classList.add("hovered");
}

list.forEach(item => item.addEventListener("mouseover", activeLink));


let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};

document.addEventListener("DOMContentLoaded", function () {
    const userId = document.body.getAttribute("data-user-id"); 

    let createBtn = document.getElementById("createBtn");
    let deleteBtn = document.getElementById("deleteBtn");
    let errorMessage = document.getElementById("error-message");

    createBtn.addEventListener("click", function () {
        let projectName = document.getElementById("projectName").value;
        let projectType = document.getElementById("projectType").value;
        let projectMembers = document.getElementById("projectMembers").value;
        let privacy = document.getElementById("privacy").value;

        if (projectName === "" || projectType === "" || projectMembers === "" || privacy === "") {
            errorMessage.style.display = "block";
        } else {
            fetch("krijimgrupi.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({
                    user_id: userId,  
                    emri_grupit: projectName,
                    anetaret: projectMembers,
                    lloji: projectType,
                    privatesia: privacy
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Grupi u krijua me sukses!");
                    } else {
                        alert('Gabim: ${data.message}');
                    }
                })
                .catch(error => console.error("Gabim gjatë lidhjes me serverin:", error));
        }
    });

    deleteBtn.addEventListener("click", function () {
        document.getElementById("projectName").value = "";
        document.getElementById("projectType").value = "";
        document.getElementById("projectMembers").value = "";
        document.getElementById("privacy").value = "";
        errorMessage.style.display = "none"; 
    });
});