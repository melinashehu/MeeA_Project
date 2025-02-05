document.getElementById('about-form').addEventListener('submit', function (event) {
    console.log("form is sent");
    event.preventDefault();

    const textArea = document.getElementById('user-info');
    const text = textArea.value.trim();

    if (text.length < 10 || text.length > 500) {
        alert('Teksti duhet të ketë 10 deri në 500 karaktere!');
        return;
    }

    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                textArea.value = text;
            }
        })
        .catch((error) => {
            console.log(error);
            console.error(error);
        });
});
