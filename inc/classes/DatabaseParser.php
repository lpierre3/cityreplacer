<?php

class DatabaseParser
{
    public function __construct() {

    }

    public function parse(array $stringsToReplace, string $data = null) {
        $formattedString = null;

        if (isset($data) && isset($stringsToReplace)) {
            $formattedString = $data;
            foreach ($stringsToReplace as $replaceString) {
                $formattedString = $this->strip($replaceString, $formattedString);
            }
        }
        return $formattedString;
    }

    public function strip(string $needle, string $haystack) {
        $tempString = '';
        $resultString = '';
        $joined = false;
        $allDataCharacters = str_split($haystack);
        $totalDataCharacters = count($allDataCharacters);

        for ($dataPos = 0; $dataPos < $totalDataCharacters; ++$dataPos) {
            $tempString .= $allDataCharacters[$dataPos];

            if (strncmp($tempString, $needle, strlen($tempString)) === 0) {
                $pos = strpos($tempString, $needle);

                if (($pos !== false) && ($pos == 0)) {
                    if (((($dataPos + 1) == $totalDataCharacters) || ($allDataCharacters[$dataPos + 1] == ".") || ($allDataCharacters[$dataPos + 1] == " ")) && !$joined) {
                        $resultString .= $tempString;
                    }
                    $tempString = '';
                }
            } else {
                if (($dataPos + 1) < $totalDataCharacters) {
                    if (($allDataCharacters[$dataPos] == ' ') || ($allDataCharacters[$dataPos + 1] == ' ')) {
                        $joined = false;
                    } else {
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
}