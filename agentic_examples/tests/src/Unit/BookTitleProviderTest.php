<?php

declare(strict_types=1);

namespace Drupal\Tests\agentic_examples\Unit;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;
use Drupal\agentic_examples\Service\BookTitleProvider;

/**
 * Tests the accessible published book title query.
 *
 * @group agentic_examples
 */
final class BookTitleProviderTest extends UnitTestCase {

  public function testItReturnsTitlesFromTheAccessCheckedQuery(): void {
    $query = $this->createMock(QueryInterface::class);
    $query->expects($this->once())
      ->method('accessCheck')
      ->with(TRUE)
      ->willReturnSelf();
    $query->method('condition')->willReturnSelf();
    $query->method('sort')->with('title')->willReturnSelf();
    $query->method('execute')->willReturn([17]);

    $node = $this->createMock(NodeInterface::class);
    $node->method('label')->willReturn('A Drupal book');

    $storage = $this->createMock(EntityStorageInterface::class);
    $storage->method('getQuery')->willReturn($query);
    $storage->method('loadMultiple')->with([17])->willReturn([17 => $node]);

    $entityTypeManager = $this->createMock(EntityTypeManagerInterface::class);
    $entityTypeManager->method('getStorage')->with('node')->willReturn($storage);

    $provider = new BookTitleProvider($entityTypeManager);

    self::assertSame(['A Drupal book'], $provider->getPublishedBookTitles());
  }

}
