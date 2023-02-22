<?php
declare(strict_types=1);

namespace Flynn314\DateTime;

final class JrTime
{
    /**
     * @param int    $seconds
     * @param string $glue space or no space => 23d 32m or 23d32m
     * @return string
     */
    public function format(int $seconds, string $glue = ''): string
    {
        return $this->formatTo([], $seconds, true, $glue);
    }

    public function formatSimple(int $seconds): string
    {
        return $this->formatTo([], $seconds, false, '');
    }

    public function formatWithCustomDayLength(int $seconds, int $dayLengthInHours, bool $precise = true, string $glue = ''): string
    {
        return $this->formatTo([
            'y' => 3600 * $dayLengthInHours * 7 * 365,
            'w' => 3600 * $dayLengthInHours * 7,
            'd' => 3600 * $dayLengthInHours,
            'h' => 3600,
            'm' => 60,
        ], $seconds, $precise, $glue);
    }

    private function formatTo(array $mapping, int $seconds, bool $precise, string $glue): string
    {
        if (!$mapping) {
            $mapping = [
                'y' => 31536000,
                'w' => 604800,
                'd' => 86400,
                'h' => 3600,
                'm' => 60,
            ];
        }

        $formatted = [];
        foreach ($mapping as $l => $s) {
            if ($seconds >= $s){
                $formatted[$l] = floor($seconds/$s).$l;
                $seconds = $seconds % $s;
                if (!$precise) {
                    return implode(' ', $formatted);
                }
            }
        }
        if ($seconds) {
            $formatted['s'] = $seconds.'s';
        }

        return implode($glue, $formatted);
    }
}
