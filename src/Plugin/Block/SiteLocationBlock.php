<?php

declare(strict_types=1);

namespace Drupal\sitelocation\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\sitelocation\Services\SiteLocationService;

/**
 * Provides a 'Site Location' Block.
 *
 * @Block(
 *   id = "sitelocation_block",
 *   admin_label = @Translation("Site Location Block"),
 *   category = @Translation("Location"),
 * )
 */
class SiteLocationBlock extends BlockBase implements ContainerFactoryPluginInterface
{
    /**
     * SiteLocationBlock class constructor.
     * @param \Drupal\sitelocation\Services\SiteLocationService $sitelocation_service
     * Site location service.
     */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        SiteLocationService $sitelocation_service
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->sitelocation_service = $sitelocation_service;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     *
     * @return static
     */
    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('sitelocation.config')
        );
    }

    /**
    * {@inheritdoc}
    */
    public function build(): array
    {
        // Get configured site timezone.
        $site_datetime = $this->sitelocation_service->sitelocation();

        // Return formatted Datetime.
        $renderable = [
            '#theme' => 'sitelocation_block',
            '#site_datetime' => $site_datetime,
        ];

        return $renderable;
    }
}
