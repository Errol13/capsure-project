<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmationModal extends Component
{
    public $id;
    public $title;
    public $message;
    public $actionUrl;
    public $method;

    public function __construct($id, $title, $message, $actionUrl, $method = 'POST')
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->method = $method;
    }

    public function render()
    {
        return view('components.confirmation-modal');
    }
}