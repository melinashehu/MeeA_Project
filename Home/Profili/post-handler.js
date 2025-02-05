document.querySelectorAll('.postBtn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        const postType = this.id; 
        let formData = new FormData();

        if (postType === 'postTextBtn') {
            const postTitle = document.getElementById('post-title').value.trim();
            const postContent = document.getElementById('text-editor-container').innerText.trim();

            if (!postTitle || !postContent) {
                alert('Ju lutem jepni një titull dhe një tekst për postimin!');
                return;
            }

            formData.append('type', 'text');
            formData.append('title', postTitle);
            formData.append('content', postContent);
        } else if (postType === 'postImageBtn') {
            const postTitle = document.getElementById('post-title').value.trim();
            const fileInput = document.getElementById('image-videos-upload').files[0];

            if (!postTitle || !fileInput) {
                alert('Ju lutem jepni një titull dhe një file për postimin!');
                return;
            }

            formData.append('type', 'image');
            formData.append('title', postTitle);
            formData.append('file', fileInput);
        } else if (postType === 'postLinkBtn') {
            const postTitle = document.getElementById('post-title').value.trim();
            const postLink = document.getElementById('url-input').value.trim();

            if (!postTitle || !postLink) {
                alert('Ju lutem jepni një titull dhe një link për postimin!');
                return;
            }

            formData.append('type', 'link');
            formData.append('title', postTitle);
            formData.append('content', postLink);
        }

        fetch('save_post.php', {
            method: 'POST',
            body: formData,
        })
            .then(() => {
                window.location.href = '../home.php'; 
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Pati një problem gjatë ruajtjes së postimit.');
            });
    });
});
