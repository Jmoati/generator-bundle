<?php

declare(strict_types=1);

namespace Jmoati\GeneratorBundle\Service;

class Singularize
{
    /**
     * @var array
     */
    protected static $irregular = [
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'sex' => 'sexes',
        'move' => 'moves',
    ];
    /**
     * @var array
     */
    protected static $ignore = [
        'equipment',
        'information',
        'rice',
        'money',
        'species',
        'series',
        'fish',
        'sheep',
        'press',
        'sms',
    ];
    /**
     * @var array
     */
    protected static $singular = [
        '/(quiz)zes$/i' => '\\1',
        '/(matr)ices$/i' => '\\1ix',
        '/(vert|ind)ices$/i' => '\\1ex',
        '/^(ox)en/i' => '\\1',
        '/(alias|status)es$/i' => '\\1',
        '/([octop|vir])i$/i' => '\\1us',
        '/(cris|ax|test)es$/i' => '\\1is',
        '/(shoe)s$/i' => '\\1',
        '/(o)es$/i' => '\\1',
        '/(bus)es$/i' => '\\1',
        '/([m|l])ice$/i' => '\\1ouse',
        '/(x|ch|ss|sh)es$/i' => '\\1',
        '/(m)ovies$/i' => '\\1ovie',
        '/(s)eries$/i' => '\\1eries',
        '/([^aeiouy]|qu)ies$/i' => '\\1y',
        '/([lr])ves$/i' => '\\1f',
        '/(tive)s$/i' => '\\1',
        '/(hive)s$/i' => '\\1',
        '/([^f])ves$/i' => '\\1fe',
        '/(^analy)ses$/i' => '\\1sis',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\\1\\2sis',
        '/([ti])a$/i' => '\\1um',
        '/(n)ews$/i' => '\\1ews',
        '/s$/i' => '',
    ];

    /**
     * @param string $word
     *
     * @return string
     */
    public function word($word)
    {
        $lower_word = mb_strtolower($word);

        foreach (self::$ignore as $ignore_word) {
            if (mb_substr($lower_word, (-1 * mb_strlen($ignore_word))) == $ignore_word) {
                return $word;
            }
        }

        foreach (self::$irregular as $singular_word => $plural_word) {
            if (preg_match('/('.$plural_word.')$/i', $word, $arr)) {
                return preg_replace(
                    '/('.$plural_word.')$/i',
                    mb_substr($arr[0], 0, 1).mb_substr($singular_word, 1),
                    $word
                );
            }
        }

        foreach (self::$singular as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }

        return $word;
    }
}
