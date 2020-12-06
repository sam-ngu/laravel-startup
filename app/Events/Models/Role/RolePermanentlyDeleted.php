<?php

namespace App\Events\Models\Role;

use App\Models\Role;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RolePermanentlyDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $role;

    /**
     * Create a new event instance.
     * @param Role $model
     * @return void
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
