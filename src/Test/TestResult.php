<?php
declare(strict_types=1);

namespace DiContainerBenchmarks\Test;

class TestResult
{
    /**
     * @var float|null
     */
    private $timeConsumption;

    /**
     * @var float|null
     */
    private $peakMemoryUsage;

    public static function createFromJson(string $json): TestResult
    {
        $result = json_decode($json, true);

        if ($result === null) {
            return new TestResult(null, null);
        }

        return new TestResult($result["time"], $result["memory"]);
    }

    public static function create(float $startTime, float $endTime, int $peakMemoryUsageInBytes): TestResult
    {
        return new TestResult(($endTime - $startTime) * 1000, $peakMemoryUsageInBytes / 1024 / 1024);
    }

    public function __construct(?float $timeConsumptionInMilliseconds, ?float $peakMemoryUsageInMegaBytes)
    {
        $this->timeConsumption = $timeConsumptionInMilliseconds;
        $this->peakMemoryUsage = $peakMemoryUsageInMegaBytes;
    }

    public function toJson(): string
    {
        return json_encode(
            [
                "time" => $this->timeConsumption,
                "memory" => $this->peakMemoryUsage,
            ]
        );
    }

    public function getTimeConsumptionInMilliSeconds(): ?float
    {
        return $this->timeConsumption;
    }

    public function getPeakMemoryUsageInMegaBytes(): ?float
    {
        return $this->peakMemoryUsage;
    }
}
