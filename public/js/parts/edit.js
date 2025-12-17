function addUrlInput() {
    const container = document.getElementById('urlContainer');
    const div = document.createElement('div');
    div.className = 'url-input-group';
    div.innerHTML = `
        <input type="url" name="image_urls[]" class="form-control" placeholder="https://example.com/image.jpg">
        <button type="button" class="btn btn-danger btn-sm" onclick="removeUrlInput(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeUrlInput(button) {
    if (document.querySelectorAll('.url-input-group').length > 1) {
        button.parentElement.remove();
    }
}

function toggleImageDelete(checkbox) {
    const item = checkbox.closest('.existing-image-item');
    if (checkbox.checked) {
        item.classList.add('marked-delete');
    } else {
        item.classList.remove('marked-delete');
    }
}
