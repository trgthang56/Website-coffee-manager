<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use Illuminate\Support\Carbon;

class CheckExpiredVouchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vouchers:check-expired';

    protected $description = 'Check and update expired vouchers status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $expiredVouchers = Voucher::where('expiry_date', '<', Carbon::now())->Where('status','Chưa dùng')->get();

        foreach ($expiredVouchers as $voucher) {
            $voucher->update(['status' => 'Đã hết hạn']);
            $voucher->save();
        }

        $this->info('Expired vouchers checked and updated successfully.');
    }
}
