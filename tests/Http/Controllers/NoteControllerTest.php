<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Models\Note;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListNotesForCurrentUserByDefault(): void
    {
        $ownNote = factory(Note::class)->create([
            'user_id' => $this->admin->id,
        ]);

        $otherNote = factory(Note::class)->create([
            'user_id' => $this->editor->id,
        ]);

        $this->actingAs($this->admin, 'canvas')
             ->getJson('canvas/api/notes')
             ->assertSuccessful()
             ->assertJsonStructure([
                 'notes',
             ])
             ->assertJsonFragment([
                 'id' => $ownNote->id,
             ])
             ->assertJsonMissing([
                 'id' => $otherNote->id,
             ]);
    }

    public function testListAllNotesWhenScopeAll(): void
    {
        factory(Note::class, 2)->create([
            'user_id' => $this->admin->id,
        ]);

        factory(Note::class, 2)->create([
            'user_id' => $this->editor->id,
        ]);

        $this->actingAs($this->admin, 'canvas')
             ->getJson('canvas/api/notes?scope=all')
             ->assertSuccessful()
             ->assertJsonStructure([
                 'notes',
             ]);
    }

    public function testNewNoteData(): void
    {
        $this->actingAs($this->admin, 'canvas')
             ->getJson('canvas/api/notes/create')
             ->assertSuccessful()
             ->assertJsonStructure([
                 'note',
                 'tags',
                 'topics',
             ]);
    }

    public function testExistingNoteData(): void
    {
        $note = factory(Note::class)->create();

        $this->actingAs($this->admin, 'canvas')
             ->getJson("canvas/api/notes/{$note->id}")
             ->assertSuccessful()
             ->assertJsonStructure([
                 'note',
                 'tags',
                 'topics',
             ])
             ->assertJsonFragment([
                 'id' => $note->id,
             ]);
    }

    public function testCreateOrUpdateNote(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $data = [
            'body' => 'Sample note body',
        ];

        $this->actingAs($this->admin, 'canvas')
             ->postJson("canvas/api/notes/{$uuid}", $data)
             ->assertStatus(201)
             ->assertJsonFragment([
                 'id' => $uuid,
                 'body' => $data['body'],
             ]);

        $note = Note::findOrFail($uuid);

        $update = [
            'body' => 'Updated body',
        ];

        $this->actingAs($this->admin, 'canvas')
             ->postJson("canvas/api/notes/{$note->id}", $update)
             ->assertSuccessful()
             ->assertJsonFragment([
                 'id' => $note->id,
                 'body' => $update['body'],
             ]);
    }

    public function testSyncTagsAndTopic(): void
    {
        $note = factory(Note::class)->create([
            'user_id' => $this->admin->id,
        ]);

        $tag = factory(Tag::class)->create();
        $topic = factory(Topic::class)->create();

        $data = [
            'body' => $note->body,
            'tags' => [
                [ 'name' => $tag->name, 'slug' => $tag->slug ],
            ],
            'topic' => [
                [ 'name' => $topic->name, 'slug' => $topic->slug ],
            ],
        ];

        $this->actingAs($this->admin, 'canvas')
             ->postJson("canvas/api/notes/{$note->id}", $data)
             ->assertSuccessful();

        $this->assertCount(1, $note->tags);
        $this->assertCount(1, $note->topic);
    }

    public function testDeleteNotePermissions(): void
    {
        $note = factory(Note::class)->create([
            'user_id' => $this->editor->id,
        ]);

        $this->actingAs($this->contributor, 'canvas')
             ->deleteJson("canvas/api/notes/{$note->id}")
             ->assertNotFound();

        $this->actingAs($this->admin, 'canvas')
             ->deleteJson("canvas/api/notes/{$note->id}")
             ->assertSuccessful()
             ->assertNoContent();

        $this->assertSoftDeleted('canvas_notes', [
            'id' => $note->id,
        ]);
    }
}

