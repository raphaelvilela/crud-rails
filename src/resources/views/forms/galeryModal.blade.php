<div id="galery-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Escolha sua foto!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach(\App\Tag::findStandardPhotosByTag($tagId) as $photo)
                        <div class="col-md-4 text-center">
                            <a href="javascript:void(0);"
                               onclick="choosePhotoFromGalery({{$photo->id}}, '{{$photo->url}}', '{{$photo->name}}')">
                                <span>{{$photo->name}}</span>
                                <img src="{{$photo->url}}" class="thumbnail" width="100%"/>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>