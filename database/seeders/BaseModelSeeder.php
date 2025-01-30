<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

abstract class BaseModelSeeder extends Seeder
{
    protected string $modelClass;
    protected array $records;

    public function run(): void
    {
        $this->command->info('[Started]: Seeding ' . class_basename($this->modelClass));

        $progressBar = $this->command->getOutput()->createProgressBar(count($this->records));

        foreach ($this->records as $attributes) {
            $this->processRecord($attributes);

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->newLine();
        $this->command->info('[Finished]: Seeding ' . class_basename($this->modelClass));
    }

    abstract protected function processRecord(array $attributes): void;
}
