let btnCurl = $('.btn_curl'), btnCancelar = $('.btn-cancelar'), imgperfil = $('.profile-pic'), perfiltop = $('.top-avatar');

$(document).ready(function (){
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	setTimeout(function () { $('.msg').hide('slow'); }, 3000);/**/
});

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
		$('.ruc').removeAttr('readonly'), $('.numcurl').removeAttr('readonly');/*, $('.nombres').attr('readonly', true), $('.apellidos').attr('readonly', true);*/
		$('.btn_curl').removeClass('disabled'), $('.btn_ruc').removeClass('disabled');/*, $('.usuario').attr('readonly', true);*/
	}
	
	$('.borra').val('');
	$('.perfil').val('2');
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
/* Seleccionar texto al posicionarse sobre el campo */
$('.blur').focus(function(){ this.select(); });

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