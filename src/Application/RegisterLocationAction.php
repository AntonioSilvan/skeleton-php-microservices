<?php
declare(strict_types = 1);
namespace Src\Aplication;

use Src\Domain\Location;
use Src\Domain\LocationRepositoryInterface;

final class RegisterLocation {
    private LocationRepositoryInterface $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository) {
        $this->locationRepository = $locationRepository;
    }

    public function __invoke(string $deviceUuid, string $lat, string $lon) {
        $this->validate($deviceUuid, $lat, $lon);

        $location = new Location($deviceUuid, $lat, $lon);
        $this->locationRepository->save($location);
    }

    private function validate(string $deviceUuid, string $lat, string $lon) {
        if(empty($deviceUuid)){
            throw new MissingDeviceUuidException();
        }
        if(empty($lat)){
            throw new MissingLatException();
        }
        if(empty($deviceUuid)){
            throw new MissingLonException();
        }
    }
}