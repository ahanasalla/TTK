<?php
namespace TtkAccessParallaxPro;

/**
 * Class Helpers
 */
Class Helpers
{
    /**
     * @param $string
     * @param $endsWithString
     * @return bool
     */
    public static function endsWith($string, $endsWithString)
    {
        $stringLen = strlen($string);
        $endsWithStringLen = strlen($endsWithString);

        if ($endsWithStringLen > $stringLen) {
            return false;
        }

        return (substr_compare(
                $string,
                $endsWithString,
                $stringLen - $endsWithStringLen, $endsWithStringLen
            ) === 0);
    }

    /**
     * @param $content
     * @param string $replace
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function replaceStringWithStartEnd($content, $replace = '', $start, $end)
    {
        $pos = stripos($content, $start);

        $str = substr($content, $pos);
        $strTwo = substr($str, strlen($start));
        $secondPos = stripos($strTwo, $end);

        $extracted = substr($strTwo, 0, $secondPos);

        $content = str_ireplace($start . $extracted . $end, $replace, $content);

        return $content;
    }
}
