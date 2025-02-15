<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    private array $attributes;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'email_verified_at' => Carbon::parse('2025-01-02 15:05:35'),
            'password' => Hash::make('password'),
            'remember_token' => 'FqBbJbJDOS',
            'is_admin' => false,
            'created_at' => Carbon::parse('2025-01-02 14:05:35'),
            'updated_at' => Carbon::parse('2025-01-02 16:05:35'),
        ];

        $this->user = User::factory()->create($this->attributes);
    }

    public function test_user_attributes(): void
    {
        $this->assertSame($this->attributes['name'], $this->user->name);
        $this->assertSame($this->attributes['email'], $this->user->email);
        $this->assertTrue($this->attributes['email_verified_at']->equalTo($this->user->email_verified_at));
        $this->assertSame($this->attributes['password'], $this->user->password);
        $this->assertSame($this->attributes['remember_token'], $this->user->remember_token);
        $this->assertSame($this->attributes['is_admin'], $this->user->is_admin);
        $this->assertTrue($this->attributes['created_at']->equalTo($this->user->created_at));
        $this->assertTrue($this->attributes['updated_at']->equalTo($this->user->updated_at));
    }

    public function test_user_casts(): void
    {
        $this->assertTrue($this->user->email_verified_at instanceof Carbon);
        $this->assertTrue(Hash::isHashed($this->user->password));
        $this->assertTrue(getType($this->user->is_admin) === 'boolean');
        $this->assertTrue($this->user->created_at instanceof Carbon);
        $this->assertTrue($this->user->updated_at instanceof Carbon);
    }

    public function test_user_traits(): void
    {
        $this->assertTrue(in_array(HasFactory::class, class_uses($this->user)));
        $this->assertTrue(in_array(Notifiable::class, class_uses($this->user)));
    }

    public function test_user_interfaces(): void
    {
        $this->assertTrue(in_array(MustVerifyEmail::class, class_implements($this->user)));
    }

    public function test_user_parent_classes(): void
    {
        $this->assertTrue($this->user instanceof \Illuminate\Foundation\Auth\User);
    }

    public function test_user_admin_scope(): void
    {
        $adminUser = User::factory()->admin()->create();
        $regularUser = User::factory()->create();

        $foundAdminUser = User::admin()->find($adminUser->id);
        $foundRegularUser = User::admin(false)->find($regularUser->id);

        $this->assertTrue($adminUser->is_admin);
        $this->assertSame($adminUser->id, $foundAdminUser->id);

        $this->assertFalse($regularUser->is_admin);
        $this->assertSame($regularUser->id, $foundRegularUser->id);
    }

    public function test_user_posts_relation(): void
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->assertTrue($this->user->posts() instanceof HasMany);
        $this->assertCount(1, $this->user->posts()->get());
        $this->assertSame($post->id, $this->user->posts()->first()->id);
    }
}
