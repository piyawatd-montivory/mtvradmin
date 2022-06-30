<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CareerItem extends Component
{
    public $id;
    public $title;
    public $skill;
    public $description;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$title,$skill,$description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->skill = $skill;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.career-item');
    }
}
