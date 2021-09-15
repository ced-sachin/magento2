<?php


namespace Magento\TestFramework\Fixture\Data;

use Magento\TestFramework\Fixture\DataFixtureInterface;

class UniqueIdProcessor implements ProcessorInterface
{
    private const PLACEHOLDER = '%uniqid%';

    /**
     * Fixture  starting increment number
     * @var int
     */
    private const INCREMENT = 1;

    /**
     * Fixture's name storage
     * @var array
     */
    static private array $storage = [];

    /**
     * @param DataFixtureInterface $fixture
     * @param array $data
     * @return array
     */
    public function process(DataFixtureInterface $fixture, array $data): array
    {
        $class = get_class($fixture);
        if (!isset(self::$storage[$class])) {
            self::$storage[$class] = ['prefix' => uniqid(), 'increment' => self::INCREMENT];
        }
        $hash = self::$storage[$class]['prefix'] . self::$storage[$class]['increment']++;
        array_walk_recursive($data, function (&$value) use ($hash) {
            $value = str_replace(self::PLACEHOLDER, $hash, $value);
        });
        return $data;
    }
}
