<?php

use Illuminate\Support\Facades\Broadcast;

// Channel untuk notifikasi real-time Asisten Lab
Broadcast::channel('lab-assistants', function ($user) {
    return $user->hasRole(['asisten_lab', 'plp', 'koordinator']);
});

// Channel pribadi per-user
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
