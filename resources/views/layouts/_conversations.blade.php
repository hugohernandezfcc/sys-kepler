<div class="social-feed-separated">
    @foreach ($comments as $conversations)
    <div class="social-avatar question-{{ $conversations['Question']->id }}">
        <a href=""><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $conversations['Question']->user->avatar) }}"></a>
    </div>
    <div class="social-feed-box question-{{ $conversations['Question']->id }}">
        <div class="social-avatar">
            <a href="/profile/user/{{ $conversations['Question']->user->id }}">{{ $conversations['Question']->user->name }}</a><small class="text-muted" id="time-{{ $conversations['Question']->id }}"> - {{ $conversations['Question']->updated_at->diffForHumans() }}</small>
            @if ($conversations['Question']->user->id === Auth::user()->id AND $conversations['Question']->name !== 'este comentario se ha eliminado')
                <button type="button" id="delete-{{ $conversations['Question']->id }}" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationId="{{ $conversations['Question']->id }}" data-typeConversation="Question" data-textSelector="question-{{ $conversations['Question']->id }}" title="Eliminar comentario">×</button>
            @endif
        </div>
        <div class="social-body">
            @if ($conversations['Question']->name !== 'este comentario se ha eliminado')
                <p id="question-{{ $conversations['Question']->id }}">{{ $conversations['Question']->name }}</p><br>
            @else
                <p id="question-{{ $conversations['Question']->id }}" class="font-italic">{{ $conversations['Question']->name }}</p><br>
            @endif
            <div class="btn-group">
                <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $conversations['Question']->id }})"><i class="fa fa-comments"></i> Comentar</a>
            </div>
        </div>
        <div class="social-footer">
            @if (count($conversations['Answer'][0]) > 0)
            @foreach ($conversations['Answer'][0] as $itemConversation)
            <div class="social-comment">
                <a href="" class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemConversation->user->avatar) }}"></a>
                <div class="media-body">
                    <a href="/profile/user/{{ $itemConversation->user->id }}">{{ $itemConversation->user->name }}</a>  {{ $itemConversation->name }}<br>
                    <div class="btn-group">
                        <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $itemConversation->id }})"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">{{ $itemConversation->updated_at->diffForHumans() }}</small>
                    </div>
                </div>

                @if (count($itemConversation['AnswerToAnswer']) > 0)
                @foreach ($itemConversation['AnswerToAnswer'] as $itemAnswer)
                <div class="social-comment">
                    <a href="" class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemAnswer->user->avatar) }}"></a>
                    <div class="media-body">
                        <a href="/profile/user/{{ $itemAnswer->user->id }}">{{ $itemAnswer->user->name }}</a> {{ $itemAnswer->name }}<br><small class="text-muted">{{ $itemAnswer->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endforeach
                @endif

                <div class="social-comment hidden" id="comentario{{ $itemConversation->id }}">
                    <a href="" class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                    <div class="media-body">
                        <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe un comentario..."></textarea>
                    </div>
                </div>
            </div>

            @endforeach
            @endif
            <div class="social-comment hidden" id="comentario{{ $conversations['Question']->id }}">
                <a href="" class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                <div class="media-body">
                    <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer', {{ $conversations['Question']->id }})" placeholder="Escribe un comentario..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="hr-line-dashed question-{{ $conversations['Question']->id }}"></div>

    @endforeach 

    <div id='ultimo_comentario'>
        <div class="social-avatar">
            <a href=""><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
        </div>
        <div class="media-body">
            <textarea class="form-control" onkeypress="pulsar(this, event, 'Question', null)" placeholder="Escribe un comentario..."></textarea>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteConversation" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Confirmar</h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center">¿Esta seguro que desea eliminar el comentario?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" id="buttonConfirmDelete" onclick="" class="btn btn-primary primary">Aceptar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#confirmDeleteConversation').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var textSelector = button.data('textselector');
        var conversationId = button.data('conversationid');
        var typeConversation = button.data('typeconversation');
        $("#buttonConfirmDelete").removeAttr('onclick');
        $('#buttonConfirmDelete').attr('onClick', 'deleteConversation("'+ textSelector +'", "'+ conversationId +'", "'+ typeConversation +'");');
    });

    function deleteConversation(textSelector, conversationId, typeConversation) {
        $.ajax({
            url: "/itemsconversations/destroy",
            data: { 
                "itemConversationId":conversationId,
                "type":typeConversation,
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.result === 'delete') {
                    $('.' + textSelector).remove();
                } else if (result.result === 'update') {
                    $('#' + textSelector).css('font-style', 'italic');
                    $('#' + textSelector).html(result.itemConversation.name);
                    $('#time-' + conversationId).html(' - ' + result.time);
                    $('#delete-' + conversationId).remove();
                }
                $('#confirmDeleteConversation').modal('hide'); 
            },
            error: function () {
            //alert("fallo");
            }
        });
    }

    
    function agregarComentario(tabla, comentario, tipoComentario, idParent) {
        idRecord = $('#idRecord').val();
        var imagenUsuario = '';
        imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
        $.ajax({
            url: "/conversations/store",
            data: { 
                "table":tabla,
                "id_record":idRecord,
                "comentario":comentario,
                "type":tipoComentario,
                "parent":idParent,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.type === 'Question') {
                    var answer = "\'Answer\'";
                    var html = '<div class="social-avatar question-'+result.id+'"><a href=""><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box question-'+result.id+'"><div class="social-avatar"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationId="'+result.id+'" data-typeConversation="Question" data-textSelector="question-'+result.id+'" title="Eliminar comentario">×</button></div>\n\
                    <div class="social-body"><p id="question-'+result.id+'">'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..." maxlength="250"></textarea></div></div></div></div><div class="hr-line-dashed question-'+result.id+'"></div>';
                    $('#ultimo_comentario').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a>  '+  result.name+'<br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">'+result.tiempo+'</small></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"> <img alt="image" class="img-circle" src="'+imagenUsuario+'"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..." maxlength="250"></textarea></div></div></div>';
                    $('#comentario'+result.parent).before(html);
                } else {
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a>  '+  result.name+'<br><small class="text-muted">'+result.tiempo+'</small></div></div>';
                    $('#comentario'+result.parent).before(html);
                }
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
    
    function habilitarComentario(idCampo) {
        if ($('#comentario'+idCampo).hasClass("hidden")) {
            $('#comentario'+idCampo).removeClass("hidden");
        }
        $('#comentario'+idCampo+' textarea').focus();    
    }
</script>