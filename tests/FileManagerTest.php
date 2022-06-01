<?php

namespace Sdkconsultoria\Core\Tests;

use PHPUnit\Framework\TestCase;
use Sdkconsultoria\Core\Service\FileManager;
use Faker\Factory;

class FileManagerTest extends TestCase
{
    public function test_create_file(): string
    {
        $faker = Factory::create();
        $file_path = __DIR__ . '/files/' . $faker->unique()->word();

        FileManager::create($file_path);

        $this->assertTrue(file_exists($file_path));

        return $file_path;
    }

    /**
     * @depends test_create_file
     */
    public function test_append_to_file(string $file_path): array
    {
        $faker = Factory::create();
        $word = $faker->unique()->name();

        FileManager::append($file_path, $word);

        $file_content = file_get_contents($file_path);

        $this->assertStringContainsString($word, $file_content);

        return [
            'word' => $word,
            'file_path' => $file_path,
        ];
    }

    /**
     * @depends test_append_to_file
     */
    public function test_replace_file(array $data): void
    {
        $faker = Factory::create();
        $new_word = $faker->unique()->name();

        FileManager::replace($data['word'], $new_word, $data['file_path']);

        $file_content = file_get_contents($data['file_path']);

        $this->assertStringNotContainsString($data['word'], $file_content);
        $this->assertStringContainsString($new_word, $file_content);
    }
}
