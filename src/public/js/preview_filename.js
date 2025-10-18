// 画像選択時
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        // 拡張子を取得
        const extension = file.name.split('.').pop();

        // ファイル数をサーバーに問い合わせ
        fetch('/count-images')
            .then(response => {
                if (!response.ok) {
                    throw new Error('サーバーエラー');
                }
                return response.json();
            })
            .then(data => {
                // ファイル名生成
                const imageName = `image${data.count + 1}.${extension}`;

                // ファイル名をテキストと hidden に反映
                document.getElementById('imageName').value = imageName;
                document.querySelector('input[name="image_name"]').value = imageName;

                // プレビュー表示
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            })
            .catch(error => {
                console.error('fetch エラー:', error);
                alert('ファイル名の取得に失敗しました');
            });
    }
});