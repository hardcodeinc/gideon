<?php

namespace Gideon\Util;

class Configuration
{
    public static function loadFile($file = 'gideon.json')
    {
        if (!file_exists($file)) {
            return self::loadGlobalFile($file);
        }

        return json_decode(file_get_contents($file));
    }

    public static function loadGlobalFile($file = 'gideon.json')
    {
        $filePath = sprintf('%s/%s', BASE_PATH, $file);

        if (!file_exists($filePath)) {
            throw new \Exception(sprintf('File not found (%s). Try to run the config command.', $filePath));
        }

        return self::loadFile($filePath);
    }

    public static function writeToFile(array $data, $file = 'gideon.json')
    {
        $fileData = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        if (!file_put_contents($file, $fileData)) {
            throw new \Exception('Unable to write to the file '.$file);
        }
    }
}
