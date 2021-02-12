<?php

namespace SimpleVcf\Model;

use SimpleVcf\Exception\DuplicateException;
use SimpleVcf\Tool\ToStringInterface;

interface CardListInterface extends ToStringInterface
{
    /**
     * Get cards
     *
     * @return CardInterface[]
     */
    public function getCards();

    /**
     * Set cards
     *
     * @param CardInterface[] $cards cards
     *
     * @return self
     */
    public function setCards(array $cards);

    /**
     * Add card
     *
     * @param CardInterface $card card
     *
     * @return self
     */
    public function addCard(CardInterface $card);

    /**
     * Check unique names
     *
     * @throws DuplicateException
     */
    public function checkUniqueNames();

    /**
     * Find by name
     *
     * @param string $name name
     *
     * @return CardInterface|null
     */
    public function findByName($name);

    /**
     * Get whole rest
     *
     * @return CardInterface[]|null
     */
    public function getWholeRest();

    /**
     * Update from
     *
     * @param CardListInterface $otherList other list
     */
    public function updateFrom(CardListInterface $otherList);
}
