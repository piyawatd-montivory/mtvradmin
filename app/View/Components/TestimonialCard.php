<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TestimonialCard extends Component
{

    public $author;
    public $position;
    public $image;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($author, $position, $image, $description)
    {
        $this->author = $author;
        $this->position = $position;
        $this->image = $image;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.testimonial-card');
    }
}
