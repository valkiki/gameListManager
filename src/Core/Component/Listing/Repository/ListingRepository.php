<?php

declare(strict_types=1);

namespace App\Core\Component\Listing\Repository;

use App\Core\Component\Listing\Entity\Listing;
use App\Core\Port\Persistence\PersistenceServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ListingRepository
 * @package App\Core\Component\Listing\Repository
 */
final class ListingRepository implements ListingRepositoryInterface
{
    private $entityRepository;
    /**
     * @var PersistenceServiceInterface
     */
    private $persistenceService;

    /**
     * ListingRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param PersistenceServiceInterface $persistenceService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PersistenceServiceInterface $persistenceService
    ) {
        $this->entityRepository = $entityManager->getRepository(Listing::class);
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
     * @return Listing
     */
    public function find(int $id): ?Listing
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @param Listing $listing
     */
    public function create(Listing $listing): void
    {
        $this->persistenceService->upsert($listing);
    }

    /**
     * @param Listing $listing
     */
    public function update(Listing $listing): void
    {
        $this->persistenceService->upsert($listing);
    }

    /**
     * @param Listing $listing
     */
    public function delete(Listing $listing): void
    {
        $this->persistenceService->delete($listing);
    }
}
