<?php

namespace App\Hydrator;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

/**
 * Entity hydrator manager.
 */
class HydratorManager implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $locator;

    /**
     * Construct.
     */
    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public static function getSubscribedServices(): array
    {
        return [
            SteamUser\SteamUserHydrator::class,
        ];
    }

    public function getHydrator(string $class): HydratorInterface
    {
        return $this->locator->get($class);
    }

    public function hydrate($input, $hydratorClass = null)
    {
        if (null === $input) {
            return null;
        }

        if (null !== $hydratorClass) {
            $hydrator = $this->getHydrator($hydratorClass);

            if (!$hydrator->supports($input)) {
                throw new \LogicException(sprintf('Your object %s can not be hydrated with %s', \gettype($input), \get_class($hydrator)));
            }

            return $hydrator->hydrate($input);
        }

        foreach ($this->getSubscribedServices() as $hydratorClass) {
            $hydrator = $this->getHydrator($hydratorClass);

            if ($hydrator->supports($input)) {
                return $hydrator->hydrate($input);
            }
        }

        throw new \LogicException(sprintf('Your object can not be hydrated. Add hydrator corresponding to type %s', \get_class($input)));
    }
}
