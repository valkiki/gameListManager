<?php

declare(strict_types=1);

namespace App\Core\Port\Notification\Client\Flashbag;

use App\Core\Port\Notification\NotificationInterface;

/**
 * Class FlashbagNotification
 * @package App\Core\Port\Notification\Client\Flashbag
 */
class FlashbagNotification implements NotificationInterface
{
    public const ALERT_SUCCESS = "success";
    public const ALERT_ERROR = "danger";

    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $content;

    /**
     * FlashbagNotification constructor.
     * @param string $type
     * @param string $content
     */
    public function __construct(
        string $type,
        string $content
    ) {
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
