<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Бета-версия класса SimilarText
 *
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @package StringUtils
 */
class StringUtils_SimilarText {

    /**
     * Определить схожесть двух текстов (результат - float 0..1)
     * Алгоротм ебановротный ужасный.
     *
     * @author Maxim Miroshnichenko <max@webproduction.com.ua>
     * @param string $originalText
     * @param string $similarText
     * @return float
     */
    public static function CalculateSimilarText($originalText, $similarText) {
        $original = self::_GetMatchWords($originalText);
        if (!$original) {
            return 0;
        }

        $name = self::_GetMatchWords($similarText);
        if (!$name) {
            return 0;
        }

        $c = 0;
        $lf = 0;
        foreach ($name as $x) {
            // print "$x:\n";
            foreach ($original as $y) {
                // print "$x - $y\n";
                if (preg_match("/^{$y}/uis", $x)) {
                    $c++;
                    $lf += mb_strlen($x);
                    // print "0: $x - $y\n";
                    break;
                } elseif (preg_match("/^{$x}/uis", $y)) {
                    $c++;
                    $lf += mb_strlen($y);
                    // print "1: $x - $y\n";
                    break;
                }
            }
        }
        // print count($original)."\n";
        // print count($name)."\n";
        // $cnt = min(count($original), count($name));
        // if ($cnt <= 0) return 0;
        // var_dump($cnt);
        // var_dump($c);

        // строим суммарный массив всех слов
        $summary = array();
        foreach ($original as $x) {
            $summary[$x] = mb_strlen($x);
        }
        foreach ($name as $x) {
            $summary[$x] = mb_strlen($x);
        }
        $cf = 0;
        foreach ($summary as $x) {
            $cf += $x;
        }

        return $lf / $cf;

        //print "found=$lf\n";
        // print "size=$cf\n\n";

        // с - количество совпадений
        // cnt - количество слов

        /*if ($c >= $cnt) {
        return 1;
        } else {
        return ($c / $cnt);
        }*/
    }

    private static function _GetMatchWords($string) {
        preg_match_all('/([\pL\d]+)/uis', $string, $r);

        $a = array();
        foreach ($r[0] as $i => $x) {
            $x = mb_strtolower($x);
            $l = mb_strlen($x);

            if (!is_numeric($x)) {
                if ($l <= 3) {
                    continue;
                } elseif ($l >= 4 && $l <= 6) {
                    $x = mb_substr($x, 0, $l-1);
                } else {
                    $x = mb_substr($x, 0, $l-2);
                }
            }

            $x = StringUtils_Converter::Transcription($x);
            $a[] = $x;
        }

        return $a;
    }

}