
apiAction.app_boot = function(obj){
	let app;
	let formData= new FormData();
	const tags = $(obj).data('tags');
	formData.append('url', $(obj).data('url'));
	formData.append('done', $(obj).data('done'));
	//formData.append('api_done', $(obj).data('api_done'));
	$('#' + tags + ' .tag').each(function(t, o){
		if($(o).hasClass('active')){
			app = $(o).text();
			console.log(app);
			formData.append('apps[]', app);
		}
	});
	
    apiAction['form'](formData);
}


apiAction.htaccess = function(obj){
	let app;
	let formData= new FormData();
	const tags = $(obj).data('tags')
	formData.append('api', $(obj).data('api'));
	formData.append('api_done', $(obj).data('api_done'));
	$('#' + tags + ' .tag').each(function(t, o){
		if($(o).hasClass('active')){
			app = $(o).text();
			formData.append('apps[]', app);
		}
	});
    //apiAction['api'](formData);
}

apiAction.htaccess_done = function(data){
	alert(data.status);
}