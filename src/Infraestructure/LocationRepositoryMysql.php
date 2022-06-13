<?php

declare(strict_types = 1);
namespace Src\Infraestructure;

use Src\Domain\Location;

final class LocationRepositoryMysql implements \Src\Domain\LocationRepositoryInterface {
    
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function save(Location $location): void {
        $statement = $this->pdo->prepare('INSERT INTO locations (deviceUuid, lat, lon) VALUES (:device_uuid, :lat, :lon)');
        $statement->execute([
            'device_uuid' => $location->getDeviceUuid(),
            'lat' => $location->getLat(),
            'lon' => $location->getLon()
        ]);
    }
}
