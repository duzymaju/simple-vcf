<?php

namespace SimpleVcf\Factory;

use SimpleVcf\Model\CardList;
use SimpleVcf\Model\CardListInterface;

class CardListFactory
{
    /** @var CardFactory */
    private $cardFactory;

    /** @var bool */
    private $omitInvalid;

    /**
     * Construct
     *v
     * @param CardFactory $cardFactory card factory
     * @param bool        $omitInvalid omit invalid
     */
    public function __construct(CardFactory $cardFactory, $omitInvalid)
    {
        $this->cardFactory = $cardFactory;
        $this->omitInvalid = $omitInvalid;
    }

    /**
     * Create
     *
     * @param array $content content
     *c
     * @return CardListInterface
     */
    public function create(array $content)
    {
        $cardList = new CardList();
        $lines = null;
        foreach ($content as $line) {
            $line = rtrim($line, "\r\n ");
            if ($line === 'BEGIN:VCARD') {
                $lines = [];
            } elseif (isset($lines)) {
                if ($line === 'END:VCARD') {
                    $card = $this->cardFactory->create($lines);
                    if (!$this->omitInvalid || $card->isValid()) {
                        $cardList->addCard($card);
                    }
                    $lines = null;
                } elseif (!empty($line)) {
                    $lines[] = $line;
                }
            }
        }

        return $cardList;
    }
}
