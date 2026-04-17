<?php
class ArrayUtils
{
    /**
     * Extract all values from array1 that also exist in array2.
     * This validates containment.
     */
    public static function extractContained(array $array1, array $array2)
    {
        // array_intersect returns only matching values
        $result = array_intersect($array1, $array2);

        return array_values($result); // ensure clean indexing
    }
}