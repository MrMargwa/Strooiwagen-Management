<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entities\Road;
use App\Entities\RoadSaltingFrequency;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RoadController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function index(): ResponseInterface
    {
        $repo = $this->em->getRepository(Road::class);
        $roads = $repo->findAll();

        return $this->render("wegen/index", [
            "roads" => $roads
        ]);
    }

    public function show(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $road = $this->em->find(Road::class, $args["id"]);

        return $this->render("wegen/show", [
            "road" => $road
        ]);
    }

    public function create(ServerRequestInterface $request): ResponseInterface 
    {
        if ($request->getMethod() === "POST") {
            $parameters = $request->getParsedBody();

            try {
                $road = new Road();
                $road->setName($parameters["name"]);
                $road->setLocation($parameters["location"]);
                $road->setSaltingTime($parameters["saltingTime"]);

                // Add salting frequencies
                $frequencies = [
                    ['min' => -5, 'max' => 0, 'value' => $parameters['frequency_0'] ?? null],
                    ['min' => -10, 'max' => -5, 'value' => $parameters['frequency_5'] ?? null],
                    ['min' => -15, 'max' => -10, 'value' => $parameters['frequency_10'] ?? null],
                ];

                foreach ($frequencies as $freq) {
                    if ($freq['value'] !== null && $freq['value'] !== '') {
                        $saltingFrequency = new RoadSaltingFrequency();
                        $saltingFrequency->setTempMin($freq['min']);
                        $saltingFrequency->setTempMax($freq['max']);
                        $saltingFrequency->setSaltingFrequency((int)$freq['value']);
                        $saltingFrequency->setRoad($road);
                        $this->em->persist($saltingFrequency);
                    }
                }

                $this->em->persist($road);
                $this->em->flush();

                header('Location: /wegen/' . $road->getId() . '?toast=road-created&type=success');
                exit;
            } catch (\Throwable $e) {
                header('Location: /wegen/create?toast=road-create-failed&type=error');
                exit;
            }
        }
        
        return $this->render("wegen/create");
    }

    public function edit(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $road = $this->em->find(Road::class, $args["id"]);

        if (!$road) {
            header('Location: /wegen?toast=road-not-found&type=error');
            exit;
        }

        if ($request->getMethod() === "POST") {
            $parameters = $request->getParsedBody();

            try {
                $road->setName($parameters["name"]);
                $road->setLocation($parameters["location"]);
                $road->setSaltingTime($parameters["saltingTime"]);

                // Remove old salting frequencies
                foreach ($road->getSaltingFrequencies() as $freq) {
                    $road->removeSaltingFrequency($freq);
                    $this->em->remove($freq);
                }

                // Add new salting frequencies
                $frequencies = [
                    ['min' => -5, 'max' => 0, 'value' => $parameters['frequency_0'] ?? null],
                    ['min' => -10, 'max' => -5, 'value' => $parameters['frequency_5'] ?? null],
                    ['min' => -15, 'max' => -10, 'value' => $parameters['frequency_10'] ?? null],
                ];

                foreach ($frequencies as $freq) {
                    if ($freq['value'] !== null && $freq['value'] !== '') {
                        $saltingFrequency = new RoadSaltingFrequency();
                        $saltingFrequency->setTempMin($freq['min']);
                        $saltingFrequency->setTempMax($freq['max']);
                        $saltingFrequency->setSaltingFrequency((int)$freq['value']);
                        $road->addSaltingFrequency($saltingFrequency);
                        $this->em->persist($saltingFrequency);
                    }
                }

                $this->em->persist($road);
                $this->em->flush();

                header('Location: /wegen/' . $road->getId() . '?toast=road-updated&type=success');
                exit;
            } catch (\Throwable $e) {
                header('Location: /wegen/' . $road->getId() . '/edit?toast=road-update-failed&type=error');
                exit;
            }
        }
        
        return $this->render("wegen/edit", [
            "road" => $road
        ]);
    }

    public function delete(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $road = $this->em->find(Road::class, $args["id"]);

        if (!$road) {
            header('Location: /wegen?toast=road-not-found&type=error');
            exit;
        }

        try {
            // Remove all salting frequencies first
            foreach ($road->getSaltingFrequencies() as $freq) {
                $this->em->remove($freq);
            }

            // Remove the road
            $this->em->remove($road);
            $this->em->flush();
        } catch (\Throwable $e) {
            header('Location: /wegen?toast=road-delete-failed&type=error');
            exit;
        }

        header('Location: /wegen?toast=road-deleted&type=success');
        exit;
    }
}