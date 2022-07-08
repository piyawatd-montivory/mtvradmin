<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardPeople extends Component
{

    public $image;
    public $fullname;
    public $position;
    public $linkedinurl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image,$fullname,$position,$linkedinurl)
    {
        $this->image = $image;
        $this->fullname = $fullname;
        $this->position = $position;
        $this->linkedinurl = $linkedinurl;
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
