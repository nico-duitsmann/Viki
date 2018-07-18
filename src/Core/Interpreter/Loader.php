<?php

/**
 * Loader class.
 */
class Loader {

    /**
     * Vml storage autolader script path.
     *
     * @var string
     */
    protected $vml_storage;

    /**
     * Loaded vml.
     *
     * @var array
     */
    protected $vml_loaded = [];

    /**
     * Loader class constructor.
     *
     * @param string $vml_storage
     */
    function __construct(string $vml_storage) {
        is_dir($vml_storage) ? $this->loadVml($vml_storage) : die("$vml_storage is not a valid vml dir.");
    }

    /**
     * Return laoded vml.
     *
     * @return array
     */
    public function getVml(): array {
        return $this->vml_loaded;
    }

    /**
     * Load vml autoloader file.
     *
     * @param string $vml_file
     * @return void
     */
    private function loadVml(string $vml_path): void {
        $stream = '';
        // Search files
        $iter = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $vml_path, \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );
        foreach ($iter as $file => $_dir) {
            if ( !is_dir($_dir) )
                $stream .= file_get_contents($file);
        }

        $stream = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $stream);
        $stream = str_replace('<?vml version="0.1dev"?>', '', $stream);
        $stream = str_replace('<container>', '', $stream);
        $stream = str_replace('</container>', '', $stream);
        // $stream = str_replace(array("\n", "\r"), '', $stream);
        $vml_file =  '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
        $vml_file .= '<?vml version="0.1dev"?>'.PHP_EOL;
        $vml_file .= '<container>';
        $vml_file .= $stream;
        $vml_file .= '</container>';

        file_put_contents('compiled.vml', $vml_file);

        // Load xml file to associative array
        $xml  = file_get_contents('compiled.vml');
        $obj  = simplexml_load_string($xml);
        $json = json_encode($obj);
        $vml  = json_decode($json, true);
            
        $this->vml_loaded = $vml;
        unlink('compiled.vml');
    }

    /**
     * Validate vml file.
     *
     * @param string $vml_file
     * @return boolean
     */
    private function validateVml(string $vml_file): bool {
        // TODO
    }
}
