<?php

declare(strict_types=1);

namespace Drupal\agentic_examples\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Lists titles from published book nodes the current account may view.
 */
final class BookTitleProvider {

  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Returns accessible published book titles in alphabetical order.
   *
   * @return string[]
   *   The accessible book titles.
   */
  public function getPublishedBookTitles(): array {
    $storage = $this->entityTypeManager->getStorage('node');
    $ids = $storage->getQuery()
      ->accessCheck(TRUE)
      ->condition('type', 'mindcore_book')
      ->condition('status', NodeInterface::PUBLISHED)
      ->sort('title')
      ->execute();

    $nodes = $storage->loadMultiple($ids);
    return array_map(static fn(NodeInterface $node): string => $node->label(), $nodes);
  }

}
