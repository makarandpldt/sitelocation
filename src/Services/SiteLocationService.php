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
    public function sitelocation()
    {
        $site_location_timezone = $this->config_factory->get('sitelocation_timezone');
        $site_current_datetime = new DrupalDateTime('jS M Y H:i', $site_location_timezone);
        return $site_current_datetime;
    }
}
