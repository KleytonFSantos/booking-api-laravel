<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->room = Room::factory()->create();
    $this->actingAs($this->user, 'sanctum');
    Storage::fake('local');
});

test('it creates a booking successfully', function () {
    $bookingData = [
        'room' => $this->room->id,
        'start_date' => now()->addDay()->format('d-m-Y H:i:s'),
        'end_date' => now()->addDays(2)->format('d-m-Y H:i:s'),
        'document' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf')
    ];

    $response = $this->postJson('/api/booking', $bookingData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'start_date',
                'end_date',
                'document',
                'price',
                'status',
                'room' => [
                  'id',
                  'vacancy',
                  'price',
                  'created_at',
                  'updated_at'
                ],
                'user' => [
                    'id',
                    'name',
                    'email',
                    'roles',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
});

test('it validates required fields', function () {
    $response = $this->postJson('/api/booking', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['start_date', 'end_date', 'room']);
});

test('it validates date format', function () {
    $response = $this->postJson('/api/booking', [
        'start_date' => 'invalid-date',
        'end_date' => 'invalid-date',
        'room' => $this->room->id
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['start_date', 'end_date']);
});

test('it validates end date after start date', function () {
    $response = $this->postJson('/api/booking', [
        'start_date' => now()->addDays(2)->format('d-m-Y H:i:s'),
        'end_date' => now()->addDay(1)->format('d-m-Y H:i:s'),
        'room' => $this->room->id
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['end_date']);
});

test('it prevents double booking', function () {
    $existingBooking = [
        'start_date' => now()->addDay()->format('d-m-Y H:i:s'),
        'end_date' => now()->addDays(2)->format('d-m-Y H:i:s'),
        'room' => $this->room->id
    ];

    $this->postJson('/api/booking', $existingBooking);
    $response = $this->postJson('/api/booking', $existingBooking);
    $response->assertStatus(400);
});

test('it prevents past dates', function () {
    $response = $this->postJson('/api/booking', [
        'start_date' => now()->subDay()->format('d-m-Y H:i:s'),
        'end_date' => now()->subDay()->format('d-m-Y H:i:s'),
        'room' => $this->room->id
    ]);

    $response->assertStatus(422);
});
