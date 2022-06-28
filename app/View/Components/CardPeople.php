<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardPeople extends Component
{

    public $image;
    public $fullname;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image,$fullname)
    {
        $this->image = $image;
        $this->fullname = $fullname;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-people');
    }
}
