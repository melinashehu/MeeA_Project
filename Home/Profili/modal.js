const linkForm = document.getElementById('link-form');
const linkedinInput = document.getElementById('linkedin');
const githubInput = document.getElementById('github');
const mailInput = document.getElementById('mail');


const usernameRegex = /^[a-zA-Z0-9._-]{3,30}$/;
const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

linkForm.addEventListener('submit', function (event) {
    event.preventDefault(); 

    const linkedinValue = linkedinInput.value.trim();
    const githubValue = githubInput.value.trim();
    const mailValue = mailInput.value.trim();

    if (linkedinValue && !usernameRegex.test(linkedinValue)) {
        alert('Ju lutem vendosni një adresë të vlefshme në LinkedIn!');
        return;
    }

   
    if (githubValue && !usernameRegex.test(githubValue)) {
        alert('Ju lutem vendosni një adresë të vlefshme në Github!');
        return;
    }


    if (mailValue && !emailRegex.test(mailValue)) {
        alert('Ju lutem vendosni një adresë të vlefshme në Mail!');
        return;
    }

   
    const formData = new FormData(linkForm);

    fetch('save_user_links.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Links updated successfully.');
            linkModal.style.display = 'none'; 
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error submitting the form.');
        console.error(error);
    });
});
