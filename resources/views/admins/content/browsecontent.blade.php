<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Browse</title>
        @include('layout.inc-stylesheet')
        <link rel="icon" href="{{ asset('/assets/images/icon-spacebar.png')}}" type="image/icon type">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .card-img-top {
                height: 15vw;
                object-fit: cover;
            }
            .card-body {
                height: 69px;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid px-4">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="row pb-3">
                        <div class="col-4 col-md-6">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="selContent">Select</button>
                        </div>
                        <div class="col-8 col-md-6 text-end">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-primary" id="search" placeholder="Search" aria-label="Search" aria-describedby="search-btn">
                                <button class="btn btn-outline-primary" type="button" id="search-btn">Search</button>
                            </div>                              
                        </div>
                    </div>
                    <div class="row pt-3 border" id="content-display">
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2 text-end">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end" id="pagination">
                                  <li class="page-item" id="previous-btn"><a class="page-link" href="#">Previous</a></li>
                                  <li class="page-item" id="next-btn"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layout.inc-javascript')
        <script src="{{asset('/assets/js/validate.js')}}"></script>
        <script type="text/javascript">
            let currentPage = 1;
            let totalPage = 0;
            let searchtext = '';
            $(function(){
                loadContent(currentPage);
                $('#selContent').on('click',function(){
                    selectedContent();
                })
                $('#previous-btn').on('click',function(){
                    if(totalPage !== 0){
                        if(currentPage !== 1) {
                            currentPage--;
                            loadContent(currentPage)
                        }
                    }
                })
                $('#next-btn').on('click',function(){
                    if(totalPage !== 0){
                        if(currentPage !== totalPage) {
                            currentPage++;
                            loadContent(currentPage)
                        }
                    }
                    
                })
                $('#search-btn').on('click',function(){
                    currentPage = 1;
                    searchtext = $('#search').val();
                    loadContent(currentPage);
                })
            });

            const selectedContent = () => {
                if($('.selected').length > 0)
                {
                    let contentLists = [];
                    $.each($('.selected'),function(index,value){
                        let imageObj = {}
                        imageObj.id = $(value).attr('id');
                        imageObj.url = $(value).find('.card-img-top').attr('src');
                        imageObj.title = $(value).find('.card-title').text();
                        contentLists.push(imageObj);
                    })
                    parent.selContentSuccess(contentLists);
                }
            }

            const loadContent = (page) => {
                $.ajax({
                    url:"{{route('loadcontent')}}?page="+page+"&search="+searchtext,
                    method:"GET",
                    beforeSend: function( xhr ) {
                        let progress = `
                        <div class="col-12">
                            <div class="progress mt-2" id="progress">
                                <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        `;
                        $('#content-display').html(progress);
                    },
                    success:function(response){
                        $('#content-display').html('');
                        $.each(response.items,function(index,value){
                            let card = `
                                <div class="col-6 col-md-3 pb-3">
                                    <div class="card" id="${value.sys.id}">
                                        <img src="${value.thumbnail.url}" class="card-img-top" alt="${value.title}">
                                        <div class="card-body">
                                            <span class="card-title">${value.title}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#content-display').append(card);
                        });
                        bindCard();
                        if(response.page !== 0){
                            totalPage = response.page;
                            if(page === 1) {
                                $('#previous-btn').addClass('disabled');
                            }else{
                                $('#previous-btn').removeClass('disabled');
                            }
                            if(page === response.page){
                                $('#next-btn').addClass('disabled');
                            }else{
                                $('#next-btn').removeClass('disabled');
                            }
                        }else{
                            totalPage = 0;
                            $('#previous-btn').addClass('disabled');
                            $('#next-btn').addClass('disabled');
                        }
                    }
                })
            }

            const bindCard = () => {
                $('.card').unbind('click');
                $('.card').on('click',function(){
                    $(this).toggleClass("border-primary border-3 selected");
                })
            }
        </script>
    </body>
</html>
