<?php

namespace SimpleVcf\Storage;

use SimpleVcf\Exception\InvalidResourceException;
use SimpleVcf\Factory\CardListFactory;
use SimpleVcf\Model\CardListInterface;

class FileStorage
{
    /** @var CardListFactory */
    private $cardListFactory;

    /** @var string */
    private $filePath;

    /**
     * Construct
     *
     * @param CardListFactory $cardListFactory card list factory
     * @param string          $filePath        file path
     *
     * @throws InvalidResourceException
     */
    public function __construct(CardListFactory $cardListFactory, $filePath)
    {
        if (empty($filePath)) {
            throw new InvalidResourceException('File path is not defined.');
        }

        $this->cardListFactory = $cardListFactory;
        $this->filePath = $filePath;
    }

    /**
     * Load
     *
     * @return CardListInterface
     *
     * @throws InvalidResourceException
     */
    public function load()
    {
        if (!file_exists($this->filePath)) {
            throw new InvalidResourceException(sprintf('File %s doesn\'t exist.', $this->filePath));
        }

        $content = file($this->filePath);
        if ($content === false) {
            throw new InvalidResourceException(sprintf('Content from file %s isn\'t readable.', $this->filePath));
        }
        $cardList = $this->cardListFactory->create($content);

        return $cardList;
    }

    /**
     * Save
     *
     * @param CardListInterface $cardList card list
     *
     * @return self
     *
     * @throws InvalidResourceException
     */
    public function save(CardListInterface $cardList)
    {
        if (!file_put_contents($this->filePath, $cardList->toString())) {
            throw new InvalidResourceException(
                sprintf('An error occurred during writing to file %s.', $this->filePath)
            );
        }

        return $this;
    }
}
