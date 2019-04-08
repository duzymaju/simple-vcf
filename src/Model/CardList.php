<?php

namespace SimpleVcf\Model;

use SimpleVcf\Exception\DuplicateException;

class CardList implements CardListInterface
{
    /** @var CardInterface[] */
    private $cards = [];

    /** @var CardInterface[]|null */
    private $cardsCopy = null;

    /**
     * Get cards
     *
     * @return CardInterface[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Set cards
     *
     * @param CardInterface[] $cards cards
     *
     * @return self
     */
    public function setCards(array $cards)
    {
        $this->cards = $cards;

        return $this;
    }

    /**
     * Add card
     *
     * @param CardInterface $card card
     *
     * @return self
     */
    public function addCard(CardInterface $card)
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * Check unique names
     *
     * @throws DuplicateException
     */
    public function checkUniqueNames()
    {
        $names = [];
        foreach ($this->cards as $card) {
            $names[] = $card->getName();
        }
        if (count($names) != count(array_unique($names))) {
            throw new DuplicateException(sprintf('Card aren\'t unique.'));
        }
    }

    /**
     * Find by name
     *
     * @return CardInterface|null
     */
    public function findByName($name)
    {
        if (!$this->cardsCopy) {
            $this->cardsCopy = $this->cards;
        }
        foreach ($this->cardsCopy as $i => $card) {
            if ($card->getName() == $name) {
                array_splice($this->cardsCopy, $i, 1);
                return $card;
            }
        }
    }

    /**
     * Get whole rest
     *
     * @return CardInterface[]|null
     */
    public function getWholeRest() {
        $cardsCopy = $this->cardsCopy;
        $this->cardsCopy = null;
        return $cardsCopy;
    }

    /**
     * Update from
     *
     * @param CardListInterface $otherList other list
     */
    public function updateFrom(CardListInterface $otherList)
    {
        foreach ($this->cards as $i => $card) {
            $newCard = $otherList->findByName($card->getName());
            if ($newCard) {
                $this->cards[$i] = $newCard;
            } else {
                $this->cards[$i] = null;
            }
        }
        $this->cards = array_filter($this->cards, function ($card) {
            return isset($card);
        });
        foreach ($otherList->getWholeRest() as $card) {
            $this->cards[] = $card;
        }
    }

    /**
     * To string
     *
     * @return string
     */
    public function toString()
    {
        return implode(PHP_EOL, array_map(function (CardInterface $card) {
            return $card->toString();
        }, $this->cards));
    }
}
