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

        $weatherData = [];
        $saltingNeeded = 0;

        // Get weather data for each road
        foreach ($roads as $road) {
            $weather = $this->getWeatherData($road->getLocation());
            $temp = (int) ($weather['temp'] ?? 0);
            $needsSalting = $this->checkIfSaltingNeeded($road, $temp);
            
            if ($needsSalting) {
                $saltingNeeded++;
            }

            $weatherData[] = [
                'road' => $road,
                'temp' => $temp,
                'description' => $weather['desc'] ?? 'N/A',
                'needsSalting' => $needsSalting
            ];
        }

        $avgTemp = count($weatherData) > 0 
            ? round(array_sum(array_column($weatherData, 'temp')) / count($weatherData)) 
            : 0;

        return $this->render("home/index", [
            "name" => $this->dt->format("d-m-Y"),
            "time" => $this->dt->format("H:i"),
            "weatherData" => $weatherData,
            "avgTemp" => $avgTemp,
            "saltingNeeded" => $saltingNeeded
        ]);
    }

    private function getWeatherData(string $location): array
    {
        try {
            $url = "https://weerlive.nl/api/weerlive_api_v2.php?key=demo&locatie=" . urlencode($location);
            $response = @file_get_contents($url);
            
            if ($response === false) {
                return ['temp' => 0, 'desc' => 'N/A'];
            }

            $data = json_decode($response, true);

            if (isset($data['liveweer'][0])) {
                return [
                    'temp' => $data['liveweer'][0]['temp'] ?? 0,
                    'desc' => $data['liveweer'][0]['omschrijving'] ?? 'N/A'
                ];
            }
        } catch (\Exception $e) {
            return ['temp' => 0, 'desc' => 'N/A'];
        }

        return ['temp' => 0, 'desc' => 'N/A'];
    }

    private function checkIfSaltingNeeded(Road $road, int $temp): bool
    {
        foreach ($road->getSaltingFrequencies() as $frequency) {
            if ($temp >= $frequency->getTempMin() && $temp <= $frequency->getTempMax()) {
                return true;
            }
        }
        return false;
    } 
}  