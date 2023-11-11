<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AgremiadoCreated
{
    public $agremiado;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
   public function __construct(Agremiado $agremiado)
    {
        $this->agremiado = $agremiado;
    }

    public function handle()
    {
        // Crea un nuevo usuario utilizando la NUE del agremiado
        User::create([
            'NUE' => $this->agremiado->NUE,
            'password' => bcrypt($this->agremiado->NUE), // Puedes encriptar la contraseña aquí
            'id_rol' => 1, // Reemplaza esto con el ID del rol apropiado
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
