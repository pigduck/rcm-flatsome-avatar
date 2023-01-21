window.addEventListener('load', function() {
    var rcm_eump_image = document.getElementById('image');
    rcm_eump_image.addEventListener('change', function() {
        var yes = confirm('你確定要修改投像嗎？');
        if (yes) {
            rcm_eump_image = document.getElementById('image');
            var formData = new FormData();
            formData.append( 'action', 'rcm_flatsome_avatar_upload' );
            formData.append( 'rcm_eump_image', rcm_eump_image.files[0]);
            var url = '/wp-admin/admin-ajax.php';
            fetch( url, {
                method: 'POST',
                body: formData,
            } )
                .then( res => res.text() )
                .then(function (url){
                    alert('上傳成功');
                    window.location.reload();
                })
                .catch( err => console.log( err ) );
        }
    });

    var rcm_eump_image = document.querySelector('.account-user > .image');
    rcm_eump_image.addEventListener('click', function() {
        document.getElementById('image').click();
    });

});