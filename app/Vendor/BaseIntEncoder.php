<?php
// Original code from http://snook.ca/archives/php/url-shortener/#c63597
// rajesh_04ag02 // 2009-06-10 // minor function name changes for aesthetics
// Usage: BaseIntEncoder::encode(100)
//   and  BaseIntEncoder::decode('3J')

class BaseIntEncoder
{
    //const $codeset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //readable character set excluded (0,O,1,l)
    const codeset = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    static private function _bcFloor($x)
    {
        return bcmul($x, '1', 0);
    }
    static private function _bcCeil($x)
    {
        $floor = _bcFloor($x);
        return bcadd($floor, ceil(bcsub($x, $floor)));
    }
    static private function _bcRound($x)
    {
        $floor = _bcFloor($x);
        return bcadd($floor, round(bcsub($x, $floor)));
    }
    static function encode($n)
    {
        $base = strlen(self::codeset);
        $converted = '';
        while ($n > 0) {
            $converted = substr(self::codeset, bcmod($n, $base) , 1) . $converted;
            $n = self::_bcFloor(bcdiv($n, $base));
        }
        return $converted;
    }
    static function decode($code)
    {
        $base = strlen(self::codeset);
        $c = '0';
        for ($i = strlen($code); $i; $i--) {
            $c = bcadd($c, bcmul(strpos(self::codeset, substr($code, (-1 * ($i - strlen($code))) , 1)) , bcpow($base, $i - 1)));
        }
        return bcmul($c, 1, 0);
    }
}
?>