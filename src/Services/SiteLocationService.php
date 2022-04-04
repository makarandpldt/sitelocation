<?php

declare(strict_types=1);

namespace Drupal\sitelocation\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Site Location service class.
 */
class SiteLocationService
{
    private $config_factory;

    /**
     * SiteLocationService class constructor.
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     * The config factory.
     */
    public function __construct(ConfigFactoryInterface $config_factory)
    {
        $this->config_factory = $config_factory;
    }

    /**
     * Gives current site date and time.
     */
    public function sitelocation(): string
    {
        $date_time = new DrupalDateTime();
        $site_location_timezone = $this->config_factory->get('sitelocation.settings');
        $now = $date_time->getTimestamp();
        $site_current_datetime = $date_time->createFromTimestamp(
            $now,
            $site_location_timezone->get('sitelocation_timezone')
        );

        return $site_current_datetime->format('jS M Y - H:iA');
    }
}
