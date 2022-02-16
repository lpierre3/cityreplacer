<?php

//namespace CityParser;

class DatabaseParser
{
    public function __construct() {

    }

    public function parse(array $stringsToReplace,string $data = null) {
        $formattedString = null;

        if(isset($data) && isset($stringsToReplace)) {
            $formattedString = $data;
            foreach ($stringsToReplace as $replaceString) {
                //echo "CHECKING------------>".$replaceString.' ---- in ---- '.$formattedString.'<br/><br/><br/>';
                $formattedString = $this->strip($replaceString,$formattedString);
            }
        }
        return $formattedString;
    }

    public function strip(string $needle,string $haystack) {
        $tempString = '';
        $resultString = '';
        $matchedString = '';
        $joined = false;
        $allDataCharacters = str_split($haystack);
        $totalDataCharacters = count($allDataCharacters);

        for ($dataPos = 0; $dataPos < $totalDataCharacters; ++$dataPos) {
            $tempString .= $allDataCharacters[$dataPos];

            //echo "TEMP STRING=".$tempString.' dpos='.$dataPos.'<br/>';
            if (strncmp($tempString, $needle, strlen($tempString)) === 0) {
                $pos = strpos($tempString, $needle);

                if (($pos !== false) && ($pos == 0)) {
                    //echo "in here-->".$tempString.'<br/>';
                    //echo "totalcars=".$totalDataCharacters.' datapos='.$dataPos.'<br/>';
                    //echo "next charac==".$allDataCharacters[$dataPos+1].'<br/>';
                    /*ctype_space($allDataCharacters[$dataPos + 1])*/
                    if (( (($dataPos + 1) == $totalDataCharacters) || ($allDataCharacters[$dataPos+1] == ".") || ($allDataCharacters[$dataPos+1] == " ")) && !$joined) {
                        $resultString .= $tempString;
                        //echo "got it==>".$tempString."<br/>";
                    }
                    $tempString = '';
                }
                //$joined = false;
            } else {
                //if (ctype_space($allDataCharacters[$dataPos])) {
                //if(preg_match("/[,;:.?!]/",$allDataCharacters[$dataPos])) {
                //if($allDataCharacters[$dataPos] == ".") {
                //if ( (($dataPos + 1) == $totalDataCharacters) || ($allDataCharacters[$dataPos+1] != ' ')) {
                if (($dataPos + 1) < $totalDataCharacters ) {
                    if(($allDataCharacters[$dataPos]==' ') || ($allDataCharacters[$dataPos+1] == ' ')) {
                        //echo "NOT JOINEDD----->".$tempString.' pos='.($dataPos+1).'<br/>';
                        $joined = false;
                    }else {
                        //echo "JOINEDD----->".$tempString.' pos='.$dataPos.'<br/>';
                        $joined = true;
                    }
                }

                if (strlen($tempString) > 1) {
                    $resultString .= mb_substr($tempString, 0, -1);
                    --$dataPos;
                } else {
                    $resultString .= $tempString;
                }
                $tempString = '';
            }
        }
        return $resultString;
    }

    /*public function parseOld(array $stringsToReplace, string $data = null) {
        $isFirst = false;
        $replacement = '';
        $result = '';
        $formattedString = null;
        $pos = 0;

        if (isset($data) && isset($stringsToReplace)) {
            $allFields = explode(' ', $data);


            foreach ($allFields as $field) {
                //echo "checking field==" . $field . '<br/>';
                $parseString = $field;

                if ($isFirst) {
                    $parseString = $field;
                    $isFirst = false;
                } else {
                    $result .= ' ';
                }

                foreach ($stringsToReplace as $replaceString) {
                    $pattern = "/$replaceString([^.]){1,}/i";
                    $pos = strpos($parseString, $replaceString);

                    //echo "pattern====>".$pattern.'<br/>';

                    if ($pos !== false) {
                        //echo "compareing replace=".$replaceString.' with parse='.$parseString.'<br/>';
                        if (($pos == 0) && (strcmp($replaceString,$parseString) !=0)) {
                            $parseString = preg_replace($pattern, $replacement, $parseString);
                        }
                    }
                }

                $result .= $parseString;
            }
        }
        return $result;
    }*/
}