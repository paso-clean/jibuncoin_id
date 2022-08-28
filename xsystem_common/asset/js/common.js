
function start_loading(){
	var h = $(window).height();
	$('#loader-bg ,#loader').height(h).css('display','block');
    $('#loading-msg').text('Now Loading...');
}

function end_loading(){
	var h = $(window).height();
	$('#loader-bg ,#loader').height(h).css('display','none');
}

function reload_slide_panel(){
	const num = $('#swiper-container').data('num');
	
	for(let i=0;i<num;i++){
		panel = $('#panel' + i + '-slide-content');
		ajaxAction['ajax'](panel);

	}
}

function get_panel(){
	let panel = $('#modalArea').data('panel');
	return panel;
}

function modal_close(){
	const panel = $('#modalArea').data('panel');
	$('#modalArea').data('panel',(panel - 1));
	$('#freeModal' + panel).modal('hide');
	$('#freeModal' + panel + ' .panelContent').html('');
}

function all_modal_close(){
	const panel = $('#modalArea').data('panel');
	
	for(let i=panel;i>0;i--){
		$('#freeModal' + i).modal('hide');
		$('#freeModal' + i + ' .panelContent').html('');
	}
	$('#modalArea').data('panel',0);
}


function modal_close(){
	const panel = $('#modalArea').data('panel');
	$('#modalArea').data('panel',(panel - 1));
	$('#freeModal' + panel).modal('hide');
	$('#freeModal' + panel + ' .panelContent').html('');
}

function all_modal_close(){
	const panel = $('#modalArea').data('panel');
	
	for(let i=panel;i>0;i--){
		$('#freeModal' + i).modal('hide');
		$('#freeModal' + i + ' .panelContent').html('');
	}
	$('#modalArea').data('panel',0);
}


$(function(){

    $(document).on('click','.btn-ajax',function(){
		if( typeof $(this).data('action') === 'undefined' ) {
			ajaxAction['ajax'](this);
		}else{
        	const action_name = $(this).data('action');
        	ajaxAction[action_name](this);
		}
    });

    $(document).on('click','.btn-api',function(){
		if( typeof $(this).data('action') === 'undefined' ) {
			apiAction['api'](this);
		}else{
			const action = $(this).data('action');
			apiAction[action](this);
		}
    });

	$(document).on('click','.tag',function(){
		let active_color;
		if( typeof $(this).data('active_color') === 'undefined' ) {
			active_color = 'active-white';
		}else{
			const color = $(this).data('active_color');
			active_color = 'active-' + color;
		}

		if($(this).hasClass(active_color)){
			$(this).removeClass(active_color);
			$(this).removeClass('active');
		}else{
			$(this).addClass(active_color);
			$(this).addClass('active');
		}
	});

	$(document).on('click','.btn-modal-close',function(){
		modal_close();
	});

	$(document).on('click','.btn-all-modal-close',function(){
		all_modal_close();
	});
	

    $(document).on('hidden.bs.modal','.modal', function () {
		if ($('.modal').is(':visible')) $('body').addClass('modal-open');
    });

});




const classAppModal = class{
    get_panel(){
	    let panel = $('#modalArea').data('panel');
        return panel;
    }

    set_modal(url,data,fixed = false){
        let new_id;
		let panel;
        if(fixed){
            new_id = 'fixedModal';
            $("#fixedModalTemplate").clone().prop({ id:new_id}).appendTo('#modalArea');
        }else{
            panel = this.get_panel();
            new_id = 'freeModal'+ (panel + 1);
			if(!($('#' + new_id).length)){
				$("#freeModalTemplate").clone().prop({ id:new_id}).appendTo('#modalArea');
			}
            $('#modalArea').data('panel',(panel + 1));
        }
        $.when(
            $('#' + new_id + ' .panelContent').html(data),
			$('#' + new_id).data('url',url)
        ).done(function(){ 
            $('#' + new_id).modal('show');
        });
		panel = this.get_panel();
		$('#' + new_id + ' .panel-num').text(panel);
    }

	reload_modal(num = 0){
		const panel = this.get_panel();
		const url = $('#freeModal' + (Number(panel) - num)).data('url');

		$.ajax({
			url:url,
			type:'POST',
			data:{},
		})
		.done( (data) => {
			$('#freeModal' + (Number(panel) - num) + ' .panelContent').html(data);
		})
		.fail( (data) => {
			alert(url + ' error.');
		});

	}

    set_reload_modal(data,fixed = false){
		const panel = this.get_panel();
		$('#freeModal' + panel + ' .panelContent').html(data);
        //$('#freeModal' + panel + ' .card-title').text(panel);
    }

}

let appModal = new classAppModal();
let appAction = new Array();


let ajaxAction = new Array();
ajaxAction.ajax = function(obj){
	let url;
	let data = $(obj).data();
	if( typeof $(obj).data('url_id') !== 'undefined' ) {
		url = $($(obj).data('url_id')).data('url');
		const data_array = $($(obj).data('url_id')).data();
		for (let key in data_array) {
			data[key] = data_array[key];
		}
	}else{
		url = $(obj).data('url');
	}
	
	start_loading();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
	})
	.done( (data) => {
		if( typeof $(obj).data('reload') !== 'undefined' ) {
			appModal.set_reload_modal(data,false);
        }else if( typeof $(obj).data('target') !== 'undefined' ) {
            const target = $(obj).data('target');
            $(target).html(data);
        }else{
            if( typeof $(obj).data('fixed') !== 'undefined') {
                appModal.set_modal(url,data,true);
            }else{
                appModal.set_modal(url,data,false);
            }
        }
        
        setTimeout(function(){
        	end_loading();},500
        );
	})
	.fail( (data) => {
		alert($(obj).data('url') + ' error.');
	});
}

let apiAction = new Array();


apiAction.api = function(obj){
	const form_id = $(obj).data('form_id');
	const formData = new FormData();
	if($('#croppedCanvas-' + form_id).length){
		if($('#croppedCanvas-' + form_id).innerWidth() !== 0){
			canvas = $('#croppedCanvas-' + form_id)[0].toDataURL();
			let base64Data = canvas.split(',')[1];
			let data = window.atob(base64Data);
			let buff = new ArrayBuffer(data.length);
			let arr = new Uint8Array(buff);
			let blob;
			let i;
			let dataLen;
			for( i = 0, dataLen = data.length; i < dataLen; i++){
				arr[i] = data.charCodeAt(i);
			}
			blob = new Blob([arr], {type: 'image/png'});
			formData.append('upfile', blob);
		}
	}
	
	const data_array = $(obj).data();
	for (let key in data_array) {
		formData.append(key,data_array[key]);
	}
	$('.form-id-' + form_id).each( function() {
		formData.append($(this).attr('name'), $(this).val());
    });
    
    if(formData.has('url_id')){
		if(formData.has('url')){
			formData.delete('url');
		}
		formData.append('url', $($(obj).data('url_id')).data('url'));
	}
	
	start_loading();
	$.ajax({
		url:formData.get('url'),
		type:'POST',
		data: formData,
		contentType: false,
		processData: false,
		dataType:"json",
	})
	.done( (data) => {
		let target;
		if(typeof $(obj).data('method') !== 'undefined' && data.status === true){
			if($(obj).data('method').toUpperCase() === 'DELETE' && typeof $(obj).data('target') !== 'undefined' ){
				target = $(obj).data('target');
				$(target).remove();
				//if(typeof data.msg  !== 'undefined' ){
					//alert(data.msg);
				//}
			}
		}

		if( typeof $(obj).data('target') !== 'undefined'){
			$($(obj).data('target')).html(data.content);
		}
		if( typeof $(obj).data('done') !== 'undefined') {
			apiAction[$(obj).data('done')](data);
		}
		
        setTimeout(function(){
        	end_loading();},500
        );
	})
	.fail( (data) => {
		alert('apiAction.api error.');
	});

	
}


apiAction.form = function(formData){
	$.ajax({
		url:formData.get('url'),
		type:'POST',
		data: formData,
		contentType: false,
		processData: false,
		dataType:"json",
	})
	.done( (data) => {
        if(formData.has("target")) {
            $(formData.get('target')).html(data.content);
        }

        if(formData.has("done")) {
            apiAction[formData.get("done")](data);
        }
	})
	.fail( (data) => {
		alert(formData.get('url') + ' error.');
	});
}

apiAction.alert = function(data){
	alert(data.msg);
}

apiAction.form_done = function(data){
	$.when(
		appModal.reload_modal(1)
	).done(function(){ 
		modal_close();
	});
}

apiAction.reload = function(data){
	appModal.reload_modal(0);
}

apiAction.refresh_done = function(data){
	const panel = get_panel();
	$('#freeModal' + panel + ' .panelContent').html(data.content);
}

apiAction.app_redirect = function(data){
    window.location.href = data.redirect;
}
