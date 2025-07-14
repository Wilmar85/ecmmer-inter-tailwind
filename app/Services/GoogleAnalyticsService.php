<?php
namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;

class GoogleAnalyticsService
{
    protected $propertyId;
    protected $credentials;
    protected $client;

    public function __construct()
    {
        $this->propertyId = config('google-analytics.property_id');
        $this->credentials = config('google-analytics.credentials_json');
        if ($this->propertyId && file_exists($this->credentials)) {
            $this->client = new BetaAnalyticsDataClient([
                'credentials' => $this->credentials,
            ]);
        } else {
            $this->client = null;
        }
    }

    public function isConfigured(): bool
    {
        return $this->propertyId && file_exists($this->credentials);
    }

    public function getTrafficSummary($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'sessions'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
        ]);
        return $response->getRows()[0]->getMetricValues()[0]->getValue() ?? null;
    }

    public function getTrafficSources($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'sessions'])];
        $dimensions = [new Dimension(['name' => 'sessionDefaultChannelGroup'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
            'dimensions' => $dimensions,
        ]);
        $sources = [];
        foreach ($response->getRows() as $row) {
            $sources[$row->getDimensionValues()[0]->getValue()] = $row->getMetricValues()[0]->getValue();
        }
        return $sources;
    }

    // Obtener CTR (Click Through Rate) de eventos 'click' e 'impression'
    public function getClickThroughRate($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'eventCount'])];
        $dimensions = [new Dimension(['name' => 'eventName'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
            'dimensions' => $dimensions,
        ]);
        $clicks = 0;
        $impressions = 0;
        foreach ($response->getRows() as $row) {
            $event = $row->getDimensionValues()[0]->getValue();
            $count = (int)$row->getMetricValues()[0]->getValue();
            if ($event === 'click') $clicks += $count;
            if ($event === 'impression') $impressions += $count;
        }
        if ($impressions > 0) {
            return round(($clicks / $impressions) * 100, 2);
        }
        return null;
    }

    // Velocidad de carga promedio de la página
    public function getAveragePageLoadTime($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'averagePageLoadTime'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
        ]);
        return $response->getRows()[0]->getMetricValues()[0]->getValue() ?? null;
    }

    // Tasa de rebote
    public function getBounceRate($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'bounceRate'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
        ]);
        return $response->getRows()[0]->getMetricValues()[0]->getValue() ?? null;
    }

    // Tiempo promedio en el sitio
    public function getAverageSessionDuration($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'averageSessionDuration'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
        ]);
        return $response->getRows()[0]->getMetricValues()[0]->getValue() ?? null;
    }

    // Dispositivos
    public function getDevices($days = 30)
    {
        if (!$this->client) return null;
        $dateRange = new DateRange([
            'start_date' => now()->subDays($days)->toDateString(),
            'end_date' => 'today',
        ]);
        $metrics = [new Metric(['name' => 'sessions'])];
        $dimensions = [new Dimension(['name' => 'deviceCategory'])];
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metrics,
            'dimensions' => $dimensions,
        ]);
        $devices = [];
        foreach ($response->getRows() as $row) {
            $devices[$row->getDimensionValues()[0]->getValue()] = $row->getMetricValues()[0]->getValue();
        }
        return $devices;
    }
}

