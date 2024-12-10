<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('OrderChannel', function () {
  return true;
});
Broadcast::channel('updateDetails', function () {
  return true;
});
Broadcast::channel('finishDetails', function(){
  return true;
});
Broadcast::channel('deleteDetails', function(){
  return true;
});
Broadcast::channel('deleteAllDetails', function(){
  return true;
});
Broadcast::channel('cancleOrders', function(){
  return true;
});
Broadcast::channel('finishAllDetails', function(){
  return true;
});
Broadcast::channel('payChannel', function(){
  return true;
});
Broadcast::channel('CusOrderChannel', function(){
  return true;
});
Broadcast::channel('confirmAllDetails', function(){
  return true;
});
Broadcast::channel('CusCallChannel', function(){
  return true;
});
Broadcast::channel('CheckinChannel', function(){
  return true;
});
Broadcast::channel('CheckoutChannel', function(){
  return true;
});