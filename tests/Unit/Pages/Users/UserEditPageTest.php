<?php

namespace Tests\Unit\Pages\Users;

use Tests\TestCase;
use Tests\CreatesUser;
use Illuminate\Http\Response;
use Tests\InteractsWithDatabase;
use Canvas\Helpers\CanvasHelper;

class UserEditPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /**
     * Get the successful create message for a user.
     *
     * @return string
     */
    protected function getCreateMessage()
    {
        return trans('canvas::messages.update_success', ['entity' => 'user']);
    }

    /**
     * Get the successful update message for a user.
     *
     * @return string
     */
    protected function getUpdateMessage($entity)
    {
        return trans('canvas::messages.update_success', ['entity' => $entity]);
    }

    /**
     * Get the successful delete message for a user.
     *
     * @return string
     */
    protected function getDeleteMessage()
    {
        return trans('canvas::messages.delete_success', ['entity' => 'user']);
    }

    /** @test */
    public function it_can_edit_a_users_details()
    {
        // Actions
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin.user.edit', 2))
            ->type('New Name', 'first_name')
            ->press('Save')

            // Assertions
            ->seePageIs(route('canvas.admin.user.edit', 2))
            ->see(self::getUpdateMessage('User'))
            ->seeInDatabase(CanvasHelper::TABLES['users'], ['first_name' => 'New Name']);
            $this->assertResponseStatus(Response::HTTP_OK);
    }

    /** @test */
    public function it_can_delete_a_user_from_the_database()
    {
        // Actions
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin.user.edit', 3))
            ->press('Delete')

            // Assertions
            ->press('Delete User')
            ->see(self::getDeleteMessage())
            ->dontSeeInDatabase(CanvasHelper::TABLES['users'], ['first_name' => 'first']);
            $this->assertResponseStatus(Response::HTTP_OK);
    }

    /** @test */
    public function it_validates_the_user_password_update_form()
    {
        // Actions
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin.user.privacy', 2))
            ->type('secretpassword', 'new_password')
            ->press('Save')

            // Assertions
            ->seePageIs(route('canvas.admin.user.privacy', 2));
            $this->assertResponseStatus(Response::HTTP_OK);
    }

    /** @test */
    public function it_can_update_a_users_password()
    {
        // Actions
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin.user.privacy', 2))
            ->type('secretpassword', 'new_password')
            ->type('secretpassword', 'new_password_confirmation')
            ->press('Save')

            // Assertions
            ->seePageIs(route('canvas.admin.user.edit', 2))
            ->see(self::getUpdateMessage('password'));
            $this->assertResponseStatus(Response::HTTP_OK);
    }

    // protected function it_can_create_a_user_and_save_it_to_the_database()
    // {
    //     // Actions
    //     $this->createUser()->actingAs($this->user)
    //         ->visit(route('canvas.admin.user.create'))
    //         ->type('first', 'first_name')
    //         ->type('last', 'last_name')
    //         ->type('display', 'display_name')
    //         ->type('email@example.com', 'email')
    //         ->type('password', 'password')
    //         ->select(1, 'role')
    //         ->press('Save');

    //     // Assertions
    //     $this->assertResponseStatus(Response::HTTP_OK);
    //     $this->seeInDatabase(CanvasHelper::TABLES['users'], [
    //         'id'            => 4,
    //         'first_name'    => 'first',
    //         'last_name'     => 'last',
    //         'display_name'  => 'display',
    //         'role'          => 1,
    //         'email'         => 'email@example.com',
    //     ]);
    //     $this->seePageIs(route('canvas.admin.user.index'));
    //     $this->see(self::getCreateMessage());
    //     $this->assertSessionMissing('errors');
    // }
}
