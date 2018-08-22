<?php

class cTextLog {

    protected $_path = "/dojo/log/";

    public function __construct($details = NULL) {
        $this->_path = $_SERVER["DOCUMENT_ROOT"].$this->_path;
        if (!file_exists($this->_path) || !is_dir($this->_path)) {
            mkdir($this->_path);
            if (!file_exists($this->_path."log.txt"))
                fopen($this->_path."log.txt", "w");
        }
    }

    public function write($value, $name = "") {
        $str = date(DATE_RSS)." (".$name.") : ".PHP_EOL;
        switch(gettype($value)) {
            case "array":
                $value = json_encode($value, JSON_PRETTY_PRINT);
            break;
            case "object":
                $value = $value->expJson();
                break;
        }
        $str .= $value.PHP_EOL.PHP_EOL;
        $fc = file_get_contents($this->_path."log.txt");
        if (file_put_contents($this->_path."log.txt", $str.$fc))
            return (1);
        return (0);
    }
}

?>