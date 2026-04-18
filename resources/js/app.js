document.addEventListener('DOMContentLoaded', ()=>{
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if(!tokenMeta) return;
    const token = tokenMeta.content;

    // 付け替え対象の色クラス（全ステータス分を列挙）
    const COLOR_CLASSES = [
        'bg-red-100', 'text-red-700', 'border-red-200',
        'bg-blue-100', 'text-blue-700', 'border-blue-200',
        'bg-green-100', 'text-green-700', 'border-green-200',
    ];

    document.querySelectorAll('.status-select').forEach((select)=> {
        select.addEventListener('change', async() => {
            const bookId = select.dataset.bookId;
            const status = select.value;

            try{
                const res = await fetch(`/books/${bookId}/status`,{
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ status }),
                });

                if(!res.ok) throw new Error('保存に失敗しました');

                const data = await res.json();

                // 古い色を全部外して、新しい色を付与
                select.classList.remove(...COLOR_CLASSES);
                select.classList.add(...data.badgeClass.split(' '));
            }catch(err){
                alert(err.message);
            }
        });
    });
});
