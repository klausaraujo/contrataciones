<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('is_logged')) {

    // VERIFICA SI
    function is_logged()
    {
        $CI = & get_instance();

        $tipo = $CI->session->userdata("tipo");
        if (strlen($tipo) > 0)
            return $tipo;
        else
            return 0;
    }
    function permisosBotones($permisos){
		
	}

}
