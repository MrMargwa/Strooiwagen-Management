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
        $sneekWeather = $this->getWeatherData("Sneek");
        $lKop = ( $sneekWeather["lKop"] ?? "Geen nieuws vandaag.");
        $lText = ($sneekWeather["lText"] ?? "Geen beschrijving beschikbaar.");
        // $sneekTemp = -14;
        $sneekTemp = (int) ($sneekWeather['temp'] ?? 0);
        $sneekDesc = $sneekWeather['desc'] ?? 'N/A';
        $feelTemp = (int) ($sneekWeather['gtemp'] ?? 0);
        $wheatherSummary = $sneekWeather['samenv'] ?? 'N/A';

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
            "feelTemp" => $feelTemp,
            "wheatherSummary" => $wheatherSummary,
            "lKop" => $lKop,
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
            $url = "https://weerlive.nl/api/weerlive_api_v2.php?key=" . urlencode($apiKey) . "&locatie=" . urlencode($location);
            $response = @file_get_contents($url);
            
            if ($response === false) {
                return ['temp' => 0, 'desc' => 'N/A', 'lKop' => null, 'lText' => null];
            }

            $data = json_decode($response, true);

            if (isset($data['liveweer'][0])) {
                return [
                    'temp' => $data['liveweer'][0]['temp'] ?? 0,
                    'desc' => $data['liveweer'][0]['omschrijving'] ?? 'N/A',
                    'gtemp' => $data['liveweer'][0]['gtemp'] ?? 0,
                    'samenv' => $data['liveweer'][0]['samenv'] ?? 'N/A',
                    'lKop' => $data['liveweer'][0]['lkop'] ?? null,
                    'lText' => $data['liveweer'][0]['ltekst'] ?? null
                ];
            }
        } catch (\Exception $e) {
            return ['temp' => 0, 'desc' => 'N/A', 'lKop' => null, 'lText' => null];
        }

        return ['temp' => 0, 'desc' => 'N/A', 'lKop' => null, 'lText' => null];
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