	<?php

class Dotenv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    private $path;
	
	public function __construct($path)
	{
		$this->path = $path.'.env';
	}
	
    public function loadFile()
    {
		if(!file_exists($this->path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $this->path));
			return;
        }		
		
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }
		
        $this->env();
    }
	
	public function loadURL()
    {
		if(! $this->url_exists($this->path)) {
            throw new \InvalidArgumentException(sprintf('%s URL No existe', $this->path));
			return;
        }
		
		$this->env();
    }
	
	private function env()
	{
		$lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }
			if(! ctype_space($line)){
				list($name, $value) = explode('=', $line, 2);
				$name = trim($name);
				$value = trim($value);
				if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
					putenv(sprintf('%s=%s', $name, $value));
					$_ENV[$name] = $value;
					$_SERVER[$name] = $value;
				}
			}
        }
	}
	
	function url_exists( $url = NULL ) {
		
		if( empty( $url ) ){ return false; }

		$ch = curl_init( $url );
	 
		// Establecer un tiempo de espera
		curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

		// Establecer NOBODY en true para hacer una solicitud tipo HEAD
		curl_setopt( $ch, CURLOPT_NOBODY, true );
		// Permitir seguir redireccionamientos
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		// Recibir la respuesta como string, no output
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		// Descomentar si tu servidor requiere un user-agent, referrer u otra configuración específica
		// $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36';
		// curl_setopt($ch, CURLOPT_USERAGENT, $agent)

		$data = curl_exec( $ch );

		// Obtener el código de respuesta
		$httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		//cerrar conexión
		curl_close( $ch );

		// Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
		$accepted_response = array( 200, 301, 302 );
		if( in_array( $httpcode, $accepted_response ) ) return true;
		else return false;
	}
}