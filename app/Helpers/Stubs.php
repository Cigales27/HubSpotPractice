<?php

namespace App\Helpers;

use Illuminate\Support\Str;

/**
 * Stubs class
 *
 */
class Stubs
{
    /**
     * Get the stub path and the stub variables
     *
     * @param string $stubPath
     * @param array $stubData
     *
     * @return bool|mixed|string
     */
    public static function getSourceFile(string $stubPath, array $stubData)
    {
        $self = new self();
        return $self->getStubContents($stubPath, $stubData);
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stubPath
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    private function getStubContents($stubPath, $stubVariables = [])
    {
        $contents = file_get_contents($stubPath);

        foreach ($stubVariables as $search => $replace) {
            $contents = Str::replace("{{ {$search} }}", $replace, $contents);
        }

        return $contents;
    }
}
