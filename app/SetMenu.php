<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetMenu extends Model {

    protected $table = 'set_menus';
    protected $casts = [
        'menu_date_select' => 'json',
    ];

    public function Hotels() {
        return $this->belongsTo(Hotels::class, 'hotes_id');
    }

    public function Restaurants() {
        return $this->belongsTo(Restaurants::class, 'restaurant_id');
    }

    /* public function Days() {
      return $this->belongsTo(Days::class, 'menu_date_select');
      } */

    /* public function TimeLunch() {
      return $this->belongsTo(TimeLunch::class, 'menu_time_lunch_start');
      }

      public function Time_Lunch_End() {
      return $this->belongsTo(TimeLunch::class, 'menu_time_lunch_end');
      }

      public function TimeDinner() {
      return $this->belongsTo(TimeDinner::class, 'menu_time_dinner_start');
      }

      public function Time_Dinner_End() {
      return $this->belongsTo(TimeDinner::class, 'menu_time_dinner_end');
      } */
}
