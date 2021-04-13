<?php

declare(strict_types = 1);

namespace App\Request\Traits;

use Hyperf\Utils\Arr;
use stdClass;

trait RequestHelper
{
    /**
     * Get a subset containing the provided keys with values from the input data.
     *
     * @param array|mixed $keys
     * @return array
     */
    public function only($keys): array
    {
        $results = [];

        $input = $this->all();

        $placeholder = new stdClass();

        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            $value = data_get($input, $key, $placeholder);

            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }

    /**
     * Get all of the input except for a specified array of items.
     *
     * @param array|mixed $keys
     * @return array
     */
    public function except($keys): array
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = $this->all();

        Arr::forget($results, $keys);

        return $results;
    }
}
