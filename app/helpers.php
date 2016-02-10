<?php

if (! function_exists('id'))
{
    /**
     * Transforms ID value
     *
     * @param int|string $value
     * @param string     $config
     *
     * @return int|string
     */
    function id($value, $config = 'main')
    {
        if (is_numeric($value))
            return \App\Utils\ID::encode($value, $config);

        return \App\Utils\ID::decode($value, $config);
    }
}