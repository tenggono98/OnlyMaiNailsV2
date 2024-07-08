<?php
namespace App\Livewire\Admin;
use App\Models\SettingWeb;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

use function Laravel\Prompts\alert;

class Setting extends Component
{
    use LivewireAlert;
    #[Validate('required')]
    public $tax, $deposit, $emailPayment, $limitDepositTime;
    public function render()
    {
        $settingWeb = SettingWeb::all();
        $this->tax = $settingWeb->where('name', '=', 'Tax')->first()->value;
        $this->deposit = $settingWeb->where('name', '=', 'Deposit')->first()->value;
        $this->emailPayment = $settingWeb->where('name', '=', 'PaymentEmail')->first()->value;
        $this->limitDepositTime = $settingWeb->where('name', '=', 'LimitDepositPayment_h')->first()->value;
        return view('livewire.admin.setting', compact('settingWeb'))->layout('components.layouts.app-admin');
    }
    public function save()
    {
        $settings = [
            'Tax' => $this->tax,
            'Deposit' => $this->deposit,
            'PaymentEmail' => $this->emailPayment,
            'LimitDepositPayment_h' => $this->limitDepositTime
        ];
        foreach ($settings as $name => $value) {
            $setting = SettingWeb::where('name', $name)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            }
        }

        $this->alert('success','Setting has been updated!');
    }
}
