<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Http\Models\Client;
use App\Order;
use App\User;
use App\Http\Models\Vat;
use App\Http\Models\Cart;
use App\Http\Models\Wallet;
use App\Http\Models\Invoice;
use DB;
use DateTime;
use DateInterval;
use Auth;
use Carbon\Carbon;
use Mollie;
use Socialite;


class CreditNote extends Model
{
    //
    protected $table = 'credit_note';

}
