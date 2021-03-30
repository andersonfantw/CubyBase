<?php

namespace CubyBase\SMS;

use Illuminate\Support\Facades\Validator;
use CubyBase\Common\Phone;

trait SMSMessageable
{
    protected function isValidPhone($phone): bool
    {
        return Phone::parse($phone)->isValid();
    }
    protected function isValidDate($date)
    {
        return Validator::make(['d'=>$date],['d'=>'date'])->passes();
    }

    protected function Text2Unicode($str): string
    {
        $unicode = array();
        $values = array();
        $lookingFor = 1;
        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < ord('A')) {
                if ($thisValue >= ord('0') && $thisValue <= ord('9')) {
                    $unicode[] = '00' . dechex($thisValue);
                } else {
                    $unicode[] = '00' . dechex($thisValue);
                }
            } else {
                if ($thisValue < 128) {
                    $unicode[] = '00' . dechex($thisValue);
                } else {
                    if (count($values) == 0) {
                        $lookingFor = ($thisValue < 224) ? 2 : 3;
                    }

                    $values[] = $thisValue;
                    if (count($values) == $lookingFor) {
                        $number = ($lookingFor == 3) ?
                        (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64) :
                        (($values[0] % 32) * 64) + ($values[1] % 64);
                        $number = dechex($number);
                        $unicode[] = (strlen($number) == 3) ? "0" . $number : "" . $number;
                        $values = array();
                        $lookingFor = 1;
                    }
                }
            }
        }
        for ($i = 0; $i < count($unicode); $i++) {
            $unicode[$i] = str_pad($unicode[$i], 4, "0", STR_PAD_LEFT);
        }
        return implode("", $unicode);
    }
}
