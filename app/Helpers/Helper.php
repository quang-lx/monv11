<?php


if (!function_exists('removeSign')) {

    function removeSign($str)
    {
        $hasSign = array(
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ', '&agrave;', '&aacute;', '&acirc;', '&atilde;',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ', '&egrave;', '&eacute;', '&ecirc;',
            'ì', 'í', 'ị', 'ỉ', 'ĩ', '&igrave;', '&iacute;', '&icirc;',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ', '&ograve;', '&oacute;', '&ocirc;', '&otilde;',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ', '&ugrave;', '&uacute;',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ', '&yacute;',
            'đ', '&eth;',
            'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;',
            'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ', '&Egrave;', '&Eacute;', '&Ecirc;',
            'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ', '&Igrave;', '&Iacute;', '&Icirc;',
            'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;',
            'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ', '&Ugrave;', '&Uacute;',
            'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ', '&Yacute;',
            'Đ', '&ETH;',
        );
        $noSign = array(
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y', 'y',
            'd', 'd',
            'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
            'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
            'I', 'I', 'I', 'I', 'I', 'I', 'I', 'I',
            'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y', 'Y', 'Y', 'Y', 'Y',
            'D', 'D'
        );

        $str = str_replace($hasSign, $noSign, $str);
        return $str;
    }
}

if (!function_exists('idic_convert_number_format')) {
    function idic_convert_number_format($str)
    {
        if(empty($str)) {
            return $str;
        }
        $str = str_replace(',', '.', $str);
        return is_numeric($str)? $str: null;
    }
}
