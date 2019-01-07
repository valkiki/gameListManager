<?php

declare(strict_types=1);

namespace App\Core\Component\Item\Repository;

use App\Core\Component\Item\Entity\Item;
use App\Core\Port\Persistence\PersistenceServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ItemRepository
 * @package App\Core\Component\Item\Repository
 */
class ItemRepository implements ItemRepositoryInterface
{
    private $entityRepository;
    /**
     * @var PersistenceServiceInterface
     */
    private $persistenceService;

    public function __construct(
        EntityManagerInterface $entityManager,
        PersistenceServiceInterface $persistenceService
    ) {
        $this->entityRepository = $entityManager->getRepository(Item::class);
        $this->persistenceService = $persistenceService;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->entityRepository->findAll();
    }

    /**
     * @param int $id
     * @return Item
     */
    public function find(int $id): Item
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @param Item $item
     */
    public function create(Item $item): void
    {
        $this->persistenceService->upsert($item);
    }

    /**
     * @param Item $item
     */
    public function delete(Item $item): void
    {
        $this->persistenceService->delete($item);
    }
}
