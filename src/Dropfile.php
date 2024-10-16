<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

use Nahkampf\Deadlock\DropfileParser;
use Nahkampf\Deadlock\DropfileType;

class Dropfile
{
    public const string ERR_FILENOTEXIST = "Can't find dropfile";
    public const string ERR_NODATA = "Dropfile empty or not readable";
    public const string ERR_UNSUPPORTEDFORMAT = "Unknown or unsuppoted dropfile format";
    public const string ERR_PARSING = "Parsing error, check your dropfile format";
    public const string ERR_USERID = "Could not determine user ID, something wrong with dropfile?";

    public DropfileType $dropfileType;
    public array $doorFileData;
    public int $userId;
    public ?string $handle;
    public int $minutesLeft;

    public function __construct(string $path, DropfileType $type, ?array $args = null)
    {
        $this->dropfileType = $type;
        if ($args) {
            $this->doorFileData = [
                "userId" => (int)$args["userid"],
                "minutesLeft" => (int)$args["minutes"],
                "handle" => trim(substr($args["handle"], 0, 64))
            ];
        } else {
            $rawData = $this->read($path);
            $doorFileData = $this->parse($rawData, $type);
        }
    }

    /**
     * @throws \Error
     */
    private function read(string $filepath): string
    {
        if (!file_exists($filepath)) {
            throw new \Error(self::ERR_FILENOTEXIST . " ({$filepath})");
            exit;
        }
        $data = @file_get_contents($filepath);
        if (!$data) {
            throw new \Error(self::ERR_NODATA);
            exit;
        }
        return $data;
    }

    private function parse(string $data, DropfileType $type = DropfileType::DOOR32SYS): array
    {
        $dataArray = @explode("\r\n", $data);
        $this->doorFileData = $dataArray;
        switch ($type) {
            case DropfileType::DOOR32SYS:
                if (count($dataArray) < 11) {
                    throw new \Error(self::ERR_PARSING);
                    exit;
                }
                $dropInfo["userId"] = @(int)$dataArray[4];
                $dropInfo["handle"] = @$dataArray[6];
                $dropInfo["minutesLeft"] = @$dataArray[8];
                if ((int)$dropInfo["userId"] == 0) {
                    throw new \Error(self::ERR_USERID);
                }
                if ((int)$dropInfo["minutesLeft"] < 1) {
                    Utils::hangup("No time left today!");
                }
                return $dropInfo;
                break;
            case DropfileType::DOORSYS:
                if (count($dataArray) < 31) {
                    throw new \Error(self::ERR_PARSING);
                    exit;
                }
                $dropInfo["userId"] = @(int)$dataArray[26];
                $dropInfo["handle"] = @$dataArray[36];
                $dropInfo["minutesLeft"] = @$dataArray[19];
                if ((int)$dropInfo["userId"] == 0) {
                    throw new \Error(self::ERR_USERID);
                }
                if ((int)$dropInfo["minutesLeft"] < 1) {
                    Utils::hangup("No time left today!");
                }
                return $dropInfo;
                break;
            default:
                throw new \Error(self::ERR_UNSUPPORTEDFORMAT);
                exit;
                break;
        }
    }
}
