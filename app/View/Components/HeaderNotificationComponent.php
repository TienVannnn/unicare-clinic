<?php

namespace App\View\Components;

use App\Models\Contact;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderNotificationComponent extends Component
{
    public $count;
    public $contacts;

    public function __construct()
    {
        $this->count = Contact::where('status', 0)->count();
        $this->contacts = Contact::orderByDesc('id')->get();
    }
    public function render(): View|Closure|string
    {
        return view('components.header-notification-component');
    }
}
