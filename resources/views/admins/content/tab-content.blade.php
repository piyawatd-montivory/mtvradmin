<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12 col-md-2 mb-2">
            <!-- Simple List -->
            <ul id="componentlist" class="list-group">
                <li class="list-group-item" dataid="content">
                    <div class="row">
                        <div class="col-8 ps-1 pe-0">Content</div>
                        <div class="col-4 text-end px-0">
                            <button class="btn btn-sm move-class px-0" type="button">
                            <i class="fa-solid fa-arrows-up-down-left-right"></i>
                            </button>
                            <button class="btn btn-sm add-component-class px-0 mx-2" type="button">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                        </div>
                    </div>
                </li>
                {{-- <li class="list-group-item" dataid="bullet">Bullet</li>
                <li class="list-group-item" dataid="image-left">Image Left</li>
                <li class="list-group-item" dataid="image-right">Image Right</li>
                <li class="list-group-item" dataid="double-image">Double Image</li> --}}
                <li class="list-group-item" dataid="single-image">
                    <div class="row">
                        <div class="col-8 ps-1 pe-0">Single Image</div>
                        <div class="col-4 text-end px-0">
                            <button class="btn btn-sm move-class px-0" type="button">
                            <i class="fa-solid fa-arrows-up-down-left-right"></i>
                            </button>
                            <button class="btn btn-sm add-component-class px-0 mx-2" type="button">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                        </div>
                    </div>
                </li>
                {{-- <li class="list-group-item" dataid="ad">Ad</li>
                <li class="list-group-item" dataid="social">Social</li> --}}
                <li class="list-group-item" dataid="blockquote">
                    <div class="row">
                        <div class="col-8 ps-1 pe-0">Blockquotes</div>
                        <div class="col-4 text-end px-0">
                            <button class="btn btn-sm move-class px-0" type="button">
                            <i class="fa-solid fa-arrows-up-down-left-right"></i>
                            </button>
                            <button class="btn btn-sm add-component-class px-0 mx-2" type="button">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-12 col-md-10 border pt-3 mb-2" id="editorarea">
            @foreach ($components as $component)
                <?php
                    $display = true;
                    if(isset($component->display)){
                        $display = $component->display;
                    }
                ?>
                @switch($component->component)
                    @case('content')
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1 col-md-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                    <div class="col-5 col-md-8">Content</div>
                                    <div class="col-4 col-md-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="display{{$loop->index}}" @if($display) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-1 text-end">
                                        <button type="button" class="btn-close delete-component"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body content-component content-editor" blockid="{{$loop->index}}" componenttype="content" editid="mycedit{{$loop->index}}" contenteditable="true" id="mycedit{{$loop->index}}">
                                {!! html_entity_decode($component->content) !!}
                            </div>
                        </div>
                        @break
                    @case('blockquote')
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1 col-md-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                    <div class="col-5 col-md-8">Blockquote</div>
                                    <div class="col-4 col-md-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="display{{$loop->index}}" @if($display) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-1 text-end">
                                        <button type="button" class="btn-close delete-component"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body content-component" blockid="{{$loop->index}}" componenttype="blockquote" editid="mycedit{{$loop->index}}">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="quotetitle{{$loop->index}}" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="quotetitle{{$loop->index}}" name="quotetitle{{$loop->index}}" value="{{$component->title}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="mycedit{{$loop->index}}" class="form-label">Content</label>
                                        <div class="col-12 border content-editor" contenteditable="true" id="mycedit{{$loop->index}}">
                                            {!! html_entity_decode($component->content) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="quotecredit{{$loop->index}}" class="form-label">Credit</label>
                                        <input type="text" class="form-control" id="quotecredit{{$loop->index}}" name="quotecredit{{$loop->index}}" value="{{$component->credit}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @case('image-left')
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                    <div class="col-8">Image Left</div>
                                    <div class="col-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="display{{$loop->index}}" @if($display) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                        </div>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button type="button" class="btn-close delete-component"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body content-component" blockid="{{$loop->index}}" componenttype="image-left" editid="mycedit{{$loop->index}}">
                                <div class="row">
                                    <div class="col-6 border">
                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="image{{$loop->index}}">
                                                    Browse
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <img src="{{$component->image}}" class="img-fluid image-content-mockup" id="image{{$loop->index}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="image{{$loop->index}}title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="image{{$loop->index}}title" name="image{{$loop->index}}title" value="{{$component->imagetitle}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 border content-editor" contenteditable="true" id="mycedit{{$loop->index}}">
                                        {!! html_entity_decode($component->content) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @case('image-right')
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                    <div class="col-8">Image Right</div>
                                    <div class="col-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="display{{$loop->index}}" @if($display) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                        </div>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button type="button" class="btn-close delete-component"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body content-component" blockid="{{$loop->index}}" componenttype="{{$component->component}}" editid="mycedit{{$loop->index}}">
                                <div class="row">
                                    <div class="col-6 border content-editor" contenteditable="true" id="mycedit{{$loop->index}}">
                                        {!! html_entity_decode($component->content) !!}
                                    </div>
                                    <div class="col-6 border">
                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="image{{$loop->index}}">
                                                    Browse
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <img src="{{$component->image}}" class="img-fluid image-content-mockup" id="image{{$loop->index}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="image{{$loop->index}}title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="image{{$loop->index}}title" name="image{{$loop->index}}title" value="{{$component->imagetitle}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @case('double-image')
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                    <div class="col-8">Double Image</div>
                                    <div class="col-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="display{{$loop->index}}" @if($display) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                        </div>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button type="button" class="btn-close delete-component"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body content-component" blockid="{{$loop->index}}" componenttype="{{$component->component}}" editid="mycedit{{$loop->index}}">
                                <div class="row">
                                    <div class="col-6 border">
                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="imageleft{{$loop->index}}">
                                                    Browse
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <img src="" class="img-fluid image-content-mockup" id="imageleft{{$loop->index}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="imageleft{{$loop->index}}title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="imageleft{{$loop->index}}title" name="imageleft{{$loop->index}}title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 border">
                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="imageright{{$loop->index}}">
                                                    Browse
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <img src="" class="img-fluid image-content-mockup" id="imageright{{$loop->index}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="imageright{{$loop->index}}title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="imageright{{$loop->index}}title" name="imageright{{$loop->index}}title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @case('single-image')
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1 col-md-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                    <div class="col-5 col-md-8">Single Image</div>
                                    <div class="col-4 col-md-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="display{{$loop->index}}" @if($display) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-1 text-end">
                                        <button type="button" class="btn-close delete-component"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body content-component" blockid="{{$loop->index}}" componenttype="single-image" editid="mycedit{{$loop->index}}">
                                <div class="row">
                                    <div class="col-12 border">
                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="image{{$loop->index}}">
                                                    Browse
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <img src="{{$component->image}}" class="img-fluid image-content-mockup" id="image{{$loop->index}}"/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="image{{$loop->index}}title" class="form-label">Caption</label>
                                                <input type="text" class="form-control" id="image{{$loop->index}}title" name="image{{$loop->index}}title" value="{{$component->imagetitle}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                @endswitch
            @endforeach
        </div>
    </div>
</div>
