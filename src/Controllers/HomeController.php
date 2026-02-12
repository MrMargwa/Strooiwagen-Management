<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Framework\Controller\AbstractController;
use App\Entities\Road;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    public function __construct(private \DateTime $dt, private EntityManagerInterface $em)
    {
    }

    public function index(): ResponseInterface
    {
        $repo = $this->em->getRepository(Road::class);
        $roads = $repo->findAll();

        // Get weather data for Sneek (default location)
        $sneekWeather = $this->getWeatherData($_ENV["PLAATS"]);

        $verw = $sneekWeather["verw"];
        $lText = $sneekWeather["lText"];
        $sneekTemp = (int) ($sneekWeather['temp']);
        $sneekDesc = $sneekWeather['desc'];
        $sight = (int) $sneekWeather['sight'];
        $wheatherSummary = $sneekWeather['samenv'];

        $roadsNeedingSalting = [];
        $totalSaltingTime = 0;

        // Check which roads need salting based on Sneek temperature
        foreach ($roads as $road) {
            $saltingFrequency = $this->getSaltingFrequencyForTemp($road, $sneekTemp);

            if ($saltingFrequency > 0) {
                $roadsNeedingSalting[] = $road;
                $saltingTime = (int) $road->getSaltingTime();
                $totalSaltingTime += $saltingTime * $saltingFrequency;
            }
        }

        // Calculate number of wagons needed (1 wagon = 480 minutes per day = 8 hours)
        $saltingWagonsNeeded = $totalSaltingTime > 0 ? ceil($totalSaltingTime / 480) : 0;

        return $this->render("home/index", [
            "name" => $this->dt->format("d-m-Y"),
            "time" => $this->dt->format("H:i"),
            "sneekTemp" => $sneekTemp,
            "sneekDescription" => $sneekDesc,
            "sight" => $sight,
            "wheatherSummary" => $wheatherSummary,
            "verw" => $verw,
            "lText" => $lText,
            "roads" => $roads,
            "roadsNeedingSalting" => $roadsNeedingSalting,
            "totalRoads" => count($roads),
            "saltingWagonsNeeded" => $saltingWagonsNeeded,
            "totalSaltingTime" => $totalSaltingTime
        ]);
    }

    private function getWeatherData(string $location): array
    {
        try {
            $apiKey = $_ENV["WEERLIVE_API_KEY"] ?? "demo";
            $url = $_ENV["WEERLIVE_API_URL"] . urlencode($apiKey) . "&locatie=" . urlencode($location);
            $response = @file_get_contents($url);

            if ($response === false) {
                return ['temp' => 0, 'desc' => 'N/A', 'verw' => 'Geen data beschikbaar...', 'lText' => null, 'sight' => 0];
            }

            $data = json_decode($response, true);

            if (isset($data['liveweer'][0])) {
                return [
                    'temp' => $data['liveweer'][0]['temp'] ?? 0,
                    'desc' => $data['liveweer'][0]['omschrijving'] ?? 'N/A',
                    'sight' => $data['liveweer'][0]['zicht'] ?? 0,
                    'samenv' => $data['liveweer'][0]['samenv'] ?? 'N/A',
                    'verw' => $data['liveweer'][0]['verw'] ?? null,
                    'lText' => $data['liveweer'][0]['ltekst'] ?? null
                ];
            }
        } catch (\Exception $e) {
            return ['temp' => 0, 'desc' => 'N/A', 'verw' => null, 'lText' => null, 'sight' => 0];
        }

        return ['temp' => 0, 'desc' => 'N/A', 'verw' => null, 'lText' => null, 'sight' => 0];
    }

    private function getSaltingFrequencyForTemp(Road $road, int $temp): int
    {
        foreach ($road->getSaltingFrequencies() as $frequency) {
            if ($temp >= $frequency->getTempMin() && $temp <= $frequency->getTempMax()) {
                return $frequency->getSaltingFrequency();
            }
        }
        return 0;
    } 
}  