<?php

namespace SimpleVcf\Factory;

use SimpleVcf\Model\Card;
use SimpleVcf\Model\CardInterface;

class CardFactory
{
    /** @var FieldFactory */
    private $fieldFactory;

    /**
     * Construct
     *
     * @param FieldFactory $fieldFactory field factory
     */
    public function __construct(FieldFactory $fieldFactory)
    {
        $this->fieldFactory = $fieldFactory;
    }

    /**
     * Create
     *
     * @param array $lines lines
     *
     * @return CardInterface
     */
    public function create(array $lines)
    {
        $card = new Card();
        if (count($lines) === 0) {
            return $card;
        }

        $data = '';
        $iLast = count($lines) - 1;
        foreach ($lines as $i => $line) {
            $data .= strpos($line, ' ') === 0 ? substr($line, 1) : $line;
            if (!empty($data)) {
                $nextLine = $i === $iLast ? null : $lines[$i + 1];
                if (!isset($nextLine) || ($nextLine !== '' && strpos($nextLine, ' ') !== 0)) {
                    $card->addField($this->fieldFactory->create($data));
                    $data = '';
                }
            }
        }

        return $card;
    }
}
