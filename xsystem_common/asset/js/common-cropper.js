
let cropImage;
$(function(){
    let cropper = null;
    //const cropAspectRatio = 9.0 / 16.0;
    const cropAspectRatio = 1 / 1;
    const scaledWidth = 300;

    cropImage = function (evt) {
        const files = evt.target.files;
        let form_id;
        let is_form_id = false;
        if( typeof $('#uploader').data('form_id') !== 'undefined' ) {
            form_id = $('#uploader').data('form_id');
            is_form_id = true;
        }

        if (files.length == 0) {
            return;
        }
        let file = files[0];
        let image = new Image();
        let reader = new FileReader();
        reader.onload = function (evt) {
            image.onload = function () {
                let scale = scaledWidth / image.width;
                let imageData = null;
                {
                    const canvas = document.getElementById("sourceCanvas");
                    {
                        let ctx = canvas.getContext("2d");
                        canvas.width = image.width * scale;
                        canvas.height = image.height * scale;
                        ctx.drawImage(image, 0, 0, image.width, image.height, 0, 0, canvas.width, canvas.height);
                    }
                    if (cropper != null) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(canvas, {
                        aspectRatio: cropAspectRatio,
                        movable: false,
                        scalable: false,
                        zoomable: false,
                	    viewMode: 1,
                        data: {
                            width: canvas.width,
                            height: canvas.width * cropAspectRatio
                        },
                        crop: function (event) {
                            //const croppedCanvas = document.getElementById("croppedCanvas");
                            //if(is_form_id){
                                //const croppedCanvas2 = document.getElementById("croppedCanvas-" + form_id);
                            //}
                            {
                                const croppedCanvas = document.getElementById("croppedCanvas");
                                let ctx = croppedCanvas.getContext("2d");
                                let croppedImageWidth = image.height * cropAspectRatio;
                                croppedCanvas.width = image.width;
                                croppedCanvas.height = image.height;
                                croppedCanvas.width = croppedImageWidth * scale;
                                croppedCanvas.height = image.height * scale;
                                ctx.drawImage(image,
                                    event.detail.x / scale, event.detail.y / scale, event.detail.width / scale, event.detail.height / scale,
                                    0, 0, croppedCanvas.width, croppedCanvas.height
                                );

                                
                                if(is_form_id){
                                    const croppedCanvas2 = document.getElementById("croppedCanvas-" + form_id);
                                    let ctx2 = croppedCanvas2.getContext("2d");
                                    let croppedImageWidth2 = image.height * cropAspectRatio;
                                    croppedCanvas2.width = image.width;
                                    croppedCanvas2.height = image.height;
                                    croppedCanvas2.width = croppedImageWidth2 * scale;
                                    croppedCanvas2.height = image.height * scale;
                                    ctx2.drawImage(image,
                                        event.detail.x / scale, event.detail.y / scale, event.detail.width / scale, event.detail.height / scale,
                                        0, 0, croppedCanvas2.width, croppedCanvas2.height
                                    );
                                }
                                
                            }
                        }
                    });
                }
            }
            image.src = evt.target.result;
        }
        reader.readAsDataURL(file);
    }

});


ajaxAction.cropper_editor = function(obj){
    const img_src = $(obj).attr('src');
    $(obj).data('src',img_src);
	ajaxAction['ajax'](obj);
}

$(function(){

	$(document).on('click','.btn-cropper-close',function(){
    	const form_id = $(this).data('form_id');
	  	//let panel = $('#modalArea').data('panel');
	  	//$('#freeModal' + panel).modal('hide');
		modal_close();
    	$('.form_id_' + form_id).show();
  	});

    $(document).on('click','#btn-cropper',function(){
		const form_id = $(this).data('form_id');
        $('#uploader').click();
        const uploader = document.getElementById('uploader');
        uploader.addEventListener('change', cropImage);
        $('#origin-img-area').hide();
        $('#edit-img-area').show();
        $('#edit-img-area-' + form_id).show();
        $('.reload_class_' + form_id).hide();
        $('#edit-cropper-area').show();
        $(this).hide();
        $('.setting-img-area').show();
    });
	
	
});



apiAction.setting_img = function(obj){
	const file_name = $('#uploader').val();
	const form_id = $('#uploader').data('form_id');
	if(typeof $(obj).data('url') === 'undefined' || $(obj).data('url') === ""){
        let panel = $('#modalArea').data('panel');
        modal_close();
		return 0;
	}

    if(file_name !== ''){
		canvas = $('#croppedCanvas-' + form_id)[0].toDataURL();
		let base64Data = canvas.split(',')[1];
		let data = window.atob(base64Data);
		let buff = new ArrayBuffer(data.length);
		let arr = new Uint8Array(buff);
		let blob;
		let i;
		let dataLen;
		let formData;
		for( i = 0, dataLen = data.length; i < dataLen; i++){
			arr[i] = data.charCodeAt(i);
		}
		blob = new Blob([arr], {type: 'image/png'});
	    formData = new FormData();
	    formData.append('url', $(obj).data('url'));
	    formData.append('action', $(obj).data('action'));
	    formData.append('done', $(obj).data('done'));
	    formData.append('entity_type', $(obj).data('entity_type'));
	    formData.append('entity_code', $(obj).data('entity_code'));
	    formData.append('object_type', $(obj).data('object_type'));
	    formData.append('object_code', $(obj).data('object_code'));
		formData.append('upfile', blob);
        apiAction['form'](formData);
    }else{
        alert('画像を選択してください。');
        return 0;
    }
}

apiAction.setting_img_done = function(data){
	if(data.status === 1){
		$('.' + data.reload_class).attr('src',data.thum_img_path);
        modal_close();
	}else{
		alert('送信データがありません。');
	}
}



