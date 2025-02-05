const addLinks = document.getElementById('add-link');
const linkModal = document.getElementById('link-modal');
const closeModalBtn = document.getElementById('close-modal');

addLinks.addEventListener('click', () => {
    if (linkModal.style.display === 'block') {
        linkModal.style.display = 'none';
    } else {
        linkModal.style.display = 'block';
    }
});

document.addEventListener('click', (event) => {
    if (!addLinks.contains(event.target) && !linkModal.contains(event.target)) {
        linkModal.style.display = 'none';
    }
});

closeModalBtn.addEventListener('click', () => {
    linkModal.style.display = 'none';
});

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

    if (!linkedinValue && !githubValue && !mailValue) {
        alert('Ju lutem vendosni të paktën një adresë!');
        return;
    }

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

    if (!linkedinValue) formData.delete('linkedin');
    if (!githubValue) formData.delete('github');
    if (!mailValue) formData.delete('mail');

    fetch('save_user_links.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())  
    .then(data => {
        alert(data);  
        linkModal.style.display = 'none'; 
    })
    .catch(error => {
        alert('Ndodhi një error gjatë ruajtjes së formës.');
        console.error(error);
    });
});
