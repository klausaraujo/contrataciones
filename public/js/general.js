let btnCurl = $('.btn_curl'), btnCancelar = $('.btn-cancelar'), upload = $('.upload-button'), file = $('.file-upload'), imgperfil = $('.profile-pic'), perfiltop = $('.top-avatar');

$(document).ready(function (){
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	setTimeout(function () { $('.msg').hide('slow'); }, 3000);/**/
});

/*$('body').bind('click','a',function(e){
	let el = e.target, a = el.closest('a');
});*/
/*$('#form_proveedores').validate({
	submitHandler: function (form, event){
		let btnSubmit = $('#form_proveedor button[type=submit]');
		
		btnSubmit.html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		btnSubmit.addClass('disabled');
		btnCancelar.addClass('disabled');
	}
});

$('#form_usuarios').validate({
	submitHandler: function (form, event){
		let btnSubmit = $('#form_usuarios button[type=submit]');
		
		btnSubmit.html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
		btnSubmit.addClass('disabled');
		btnCancelar.addClass('disabled');
	}
});*/

/*$('.numcurl').bind('keydown',function(e){
	let key = e.which, len = ($('.numcurl').val()).length + 1;
	//alert(key);
	if(key >= 48 && key <= 57 || key >= 96 && key <= 105 || key == 46 || key == 8){
		/*if(len <= $('.numcurl').prop('maxlength')){
			if($('.nombres').prop('readonly') === true){ $('.nombres').prop('readonly', false), $('.direccion').prop('readonly', false), $('.apellidos').prop('readonly', false) }
			if($('.nombres').val() !== '' || $('.apellidos').val() !== '' || $('.direccion').val() !== '' || $('.usuario').val() !== ''){
				$('.nombres').val(''), $('.direccion').val(''), $('.apellidos').val(''), $('.usuario').val('')
			}
		}
		if(len === $('.numcurl').prop('maxlength')){
			let palabra = $('.numcurl').val() + String.fromCharCode(key);
			$('.usuario').val(palabra);
		}
		return String.fromCharCode(key);
	}else
		return false;
});*/
/*function mascara(o,f){  
	v_obj=o;  
	v_fun=f;  
	setTimeout("execmascara()",1);  
}  
function execmascara(){   
	v_obj.value=v_fun(v_obj.value);
}  
function cpf(v){     
	v=v.replace(/([^0-9\.]+)/g,''); 
	v=v.replace(/^[\.]/,''); 
	v=v.replace(/[\.][\.]/g,''); 
	v=v.replace(/\.(\d)(\d)(\d)/g,'.$1$2'); 
	v=v.replace(/\.(\d{1,2})\./g,'.$1'); 
	//v = v.toString().split('').reverse().join('').replace(/(\d{3})/g,'$1,');    
	//v = v.split('').reverse().join('').replace(/^[\,]/,''); 
	return v;
}*/
/*$('.numDec').bind('keydown',function(e){
	let key = e.which;
	alert(key);
	if(key >= 48 && key <= 57 || key >= 96 && key <= 105 || key == 46 || key == 8 || key == 37 || key == 39 || key == 9 || key == 116){
		return String.fromCharCode(key);
	}else
		return false;
	
	//jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
});*/
function formatMoneda(v){
	let n = parseFloat(v).toFixed(2);
	n = (n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return n;
}
function ceros( number, width ){
	width -= number.toString().length;
	if ( width > 0 ){
		return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
	}
	return number + ""; // siempre devuelve tipo cadena
}

$('.tipodoc').bind('change',function(e){
	if(this.value === '1') $('.numcurl').prop('maxlength',8);
	else if(this.value === '2') $('.numcurl').prop('maxlength',9);
	
	if(this.value === '1' || this.value === '2'){
		$('.ruc').removeAttr('readonly'), $('.numcurl').removeAttr('readonly'), $('.nombres').attr('readonly', true), $('.apellidos').attr('readonly', true);
		$('.btn_curl').removeClass('disabled'), $('.btn_ruc').removeClass('disabled'), $('.usuario').attr('readonly', true);
	}
	
	$('.borra').val('');
	$('.perfil').val('2');
	//if($('.nombres').prop('readonly') === true){ $('.nombres').prop('readonly', false); $('.direccion').prop('readonly', false); $('.apellidos').prop('readonly', false); }
	$('.numcurl').focus();
	
	if(this.value === '3'){
		$('.numcurl').prop('maxlength',8), $('.numcurl').val('00000000'), $('.ruc').val('00000000000'), $('.usuario').removeAttr('readonly'), $('.apellidos').removeAttr('readonly');
		$('.nombres').removeAttr('readonly'), $('.nombres').focus(), $('.btn_curl').addClass('disabled'), $('.btn_ruc').addClass('disabled'), $('.ruc').attr('readonly', true);
		$('.numcurl').attr('readonly', true);
	}
});

$('.moneda').bind('input',function(e){
	//return mascara(this,cpf);
	jQuery(this).val(jQuery(this).val().replace(/([^0-9\.]+)/g, ''));
	jQuery(this).val(jQuery(this).val().replace(/^[\.]/,''));
	jQuery(this).val(jQuery(this).val().replace(/[\.][\.]/g,''));
	jQuery(this).val(jQuery(this).val().replace(/\.(\d)(\d)(\d)/g,'.$1$2'));
	jQuery(this).val(jQuery(this).val().replace(/\.(\d{1,2})\./g,'.$1'));
});

$('.num').bind('input',function(e){
	jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
});

$('.mayusc').bind('input',function(e){
	jQuery(this).val(jQuery(this).val().toUpperCase());
});
btnCancelar.bind('click', function(){ $(location).attr('href',base_url+segmento); });
upload.bind('click',function(e){ file.trigger('click'); });

file.bind('change',function(){
	var e = e || window.event;
	let file = e.target.files;
	let img = URL.createObjectURL(file[0]);
	let formData = new FormData($('.uploadFileAjax')[0]);
	$.ajax({
        url: base_url + 'main/upload',
        type: 'post',
        dataType: 'html',
        data: formData,
        cache: false,
        contentType: false,
	    processData: false
	}).done(function(data){
		//console.log(data);
		imgperfil.attr( 'src', img );
		perfiltop.attr( 'src', img );
	});
	
});

btnCurl.bind('click',function(){
	let doc = $('.doc').val(), tipodoc = '', tabla = $('#tabla').val();
	$('.nombres').val(''); $('.direccion').val(''); $('.ruc').val(''); $('.apellidos').val(''); 
	
	if($('.tipodoc').val() === '1') tipodoc = '01'; else if($('.tipodoc').val() === '2') tipodoc = '03';
	
	if(tipodoc !== '' && doc !== ''){
		if(doc.length < 8){ alert('Debe ingresar un documento válido'); $('#doc').focus(); return}
		if(tipodoc === '01' && doc.length !== 8){ alert('Debe ingresar un número de doc válido, 8 caracteres'); $('#doc').focus(); return}
		if(tipodoc === '03' && doc.length < 9){ alert('Debe ingresar un número de documento válido, 9 caracteres'); $('#doc').focus(); return}
		/*if(tipodoc === '04')tipodoc = '0' + (parseInt(tipodoc)-1).toString();*/
		$('.error_curl').html('');
		
		$.ajax({
			data: { tipo: tipodoc, doc: doc, tabla: tabla },
			url: base_url + 'main/curl',
			method: 'POST',
			dataType: 'json',
			error: function (xhr) { btnCurl.removeAttr('disabled'); btnCurl.html('<i class="fa fa-search aria-hidden="true"></i>'); },
			beforeSend: function () { btnCurl.html('<i class="fa fa-spinner fa-pulse"></i>'); btnCurl.attr('disabled', 'disabled'); },
			success: function (resp) {
				let data = JSON.parse(resp.data);
				let msg = data.errors? data.errors[0].detail : '';
				btnCurl.html('<i class="fa fa-search aria-hidden="true"></i>');
				btnCurl.removeAttr("disabled");

				if(resp.valida){
					alert('El Documento ya se encuentra registrado'); $('#doc').val(''); $('#doc').focus();
				}else{
					if(msg === ''){
						//let data = JSON.parse(resp.data);
						
						if(data.data.attributes.es_persona_viva) $('#btnEnviar').removeClass('disabled'), $('.fallecido').html('');
						else $('#btnEnviar').addClass('disabled'), $('.fallecido').html('FALLECIDO');
						//console.log(data);
						if(tipodoc === '01' || tipodoc === '03'){
							if(segmento === 'proveedores' || segmento === 'ventas' || segmento === 'tostado'){
								$('.direccion').val(data.data.attributes.domicilio_direccion);
								$('.nombres').val(data.data.attributes.apellido_paterno+' '+data.data.attributes.apellido_materno+' '+data.data.attributes.nombres);
								$('#ruc').val('00000000000');
								//$('#ruc').prop('readonly', true);
								//$('.direccion').prop('readonly', true);
							}else if(segmento === 'usuarios'){
								$('.apellidos').val(data.data.attributes.apellido_paterno+' '+data.data.attributes.apellido_materno);
								$('.nombres').val(data.data.attributes.nombres); $('.usuario').val(doc);
								//$('.apellidos').prop('readonly', true);
							}else if(segmento === 'certificaciones'){
								$('.apellidos').val(data.data.attributes.apellido_paterno+' '+data.data.attributes.apellido_materno);
								$('.nombres').val(data.data.attributes.nombres);
								//$('.apellidos').prop('readonly', true);
							}
							//$('.nombres').prop('readonly', true);
						}//else console.log(data);
					}else{
						alert(msg);
						$('.doc').val(''), $('.doc').focus();
						//$('.nombres').prop('readonly', false); $('.direccion').prop('readonly', false); $('.apellidos').prop('readonly', false);
					}
				}
			}
		}).fail( function( jqXHR, textStatus, errorThrown ) {
			btnCurl.html('<i class="fa fa-search aria-hidden="true"></i>'); btnCurl.removeAttr("disabled"); alert(jqXHR + ",  " + textStatus + ",  " + errorThrown);
		});
	}else{ 
		if(tipodoc == ''){ alert('Debe elegir un tipo de Documento'); $('#tipodoc').focus(); }
		else{ alert('Debe ingresar un número de documento válido'); $('#doc').focus(); }
	}
});

$('#formPassword').validate({
	errorClass: 'form_error',
	rules: {
		old_password: { required: true },
		password: { required: true, minlength: 6 },
		re_password: { required: true, equalTo: "#password" }
	},
	messages: {
		old_password: { required: '&nbsp;&nbsp;Ingrese la contrase\xf1a actual' },
		password: { required: '&nbsp;&nbsp;Ingrese la nueva contrase\xf1a', minlength: '&nbsp;&nbsp;Por lo menos 6 caracteres' },
		re_password: { required: '&nbsp;&nbsp;Ingrese nuevamente la contrase\xf1a', equalTo: '&nbsp;&nbsp;Las contrase\xf1as deben ser iguales' }
	},
	errorPlacement: function(error, element) {
		error.insertAfter(element);
	},
	submitHandler: function (form, event) {
		event.preventDefault();
		$.ajax({
			data: $('#formPassword').serialize(),
			url: base_url + 'main/cambiapass',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function () {
				//$('.resp').html('<i class="fas fa-spinner fa-pulse fa-2x"></i>');
				$('#formPassword button[type=submit]').html('<span class="spinner-border spinner-border-sm"></span>&nbsp;&nbsp;Cargando...');
				$('#formPassword button[type=submit]').addClass('disabled');
			},
			success: function (data) {
				//$('.resp').html('');
				$('#formPassword button[type=submit]').html('Realizar Cambio');
				$('#formPassword button[type=submit]').removeClass('disabled');
				//console.log(data);
				if (parseInt(data.status) === 200) {
					$('.resp').html(data.message);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 1500);
				}else {
					$('.resp').html(data.message);
					setTimeout(function () { $('.resp').html('&nbsp;'); }, 1500);
				}
			}
		});
	}
});

$('.dep').bind('change', function(){
	let cod = this.value, html = '<option value="">-- Seleccione --</option>';
	$.ajax({
		data: { cod_dep: cod },
		url: base_url + 'main/provincias',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function () {
			$('.dis').html('<option>-- Seleccione --</option>'); $('.pro').html('<option> Cargando...</option>');
		},
		success: function (data) {
			$.each(data, function (i, e){ html += '<option value="' + e.cod_pro + '">' + e.provincia + '</option>'; });
			$('.pro').html(html);
			//console.log(data);
		}
	});
});
$('.pro').bind('change', function(){
	let cod = this.value, html = '<option value="">-- Seleccione --</option>';
	$.ajax({
		data: { cod_dep: $('.dep').val(),cod_pro: cod },
		url: base_url + 'main/distritos',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function () {
			$('.dis').html('<option> Cargando...</option>');
		},
		success: function (data) {
			$.each(data, function (i, e){ html += '<option value="' + e.cod_dis + '">' + e.distrito + '</option>'; });
			$('.dis').html(html);
			//console.log(data);
		}
	});
});
$('.dis').change(function(){
	let id = this.value, dpto = $('.dep').val(), prov = $('.pro').val();
    if (id.length > 0) {
		$.ajax({
			data: { cod_dep: dpto, cod_pro: prov, cod_dis: id },
			url: base_url + 'main/cargarLatLng',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function(){},
			success: function (data) {
				//console.log(data);
				/*const {ubigeo} = data;*/
				var opt = {lat: parseFloat(data[0].latitud), lng: parseFloat(data[0].longitud), zoom: 16};
				//console.log(map.getZoom());
				//console.log(opt);
				map.setCenter(opt);
				//if($('.ajaxMap').css('display') == 'none' || $('.ajaxMap').css('opacity') == 0) $('.ajaxMap').show();
				$('.ajaxMap').removeClass('d-none');
				/*$.ajax({
					data: {lat: parseFloat(ubigeo[0].latitud), lng: parseFloat(ubigeo[0].longitud), zoom: 16},
					url: 'urlCurl',
					method: "POST",
					dataType: "json",
					beforeSend: function () {},
					success: function (data) {
						console.log(data);
					}
				});*/
			}
		});
	}
});
$('.blur').on('blur',function(){
	let id = $(this).attr('id');
	if(id === 'pesocafe' || id === 'pesosub' || id === 'pesodesc' || id === 'pesocasc'){
		let totPeso = 0, porcPeso = 0, porc = 0, sib = $(this).closest('div').siblings().find('input'), h = null, input = $(this).closest('ul').find('input.blur');
		
		$.each(input,function(i,e){
			if(e.value !== '') totPeso += parseFloat(e.value);
			else e.value = '0.00', h = $(e).closest('div').siblings('div').find('input'), h.val('0.00');
		});
		
		$.each(input,function(i,e){
			h = $(e).closest('div').siblings('div').find('input');
			if(e.value !== '' && parseFloat(e.value) > 0){ porc = (parseFloat(e.value)/totPeso)*100, h.val(formatMoneda(porc)), porcPeso += porc; }
		});
		
		if(totPeso > 0) $('#pesototal').val(formatMoneda(totPeso)), $('#porctotal').val(formatMoneda(porcPeso));
		else $('#pesototal').val('0.00'), $('#porctotal').val('0.00');
	}else if(id === 'malla16' || id === 'malla15' || id === 'malla14' || id === 'mallabase'){
		let totmalla = parseFloat($('#malla_gen').val()), totMall = 0, sib = $(this).closest('div').siblings().find('input'), h = null, totPorc = 0;
		let input = $(this).closest('ul').find('input.blur');
		
		$.each(input,function(i,e){
			if(e.value !== '')totMall += parseFloat(e.value);
			else e.value = '0.00', h = $(e).closest('div').siblings('div').find('input'), h.val('0.00');
		});
		if(totMall > totmalla){
			alert('El total no puede exceder el valor de la malla');
			totMall -= parseFloat(this.value), $(this).val(''), sib.val(''), $(this).focus();
		}else{
			let porc = 0;
			$.each(input,function(i,e){
				h = $(e).closest('div').siblings('div').find('input');
				if(e.value !== '' && parseFloat(e.value) > 0){ porc = (parseFloat(e.value)/totMall)*100, h.val(formatMoneda(porc)), totPorc += porc; }
			});
			if(totMall > 0) $('#grtotmalla').val(formatMoneda(totMall)), $('#portotmalla').val(formatMoneda(totPorc));
			else $('#grtotmalla').val('0.00'), $('#portotmalla').val('0.00');
		}
	}else if(id === 'fragptos' || id === 'sabptos' || id === 'sabreptos' || id === 'aciptos' || id === 'cuerptos' || id === 'uniptos' || id === 'balptos' || id === 'tazptos'
			|| id === 'dulptos' || id === 'apreptos'){
		let input = $(this).closest('ul').find('input.blur'), totSen = 0;
		
		$.each(input,function(i,e){
			if($(e).hasClass('blur') && e.id !== 'defsustraer'){
				if(this.value !== '') totSen += parseFloat(this.value);
			}
		});
		$('#ptotal').val(totSen);
		if($('#defsustraer').val() !== '' && $('#ptotal').val() !== '') $('#pfinal').val(parseFloat($('#ptotal').val()) - parseFloat($('#defsustraer').val()));
		else $('#pfinal').val($('#ptotal').val());

		/* Actualiza el grafico */
		if(window.radarChart){
			//window.radarChart.clear(), window.radarChart.destroy();
			window.radarChart.data.datasets[0].data[0] = $('#fragptos').val();
			window.radarChart.data.datasets[0].data[1] = $('#sabptos').val();
			window.radarChart.data.datasets[0].data[2] = $('#sabreptos').val();
			window.radarChart.data.datasets[0].data[3] = $('#aciptos').val();
			window.radarChart.data.datasets[0].data[4] = $('#cuerptos').val();
			window.radarChart.data.datasets[0].data[5] = $('#uniptos').val();
			window.radarChart.data.datasets[0].data[6] = $('#balptos').val();
			window.radarChart.data.datasets[0].data[7] = $('#tazptos').val();
			window.radarChart.data.datasets[0].data[8] = $('#dulptos').val();
			window.radarChart.data.datasets[0].data[9] = $('#apreptos').val();
			window.radarChart.update();
			window.radarChart.options.animation.onComplete = function(){ $('#grafico').val(document.getElementById('grafica').toDataURL('image/png')); }
		}

	}else if(id === 'defsustraer'){
		if($('#defsustraer').val() !== '' && $('#ptotal').val() !== '') $('#pfinal').val(parseFloat($('#ptotal').val()) - parseFloat($('#defsustraer').val()));
		else $('#pfinal').val($('#ptotal').val());
	}else if(id === 'monto'){
		if($('#tipoCaja').val() === '9'){
			if(this.value !== '' && parseFloat(this.value) > 0){
				let base = this.value;
				if($('#checkrenta').prop('checked')){
					let mto = base * 0.08; base = parseFloat(this.value) - mto; $('#renta').val(formatMoneda(mto)); $('#imp_renta').val(mto);
				}
				else if($('#checkigv').prop('checked')){
					base = parseFloat(this.value) / 1.18; let mto = parseFloat(this.value) - base; $('#igv').val(formatMoneda(mto)); $('#imp_igv').val(mto);
				}
				$('#baseImp').val(formatMoneda(base));
				$('#base_imponible').val(base);
			}else $('#baseImp').val('');
		}
	}else if(id === 'montocobro'){
		let mtop = parseFloat($('#mtoprestamo').val());
		//console.log(this.value);
		//console.log(parseFloat($('#mtoprestamo').val()));
		if(parseFloat(this.value) == mtop) $('#checkliquida').prop('checked', true);
		else if(parseFloat(this.value) > mtop){
			$('#checkliquida').removeAttr('checked');
			this.value = "";
			alert('El Monto del cobro no puede ser mayor al préstamo');
			$(this).focus();
		}else if(parseFloat(this.value) < mtop) $('#checkliquida').removeAttr('checked');
		
	}else if(id === 'interescobro'){
		let intp = parseFloat($('#intprestamo').val());
		if(parseFloat(this.value) > intp){
			this.value = "";
			alert('El pago de intereses no puede ser mayor a los intereses generados');
			$(this).focus();
		}
	}else if(id === 'montopago'){
		let mtop = parseFloat($('#mtopago').val());
		//console.log(this.value);
		//console.log(parseFloat($('#mtopago').val()));
		if(parseFloat(this.value) == mtop) $('#checkliquidapago').prop('checked', true);
		else if(parseFloat(this.value) > mtop){
			$('#checkliquidapago').removeAttr('checked');
			this.value = "";
			alert('El Monto del cobro no puede ser mayor al préstamo');
			$(this).focus();
		}else if(parseFloat(this.value) < mtop) $('#checkliquidapago').removeAttr('checked');
		
	}else if(id === 'interespago'){
		let intp = parseFloat($('#intpago').val());
		if(parseFloat(this.value) > intp){
			this.value = "";
			alert('El pago de intereses no puede ser mayor a los intereses generados');
			$(this).focus();
		}
	}else if(id === 'nronegro' || id === 'nroagrio' || id === 'nrocereza' || id === 'nrohongos' || id === 'nroextr' || id === 'nronegrop' || id === 'nroagriop'
		|| id === 'nroinsec' || id === 'nroperg' || id === 'nroflot' || id === 'nroinmad' || id === 'nroavera' || id === 'nroconc' || id === 'nroqueb' || id === 'nropul'
		|| id === 'nrolgins'){
		/* || id === 'uniptos' || id === 'balptos' || id === 'tazptos' || id === 'dulptos' || id === 'apreptos'*/
		let herm = $(this).closest('.row').find('.eq'), val = parseInt($(this).val()), container = $(this).closest('.container').find('.eq'), total = 0;		
		
		if(id === 'nronegro' || id === 'nroagrio' || id === 'nrocereza' || id === 'nrohongos' || id === 'nroextr'){ factor = 1; herm.val(parseInt(val) / factor); }
		else if(id === 'nronegrop' || id === 'nroagriop'){ factor = 3; herm.val(parseInt(val / factor)); }
		else if(id === 'nroinsec' || id === 'nroperg' || id === 'nroflot' || id === 'nroinmad' || id === 'nroavera' || id === 'nroconc' || id === 'nroqueb' || id === 'nropul'){
			factor = 5; herm.val(parseInt(val / factor));
		}else if(id === 'nrolgins'){ factor = 10; herm.val(parseInt(val / factor)); }
		
		$.each(container, function(i, e){ total += parseInt(e.value); });
		$('#totconteo').val(parseInt(total));
	}
	
});

/* Seleccionar texto al posicionarse sobre el campo */
$('.blur').focus(function(){ this.select(); });

/*$('.ruc').bind('click',function(){
	let ruc = $('#rucvalor').val();
	$.ajax({
		data: { ruc: ruc },
		url: base_url + 'main/ruccurl',
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function () {
			$(this).html('<i class="fa fa-search aria-hidden="true"></i>');
		},
		success: function (data) {
			$(this).html('Buscar');
			console.log(data);
		}
	});
});

$('#ruc_form').validate({
	errorClass: 'form_error',
	rules: {
		rucvalor: { required: function () { if ($('#rucvalor').css('display') != 'none') return true; else return false; }, minlength: 11 },
	},
	messages: {
		rucvalor: { required : '&nbsp;&nbsp;Ruc Requerido', minlength: '&nbsp;&nbsp;Debe ingresar 11 caracteres' },
	},
	errorPlacement: function(error, element) {
		let boton = $('#ruc_form button');
		error.insertAfter(boton);
	},
	submitHandler: function (form, event) {
		event.preventDefault();
		let boton = $('#ruc_form button'), ruc = $('#rucvalor').val();
		$.ajax({
			data: { ruc: ruc },
			url: base_url + 'main/ruccurl',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function(){ boton.addClass('pt-0'), boton.html('<span class="spinner-border spinner-border-sm"></span>'); },
			success: function (data) {
				boton.addClass('pt-0'), boton.html('<i class="fa fa-search aria-hidden="true"></i>');
				if(data.status === 200) console.log(data);
				else alert(data.data.error);
			}
		});
		//return false;
	}
});*/
$('#buscaRuc').on('click',function(){
	let ruc = $('#rucvalor').val(), val = true, bot = $(this); $('#razonSoc').val('');
	if(ruc.length == ''){ alert('Debe indicar un número de RUC'); val = false; $('#rucvalor').val(''); $('#rucvalor').focus(); return false; }
	if(ruc.length < 11){ alert('El RUC debe tener 11 dígitos'); val = false; $('#rucvalor').val(''); $('#rucvalor').focus(); return false; }
	
	if(val){
		$.ajax({
			data: { ruc: ruc },
			url: base_url + 'main/ruccurl',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function(){ bot.addClass('pt-0'), bot.html('<span class="spinner-border spinner-border-sm"></span>'); },
			success: function (data) {
				bot.removeClass('pt-0'), bot.html('<i class="fa fa-search aria-hidden="true"></i>');
				if(data.status === 200){ $('#razonSoc').val(data.data.nombre); }
				else{ alert(data.data.error); $('#rucvalor').val(''); $('#rucvalor').focus(); }
			}
		});
	}
});
$('#busca_ruc').on('click',function(){
	let ruc = $('#ruc').val(), val = true, bot = $(this); $('#nombres').val(''), $('#direccion').val('');
	if(ruc.length == ''){ alert('Debe indicar un número de RUC'); val = false; $('#ruc').val(''); $('#ruc').focus(); return false; }
	if(ruc.length < 11){ alert('El RUC debe tener 11 dígitos'); val = false; $('#ruc').val(''); $('#ruc').focus(); return false; }
	
	if(val){
		$.ajax({
			data: { ruc: ruc },
			url: base_url + 'main/ruccurl',
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function(){ bot.addClass('pt-0'), bot.html('<span class="spinner-border spinner-border-sm"></span>'); },
			success: function (data) {
				bot.removeClass('pt-0'), bot.html('<i class="fa fa-search aria-hidden="true"></i>');
				if(data.status === 200){ $('#nombres').val(data.data.nombre), $('#doc').val('00000000'); $('#tipodoc').prop('selectedIndex',0); }
				else{ alert(data.data.error); $('#ruc').val(''); $('#ruc').focus(); }
			}
		});
	}
});

$('table').on('click','tr',function(event){
	let tabla = $(this).closest('table');
	if(tabla.hasClass('t-sel')){
		let bot = $(this).find('.btnTable');
		if($(this).hasClass('selected')) {
			//$(this).removeClass('selected');
		}else{
			$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		}
		$.each(bot,function(i,e){
			//console.log(e);
			if(!$(e).hasClass('disabled')){ $(e).css('color','#fff'); }
			if($(e).hasClass('btnActivar')){ $(e).css('color','red'); }
			if($(e).hasClass('btnDesactivar')){ $(e).css('color','green'); }
		});
	}
});