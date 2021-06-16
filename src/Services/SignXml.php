<?php

namespace App\Services;

/**
 * Class SignXml
 * @package SignXml
 */
class SignXml {

    /**
     * @var string
     */
    private $executableJar;

    /**
     * @var string
     */
    private $java = "java -jar";

    /**
     * FirmarFacturae constructor.
     */
    function __construct() {
        $this->executableJar = dirname(__DIR__) . "/../bin/FirmaGestor.jar";
    }

    /**
     * @param $xml
     * @param $cert
     * @param $password
     * @return string
     * @throws \Exception
     */
    public function sign($xml, $cert, $password, $fileName , $path) {
        try {
            // Generate the command to sign the XML
            $command = $this->buildCommand($xml, $cert, $password, $fileName, $path);

            // Execute the command
            exec($command, $output, $return_var);

            if ($return_var != 0) {
                throw new \Exception("Error: Could not sign the XML", 1);
            }
            $status = true;
        } catch (\Exception $exc) {
            $status = false;
        }
        return $status;
    }

    /**
     * @param $xml
     * @param $cert
     * @param $password
     * @return string
     */
    private function buildCommand($xml, $cert, $password, $fileName, $path) {
        try {
            $name = dirname(__DIR__) . "/files/xml_local/".$path."/xsig_" . $fileName;
            return escapeshellcmd("{$this->java} {$this->executableJar} {$xml} {$name} {$cert} {$password}");
        } catch (\Exception $exc) {
            return false;
        }
    }

    
    /**
     * Extraido de http://ecapy.com/reemplazar-la-n-acentos-espacios-y-caracteres-especiales-con-php-actualizada/
     * Reemplaza todos los acentos por sus equivalentes sin ellos
     *
     * @param $string
     *  string la cadena a sanear
     *
     * @return $string
     *  string saneada
     */
    public function clearSpecialCharacters($string)
    {

        $string = trim($string);

        $string = str_replace(
            ['á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'],
            ['a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'],
            $string
        );

        $string = str_replace(
            ['é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'],
            ['e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'],
            $string
        );

        $string = str_replace(
            ['í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'],
            ['i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'],
            $string
        );

        $string = str_replace(
            ['ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'],
            ['o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'],
            $string
        );

        $string = str_replace(
            ['ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'],
            ['u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'],
            $string
        );

        $string = str_replace(
            ['ñ', 'Ñ', 'ç', 'Ç'],
            ['n', 'N', 'c', 'C',],
            $string
        );

        $string = str_replace(
            [
                "\\", "¨", "º", "-", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "<code>", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":",
                ".", " ",
            ],
            ' ',
            $string
        );
        $string = trim(preg_replace('/\s+/', ' ', $string));
        return trim($string);
    }
}
