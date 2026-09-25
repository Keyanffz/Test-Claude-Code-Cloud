<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->extend(Tests\TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

function actingAsAdmin(): Tests\TestCase
{
    return test()->actingAs(User::factory()->create());
}
