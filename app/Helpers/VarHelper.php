<?php

namespace App\Helpers;


class VarHelper
{

    /**
     * Transform array to object
     *
     * @param array $data
     * @return object
     */
    public static function arrayToObject(array $data)
    {
        return json_decode(json_encode($data));
    }

    /**
     * Transform object to array
     *
     * @param object $data
     * @return array
     */
    public static function objectToArray(object $data)
    {
        return json_decode(json_encode($data), true);
    }

    /**
     * If a string is filled, it returns it, otherwise it returns an empty string
     *
     * @param string|null $string
     * @return string
     */
    public static function stringEmpty(?string $string)
    {
        return (!isset($string) or empty($string)) ? '' : $string;
    }

    /**
     * Format string to camelCase
     * 
     * @param string $string
     * @return string
     */
    public static function stringToCamelCase(string $string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Format CamelCase to spaces between each word
     *
     * @param string $string
     * @return string
     */
    public static function camelCaseToSpaces(string $string)
    {
        return preg_replace('/([a-z0-9])([A-Z])/', "$1 $2", $string);
    }

    /**
     * Remove tabs on string
     *
     * @param string $string
     * @return string
     */
    public static function removeTabs(string $string)
    {
        return preg_replace('/[ ]{2,}|[\t]/', '', trim($string));
    }

    /**
     * Check if integer is even number
     *
     * @param int $number
     * @return bool
     */
    public static function isEvenNumber(int $number)
    {
        return ($number % 2 == 0);
    }

    /**
     * Check if var is an associative array
     * 
     * @param $var
     * @return bool
     */
    public static function isAssociativeArray($var)
    {
        return is_array($var) && array_keys($var) !== range(0, count($var) - 1);
    }

    /**
     * Return an array of objects
     * 
     * @param array $array
     * @return array<object...>
     */
    public static function newArrayOfObjects(array $array)
    {
        return array_map(fn ($item) => (object) $item, $array);
    }

    /**
     * Remove accents from string
     * 
     * @param string $string
     * @return string
     */
    public static function removeAccents(string $string)
    {
        $string = str_replace(
            ['Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'],
            ['A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'],
            $string
        );

        $string = str_replace(
            ['É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'],
            ['E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'],
            $string
        );

        $string = str_replace(
            ['Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'],
            ['I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'],
            $string
        );

        $string = str_replace(
            ['Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'],
            ['O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'],
            $string
        );

        $string = str_replace(
            ['Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'],
            ['U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'],
            $string
        );

        $string = str_replace(
            ['Ñ', 'ñ', 'Ç', 'ç'],
            ['N', 'n', 'C', 'c'],
            $string
        );

        return $string;
    }

    /**
     * Remove spaces at last of string
     * 
     * @param string $string
     * @return string
     */
    public static function removeSpacesAtLast(string $string)
    {
        return preg_replace('/\s+$/', '', $string);
    }

    /**
     * Return param only if app is in debug mode, if not return empty string
     * 
     * @param string|int $param
     * @return string|int
     */
    public static function returnDebug($param)
    {
        return (config('app.debug')) ? $param : '';
    }

    /**
     * Return format pagination object from array query pagination
     * 
     * @param array $queryPagination
     * @return object
     */
    public static function formatPagination(array $queryPagination)
    {
        return (object) [
            'current_page'   => $queryPagination['current_page'],
            'last_page'      => $queryPagination['last_page'],
            'total_items'    => $queryPagination['total'],
            'items_per_page' => (int) $queryPagination['per_page'],
            'showing'        => ($queryPagination['to'] - $queryPagination['from']) + 1,
            'from'           => $queryPagination['from'],
            'to'             => $queryPagination['to'],
            'data'           => collect($queryPagination['data'])->map(fn ($item) => (object) $item),
        ];
    }

    /**
     * Convert number to negative value
     * 
     * @param float $number
     * @return float
     */
    public static function negativeNumber(float $number)
    {
        if ($number > 0) {
            $number = $number * -1;
        }

        return $number;
    }
}
