document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const imageNameField = document.getElementById('imageName');
    const hiddenImageName = document.querySelector('input[name="image_name"]');
    const hiddenPreviewUrl = document.querySelector('input[name="preview_url"]');
    const previewContainer = document.querySelector('.image-preview-container');

    if (!input || !preview) return;

    // ✅ ここがポイント！
    // old input があるけど、ファイルは存在しない or バリデーションエラーだったときに初期化
    const hasValidationError = document.querySelector('.form__error');
    if (hasValidationError) {
        imageNameField.value = '';
        hiddenImageName.value = '';
        hiddenPreviewUrl.value = '';
        preview.src = '';
        preview.style.display = 'none';
        if (previewContainer) previewContainer.style.display = 'none';
    }

    input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const extension = file.name.split('.').pop();

            fetch('/count-images')
                .then(response => {
                    if (!response.ok) throw new Error('サーバーエラー');
                    return response.json();
                })
                .then(data => {
                    const imageName = `image${data.count + 1}.${extension}`;
                    imageNameField.value = imageName;
                    hiddenImageName.value = imageName;

                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                    if (previewContainer) previewContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('fetch エラー:', error);
                    alert('ファイル名の取得に失敗しました');
            });
        }
    });
});