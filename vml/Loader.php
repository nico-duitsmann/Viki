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
        $this->loadVml($vml_storage);
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
    private function loadVml(string $vml_file): void {
        if ( !is_file($vml_file) || !file_exists($vml_file) ) {
            echo "$vml_file does not exists or was not found.".PHP_EOL;
        } else {
            echo "Load vml $vml_file (".filesize($vml_file)." bytes)";

            // Load xml file to associative array
            $xml  = file_get_contents($vml_file);
            $obj  = simplexml_load_string($xml);
            $json = json_encode($obj);
            $vml  = json_decode($json, true);
            
            $this->vml_loaded = $vml;
        }
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
